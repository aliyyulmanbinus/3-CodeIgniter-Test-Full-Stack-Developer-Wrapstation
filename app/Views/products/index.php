<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar Produk</h3>
        <a href="<?= base_url('/products/create') ?>" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data produk.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= esc($product['product_id']) ?></td>
                                <td><?= esc($product['product_name']) ?></td>
                                <td>
                                    <?php if ((int) $product['qty_in_stock'] === 0): ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php elseif ((int) $product['qty_in_stock'] <= 5): ?>
                                        <span class="badge bg-warning text-dark"><?= esc($product['qty_in_stock']) ?></span>
                                    <?php else: ?>
                                        <?= esc($product['qty_in_stock']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?= number_format((float) $product['price'], 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url('/products/edit/' . $product['product_id']) ?>" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="<?= base_url('/products/delete/' . $product['product_id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
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