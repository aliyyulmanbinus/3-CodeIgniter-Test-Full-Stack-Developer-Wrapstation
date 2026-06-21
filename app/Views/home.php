<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm">
        <h1 class="display-6 fw-bold">Test No 3 CodeIgniter CMS User-Transaction-Product </h1>
        <p class="col-md-8 fs-5 text-muted">
            Nama : Aliyyulman jihan <br>
            Posisi : Full Stack Developer
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Total User</h6>
                    <p class="display-5 fw-bold mb-3"><?= esc($totalUsers) ?></p>
                    <a href="<?= base_url('/users') ?>" class="btn btn-outline-primary w-100">Kelola User</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Total Produk</h6>
                    <p class="display-5 fw-bold mb-3"><?= esc($totalProducts) ?></p>
                    <a href="<?= base_url('/products') ?>" class="btn btn-outline-primary w-100">Kelola Produk</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted text-uppercase">Total Transaksi</h6>
                    <p class="display-5 fw-bold mb-3"><?= esc($totalTransactions) ?></p>
                    <a href="<?= base_url('/transactions') ?>" class="btn btn-outline-primary w-100">Kelola Transaksi</a>
                </div>
            </div>
        </div>

    </div>

<?= $this->endSection() ?>