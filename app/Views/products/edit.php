<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h3 class="mb-3">Edit Produk</h3>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('/products/update/' . $product['product_id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="product_name" class="form-label">Nama Produk</label>
                    <input
                        type="text"
                        name="product_name"
                        id="product_name"
                        class="form-control"
                        value="<?= esc(old('product_name', $product['product_name'])) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="qty_in_stock" class="form-label">Stok</label>
                    <input
                        type="number"
                        name="qty_in_stock"
                        id="qty_in_stock"
                        class="form-control"
                        min="0"
                        value="<?= esc(old('qty_in_stock', $product['qty_in_stock'])) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga (Rp)</label>
                    <input
                        type="number"
                        name="price"
                        id="price"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="<?= esc(old('price', $product['price'])) ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>