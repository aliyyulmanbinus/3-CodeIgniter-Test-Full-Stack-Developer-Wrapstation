<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Daftar User</h3>
        <a href="<?= base_url('/users/create') ?>" class="btn btn-primary">+ Tambah User</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada data user.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= esc($user['user_id']) ?></td>
                                <td><?= esc($user['name']) ?></td>
                                <td>
                                    <a href="<?= base_url('/users/edit/' . $user['user_id']) ?>" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="<?= base_url('/users/delete/' . $user['user_id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
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