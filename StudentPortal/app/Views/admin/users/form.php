<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $user !== null;
$errors = session('errors') ?? [];
$nilai  = static fn (string $f) => old($f, $user[$f] ?? '');
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/users') ?>">Kelola User</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

<div class="card shadow mb-4" style="max-width: 40rem">
    <div class="card-body">
        <form action="<?= $isEdit ? site_url('admin/users/' . $user['id']) : site_url('admin/users') ?>" method="post" novalidate>
            <?= csrf_field() ?>
            <?php if ($isEdit) : ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif ?>
            <div class="form-group">
                <label for="nama" class="font-weight-bold">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= esc($nilai('nama')) ?>"
                       class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= esc($errors['nama'] ?? '') ?></div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-7">
                    <label for="username" class="font-weight-bold">Username</label>
                    <input type="text" id="username" name="username" value="<?= esc($nilai('username')) ?>" autocomplete="off"
                           class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= esc($errors['username'] ?? '') ?></div>
                </div>
                <div class="form-group col-md-5">
                    <label for="role" class="font-weight-bold">Role</label>
                    <select id="role" name="role" class="form-control <?= isset($errors['role']) ? 'is-invalid' : '' ?>">
                        <option value="staff" <?= $nilai('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                        <option value="admin" <?= $nilai('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <div class="invalid-feedback"><?= esc($errors['role'] ?? '') ?></div>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="font-weight-bold">Password</label>
                <input type="password" id="password" name="password" autocomplete="new-password" aria-describedby="password-help"
                       class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>">
                <small id="password-help" class="form-text text-muted">
                    <?= $isEdit ? 'Kosongkan jika tidak ingin mengganti password.' : 'Minimal 6 karakter.' ?>
                    Password disimpan dalam bentuk hash (<code>password_hash</code>).
                </small>
                <div class="invalid-feedback"><?= esc($errors['password'] ?? '') ?></div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="<?= site_url('admin/users') ?>" class="btn btn-light ml-2">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
