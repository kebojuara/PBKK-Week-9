<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login · SIAKAD</title>
    <link href="<?= base_url('assets/sb-admin-2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/sb-admin-2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/siakad.css') ?>" rel="stylesheet">
</head>
<body class="login-bg d-flex align-items-center">
<?php $errors = session('errors') ?? []; ?>
<main class="container">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">
            <div class="card login-panel shadow-lg border-0">
                <div class="row no-gutters">
                    <div class="col-lg-5 login-side p-5 d-none d-lg-flex flex-column justify-content-between">
                        <div>
                            <span class="ikon mb-4"><i class="fas fa-university" aria-hidden="true"></i></span>
                            <h2 class="h4 font-weight-bold">Sistem Informasi Akademik</h2>
                            <p class="mb-0">KRS, input nilai, KHS, dan transkrip dalam satu tempat.</p>
                        </div>
                        <dl class="small mb-0">
                            <dt>Akun demo</dt>
                            <dd class="mb-1">Admin: <code>admin / admin123</code></dd>
                            <dd class="mb-1">Dosen: <code>0011018501</code> (password = NIDN)</dd>
                            <dd class="mb-0">Mahasiswa: <code>5025251001</code> (password = NIM)</dd>
                        </dl>
                    </div>
                    <div class="col-lg-7 p-5 bg-white">
                        <h1 class="h4 text-gray-900 font-weight-bold mb-1">Masuk SIAKAD</h1>
                        <p class="text-gray-600 mb-4">Gunakan NIM, NIDN, atau username admin.</p>
                        <?= $this->include('partials/alerts') ?>
                        <form action="<?= site_url('login') ?>" method="post" novalidate>
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <label for="username" class="font-weight-bold">NIM / NIDN / Username</label>
                                <input type="text" id="username" name="username" value="<?= esc(old('username')) ?>" autocomplete="username"
                                       class="form-control form-control-lg <?= isset($errors['username']) ? 'is-invalid' : '' ?>" required autofocus>
                                <div class="invalid-feedback"><?= esc($errors['username'] ?? '') ?></div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" id="password" name="password" autocomplete="current-password"
                                       class="form-control form-control-lg <?= isset($errors['password']) ? 'is-invalid' : '' ?>" required>
                                <div class="invalid-feedback"><?= esc($errors['password'] ?? '') ?></div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
