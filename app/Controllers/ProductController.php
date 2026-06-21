<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    /**
     * READ - Tampilkan semua data produk
     */
    public function index()
    {
        $data = [
            'title'    => 'Daftar Produk',
            'products' => $this->productModel->orderBy('product_id', 'DESC')->findAll(),
        ];

        return view('products/index', $data);
    }

    /**
     * Tampilkan form tambah produk
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
        ];

        return view('products/create', $data);
    }

    /**
     * CREATE - Proses simpan produk baru
     */
    public function store()
    {
        $rules = [
            'product_name' => 'required|min_length[2]|max_length[150]',
            'qty_in_stock' => 'required|integer|greater_than_equal_to[0]',
            'price'        => 'required|decimal|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'product_name' => $this->request->getPost('product_name'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
            'price'        => $this->request->getPost('price'),
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit produk
     */
    public function edit($id)
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Produk',
            'product' => $product,
        ];

        return view('products/edit', $data);
    }

    /**
     * UPDATE - Proses update data produk
     */
    public function update($id)
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'product_name' => 'required|min_length[2]|max_length[150]',
            'qty_in_stock' => 'required|integer|greater_than_equal_to[0]',
            'price'        => 'required|decimal|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'product_name' => $this->request->getPost('product_name'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
            'price'        => $this->request->getPost('price'),
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * DELETE - Hapus data produk
     */
    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if (! $product) {
            return redirect()->to('/products')->with('error', 'Produk tidak ditemukan.');
        }

        $this->productModel->delete($id);

        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus.');
    }
}