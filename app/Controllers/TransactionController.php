<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\UserModel;
use App\Models\ProductModel;

class TransactionController extends BaseController
{
    protected TransactionModel $transactionModel;
    protected UserModel $userModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->userModel        = new UserModel();
        $this->productModel     = new ProductModel();
    }

    /**
     * READ - Tampilkan semua transaksi (lengkap dengan nama user & produk)
     */
    public function index()
    {
        $data = [
            'title'        => 'Daftar Transaksi',
            'transactions' => $this->transactionModel->getAllWithDetails(),
        ];

        return view('transactions/index', $data);
    }

    /**
     * Tampilkan form tambah transaksi.
     * Perlu kirim daftar user & produk untuk diisi ke dropdown.
     */
    public function create()
    {
        $data = [
            'title'    => 'Tambah Transaksi',
            'users'    => $this->userModel->orderBy('name', 'ASC')->findAll(),
            'products' => $this->productModel->orderBy('product_name', 'ASC')->findAll(),
        ];

        return view('transactions/create', $data);
    }

    /**
     * CREATE - Proses simpan transaksi baru + kurangi stok produk
     */
    public function store()
    {
        $rules = [
            'user_id'        => 'required|integer',
            'product_id'     => 'required|integer',
            'payment_method' => 'required|in_list[cash,debit,credit_card,e_wallet,bank_transfer]',
            'qty'            => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = (int) $this->request->getPost('product_id');
        $qty       = (int) $this->request->getPost('qty');

        // Pastikan produk benar-benar ada
        $product = $this->productModel->find($productId);

        if (! $product) {
            return redirect()->back()->withInput()->with('error', 'Produk tidak ditemukan.');
        }

        // Validasi stok mencukupi sebelum transaksi diproses
        if ($qty > $product['qty_in_stock']) {
            return redirect()->back()->withInput()->with(
                'error',
                'Stok tidak mencukupi. Stok tersedia: ' . $product['qty_in_stock']
            );
        }

        // Simpan transaksi
        $this->transactionModel->save([
            'user_id'        => $this->request->getPost('user_id'),
            'product_id'     => $productId,
            'payment_method' => $this->request->getPost('payment_method'),
            'qty'            => $qty,
        ]);

        // Kurangi stok produk sesuai qty yang dibeli
        $this->productModel->reduceStock($productId, $qty);

        return redirect()->to('/transactions')->with('success', 'Transaksi berhasil dibuat.');
    }

    /**
     * Tampilkan form edit transaksi
     */
    public function edit($id)
    {
        $transaction = $this->transactionModel->find($id);

        if (! $transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan.');
        }

        $data = [
            'title'       => 'Edit Transaksi',
            'transaction' => $transaction,
            'users'       => $this->userModel->orderBy('name', 'ASC')->findAll(),
            'products'    => $this->productModel->orderBy('product_name', 'ASC')->findAll(),
        ];

        return view('transactions/edit', $data);
    }

    /**
     * UPDATE Proses update transaksi.
     * Karena qty/produk bisa berubah, stok lama dikembalikan dulu,
     * baru stok baru dikurangi sesuai data yang baru disubmit.
     */
    public function update($id)
    {
        $transaction = $this->transactionModel->find($id);

        if (! $transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan.');
        }

        $rules = [
            'user_id'        => 'required|integer',
            'product_id'     => 'required|integer',
            'payment_method' => 'required|in_list[cash,debit,credit_card,e_wallet,bank_transfer]',
            'qty'            => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newProductId = (int) $this->request->getPost('product_id');
        $newQty       = (int) $this->request->getPost('qty');

        // Langkah 1: kembalikan dulu stok produk LAMA (sebelum diedit)
        $this->productModel->restoreStock((int) $transaction['product_id'], (int) $transaction['qty']);

        // Langkah 2: cek stok produk BARU (setelah stok lama dikembalikan)
        $newProduct = $this->productModel->find($newProductId);

        if (! $newProduct) {
            // Rollback: kurangi lagi seperti semula kalau produk baru tidak valid
            $this->productModel->reduceStock((int) $transaction['product_id'], (int) $transaction['qty']);

            return redirect()->back()->withInput()->with('error', 'Produk tidak ditemukan.');
        }

        if ($newQty > $newProduct['qty_in_stock']) {
            // Rollback juga di sini
            $this->productModel->reduceStock((int) $transaction['product_id'], (int) $transaction['qty']);

            return redirect()->back()->withInput()->with(
                'error',
                'Stok tidak mencukupi. Stok tersedia: ' . $newProduct['qty_in_stock']
            );
        }

        // Langkah 3: update transaksi dengan data baru
        $this->transactionModel->update($id, [
            'user_id'        => $this->request->getPost('user_id'),
            'product_id'     => $newProductId,
            'payment_method' => $this->request->getPost('payment_method'),
            'qty'            => $newQty,
        ]);

        // Langkah 4: kurangi stok produk BARU sesuai qty baru
        $this->productModel->reduceStock($newProductId, $newQty);

        return redirect()->to('/transactions')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * DELETE - Hapus transaksi + kembalikan stok produk
     */
    public function delete($id)
    {
        $transaction = $this->transactionModel->find($id);

        if (! $transaction) {
            return redirect()->to('/transactions')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Kembalikan stok produk sebelum data transaksi dihapus
        $this->productModel->restoreStock((int) $transaction['product_id'], (int) $transaction['qty']);

        $this->transactionModel->delete($id);

        return redirect()->to('/transactions')->with('success', 'Transaksi berhasil dihapus.');
    }
}