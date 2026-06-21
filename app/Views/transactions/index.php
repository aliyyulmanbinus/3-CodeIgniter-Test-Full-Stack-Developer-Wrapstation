<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Transaksi</h3>
        <a href="<?= base_url('/transactions/create') ?>" class="btn btn-primary">+ Tambah Transaksi</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>User</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Metode Bayar</th>
                        <th>Total</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data transaksi.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $trx): ?>
                            <tr>
                                <td><?= esc($trx['transaction_id']) ?></td>
                                <td><?= esc($trx['user_name']) ?></td>
                                <td><?= esc($trx['product_name']) ?></td>
                                <td><?= esc($trx['qty']) ?></td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= esc(ucwords(str_replace('_', ' ', $trx['payment_method']))) ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format((float) $trx['product_price'] * (int) $trx['qty'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url('/transactions/edit/' . $trx['transaction_id']) ?>" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="<?= base_url('/transactions/delete/' . $trx['transaction_id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok produk akan dikembalikan.');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?= $this->endSection() ?>