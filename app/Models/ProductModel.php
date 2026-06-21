<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'product_id';
    protected $returnType    = 'array';

    protected $allowedFields = ['product_name', 'qty_in_stock', 'price'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'product_name' => 'required|min_length[2]|max_length[150]',
        'qty_in_stock' => 'required|integer|greater_than_equal_to[0]',
        'price'        => 'required|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'product_name' => [
            'required'   => 'Nama produk wajib diisi.',
            'min_length' => 'Nama produk minimal 2 karakter.',
        ],
        'qty_in_stock' => [
            'required'             => 'Stok wajib diisi.',
            'integer'              => 'Stok harus berupa angka bulat.',
            'greater_than_equal_to'=> 'Stok tidak boleh negatif.',
        ],
        'price' => [
            'required'             => 'Harga wajib diisi.',
            'decimal'              => 'Harga harus berupa angka.',
            'greater_than_equal_to'=> 'Harga tidak boleh negatif.',
        ],
    ];

    /**
     * Mengurangi stok produk sebanyak $qty.
     * Dipakai saat ada transaksi baru.
     */
    public function reduceStock(int $productId, int $qty): bool
    {
        $product = $this->find($productId);

        if (! $product) {
            return false;
        }

        $newStock = max(0, $product['qty_in_stock'] - $qty);

        return (bool) $this->update($productId, ['qty_in_stock' => $newStock]);
    }

    /**
     * Mengembalikan stok produk sebanyak $qty.
     * Dipakai saat transaksi dihapus/dibatalkan.
     */
    public function restoreStock(int $productId, int $qty): bool
    {
        $product = $this->find($productId);

        if (! $product) {
            return false;
        }

        $newStock = $product['qty_in_stock'] + $qty;

        return (bool) $this->update($productId, ['qty_in_stock' => $newStock]);
    }
}