<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h3 class="mb-3">Tambah Transaksi</h3>

    <div class="card">
        <div class="card-body">

            <?php if (empty($users)): ?>
                <div class="alert alert-warning">
                    Belum ada data User. Silakan <a href="<?= base_url('/users/create') ?>">tambah User</a> terlebih dahulu.
                </div>
            <?php elseif (empty($products)): ?>
                <div class="alert alert-warning">
                    Belum ada data Produk. Silakan <a href="<?= base_url('/products/create') ?>">tambah Produk</a> terlebih dahulu.
                </div>
            <?php else: ?>

                <form action="<?= base_url('/transactions/store') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= esc($user['user_id']) ?>" <?= old('user_id') == $user['user_id'] ? 'selected' : '' ?>>
                                    <?= esc($user['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Produk</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($products as $product): ?>
                                <option
                                    value="<?= esc($product['product_id']) ?>"
                                    data-stock="<?= esc($product['qty_in_stock']) ?>"
                                    data-price="<?= esc($product['price']) ?>"
                                    <?= old('product_id') == $product['product_id'] ? 'selected' : '' ?>
                                >
                                    <?= esc($product['product_name']) ?> (Stok: <?= esc($product['qty_in_stock']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text" id="stockInfo">Pilih produk untuk melihat info stok.</div>
                    </div>

                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah (Qty)</label>
                        <input
                            type="number"
                            name="qty"
                            id="qty"
                            class="form-control"
                            min="1"
                            value="<?= esc(old('qty', 1)) ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <?php
                                $paymentMethods = [
                                    'cash'          => 'Cash',
                                    'debit'         => 'Debit',
                                    'credit_card'   => 'Credit Card',
                                    'e_wallet'      => 'E-Wallet',
                                    'bank_transfer' => 'Bank Transfer',
                                ];
                            ?>
                            <?php foreach ($paymentMethods as $value => $label): ?>
                                <option value="<?= esc($value) ?>" <?= old('payment_method') === $value ? 'selected' : '' ?>>
                                    <?= esc($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                    <a href="<?= base_url('/transactions') ?>" class="btn btn-secondary">Batal</a>
                </form>

            <?php endif; ?>

        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Menampilkan info stok produk secara real-time saat dropdown produk diganti.
    // Ini murni untuk kenyamanan user (UX), validasi sesungguhnya tetap di server.
    document.addEventListener('DOMContentLoaded', function () {
        const productSelect = document.getElementById('product_id');
        const stockInfo = document.getElementById('stockInfo');
        const qtyInput = document.getElementById('qty');

        if (!productSelect) return;

        function updateStockInfo() {
            const selected = productSelect.options[productSelect.selectedIndex];
            const stock = selected ? selected.getAttribute('data-stock') : null;

            if (stock !== null && selected.value !== '') {
                stockInfo.textContent = 'Stok tersedia: ' + stock;
                qtyInput.setAttribute('max', stock);
            } else {
                stockInfo.textContent = 'Pilih produk untuk melihat info stok.';
                qtyInput.removeAttribute('max');
            }
        }

        productSelect.addEventListener('change', updateStockInfo);
        updateStockInfo();
    });
</script>
<?= $this->endSection() ?>