<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h3 class="mb-3">Edit User</h3>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('/users/update/' . $user['user_id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Masukkan nama user"
                        value="<?= esc(old('name', $user['name'])) ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('/users') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>