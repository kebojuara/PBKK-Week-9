<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'StudentPortal') ?> · StudentPortal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/portal.css') ?>" rel="stylesheet">
</head>
<body>
<a class="visually-hidden-focusable skip-link" href="#konten">Lewati ke konten</a>

<?php $uri = service('uri')->getSegment(1); ?>
<nav class="navbar navbar-expand-lg portal-nav sticky-top" aria-label="Navigasi utama">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= site_url('/') ?>">
            <span class="brand-mark" aria-hidden="true">SP</span>
            <span>Student<strong>Portal</strong></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUtama"
                aria-controls="navUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link <?= $uri === '' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link <?= in_array($uri, ['direktori', 'mahasiswa'], true) ? 'active' : '' ?>" href="<?= site_url('direktori') ?>">Direktori</a></li>
                <li class="nav-item"><a class="nav-link <?= $uri === 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">Tentang</a></li>
                <li class="nav-item"><a class="nav-link <?= $uri === 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Kontak</a></li>
                <li class="nav-item ms-lg-2">
                    <?php if (session('isLoggedIn')) : ?>
                        <a class="btn btn-portal btn-sm" href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2" aria-hidden="true"></i> Panel Admin</a>
                    <?php else : ?>
                        <a class="btn btn-outline-portal btn-sm" href="<?= site_url('login') ?>"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i> Login Petugas</a>
                    <?php endif ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main id="konten">
    <?= $this->renderSection('hero') ?>
    <div class="container py-5">
        <?= $this->include('partials/alerts') ?>
        <?= $this->renderSection('content') ?>
    </div>
</main>

<footer class="portal-footer">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 py-4">
        <span>&copy; <?= date('Y') ?> StudentPortal &middot; Tugas PBKK Pertemuan 9</span>
        <span>Dibangun dengan CodeIgniter <?= \CodeIgniter\CodeIgniter::CI_VERSION ?> &amp; Bootstrap 5</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
