<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h3 class="mb-3">Edit Transaksi</h3>

    <div class="card">
        <div class="card-body">

            <form action="<?= base_url('/transactions/update/' . $transaction['transaction_id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= esc($user['user_id']) ?>" <?= old('user_id', $transaction['user_id']) == $user['user_id'] ? 'selected' : '' ?>>
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
                            <?php
                                // Untuk produk yang sedang dipilih di transaksi ini, stok yang
                                // ditampilkan perlu ditambah qty lama, karena stok di DB sudah
                                // "terpotong" oleh transaksi ini sebelumnya.
                                $displayStock = $product['qty_in_stock'];
                                if ((int) $product['product_id'] === (int) $transaction['product_id']) {
                                    $displayStock += (int) $transaction['qty'];
                                }
                            ?>
                            <option
                                value="<?= esc($product['product_id']) ?>"
                                data-stock="<?= esc($displayStock) ?>"
                                data-price="<?= esc($product['price']) ?>"
                                <?= old('product_id', $transaction['product_id']) == $product['product_id'] ? 'selected' : '' ?>
                            >
                                <?= esc($product['product_name']) ?> (Stok tersedia: <?= esc($displayStock) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text" id="stockInfo">Stok di atas sudah memperhitungkan transaksi ini.</div>
                </div>

                <div class="mb-3">
                    <label for="qty" class="form-label">Jumlah (Qty)</label>
                    <input
                        type="number"
                        name="qty"
                        id="qty"
                        class="form-control"
                        min="1"
                        value="<?= esc(old('qty', $transaction['qty'])) ?>"
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
                            $selectedMethod = old('payment_method', $transaction['payment_method']);
                        ?>
                        <?php foreach ($paymentMethods as $value => $label): ?>
                            <option value="<?= esc($value) ?>" <?= $selectedMethod === $value ? 'selected' : '' ?>>
                                <?= esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Transaksi</button>
                <a href="<?= base_url('/transactions') ?>" class="btn btn-secondary">Batal</a>
            </form>

        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
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