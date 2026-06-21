<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table         = 'transactions';
    protected $primaryKey    = 'transaction_id';
    protected $returnType    = 'array';

    protected $allowedFields = ['user_id', 'product_id', 'payment_method', 'qty'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'user_id'        => 'required|integer',
        'product_id'     => 'required|integer',
        'payment_method' => 'required|in_list[cash,debit,credit_card,e_wallet,bank_transfer]',
        'qty'            => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User wajib dipilih.',
        ],
        'product_id' => [
            'required' => 'Produk wajib dipilih.',
        ],
        'payment_method' => [
            'required' => 'Metode pembayaran wajib dipilih.',
            'in_list'  => 'Metode pembayaran tidak valid.',
        ],
        'qty' => [
            'required'     => 'Jumlah (qty) wajib diisi.',
            'integer'      => 'Jumlah harus berupa angka bulat.',
            'greater_than' => 'Jumlah minimal 1.',
        ],
    ];

    /**
     * Ambil semua transaksi lengkap dengan nama user & nama produk
     * (JOIN ke tabel users dan products), diurutkan dari yang terbaru.
     */
    public function getAllWithDetails(): array
    {
        return $this->select('
                transactions.*,
                users.name as user_name,
                products.product_name as product_name,
                products.price as product_price
            ')
            ->join('users', 'users.user_id = transactions.user_id')
            ->join('products', 'products.product_id = transactions.product_id')
            ->orderBy('transactions.transaction_id', 'DESC')
            ->findAll();
    }

    /**
     * Ambil 1 transaksi lengkap dengan nama user & produk berdasarkan ID.
     */
    public function getDetailById(int $id): ?array
    {
        return $this->select('
                transactions.*,
                users.name as user_name,
                products.product_name as product_name,
                products.price as product_price
            ')
            ->join('users', 'users.user_id = transactions.user_id')
            ->join('products', 'products.product_id = transactions.product_id')
            ->where('transactions.transaction_id', $id)
            ->first();
    }
}