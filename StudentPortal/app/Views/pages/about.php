<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<header class="page-header">
    <div class="container">
        <h1 class="fw-bold">Tentang StudentPortal</h1>
        <p>Latihan CodeIgniter 4 untuk mata kuliah Pemrograman Berbasis Kerangka Kerja.</p>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="surface p-4 p-md-5 h-100">
            <h2 class="h4 fw-bold">Apa ini?</h2>
            <p>StudentPortal adalah aplikasi web pendaftaran mahasiswa yang dibangun dengan pola <strong>Model-View-Controller</strong>.
               Pengunjung dapat melihat program studi dan direktori mahasiswa, sedangkan petugas akademik mengelola data melalui panel admin.</p>
            <p class="mb-0">Aplikasi ini melanjutkan seri Student Registration dari pertemuan sebelumnya (Avalonia + EF Core / ADO.NET),
               kali ini dalam bentuk aplikasi web PHP.</p>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="surface p-4 p-md-5 h-100">
            <h2 class="h4 fw-bold">Materi yang diterapkan</h2>
            <ol class="mb-0 d-grid gap-1">
                <li>Instalasi &amp; konfigurasi (.env, migration, seeder)</li>
                <li>Routing &amp; controller</li>
                <li>View dengan layout Bootstrap 5</li>
                <li>Template admin SB Admin 2</li>
                <li>Model &amp; CRUD (validasi, pencarian, pagination)</li>
                <li>Upload foto mahasiswa</li>
                <li>Login &amp; hak akses (admin / staff)</li>
            </ol>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
