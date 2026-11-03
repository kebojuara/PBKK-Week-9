<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="surface p-4 p-md-5">
            <div class="text-center mb-4">
                <span class="brand-mark mb-3" style="width:3rem;height:3rem" aria-hidden="true">SP</span>
                <h1 class="h3 fw-bold mb-1">Login Petugas</h1>
                <p class="mhs-meta mb-0">Masuk untuk mengelola data mahasiswa.</p>
            </div>
            <form action="<?= site_url('login') ?>" method="post" novalidate>
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" value="<?= esc(old('username')) ?>" autocomplete="username"
                           class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" required autofocus>
                    <div class="invalid-feedback"><?= esc($errors['username'] ?? '') ?></div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password"
                           class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" required>
                    <div class="invalid-feedback"><?= esc($errors['password'] ?? '') ?></div>
                </div>
                <button type="submit" class="btn btn-portal btn-lg w-100">Masuk</button>
            </form>
            <p class="mhs-meta small text-center mt-4 mb-0">Akun demo: <code>admin / admin123</code> &middot; <code>staff / staff123</code></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
