<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<header class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= site_url('direktori') ?>">Direktori</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($mahasiswa['nim']) ?></li>
            </ol>
        </nav>
        <h1 class="fw-bold mb-0"><?= esc($mahasiswa['nama']) ?></h1>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="surface p-4 p-md-5">
    <div class="row g-4 align-items-center">
        <div class="col-md-auto text-center">
            <?= view('partials/avatar', ['m' => $mahasiswa, 'class' => 'avatar-xl']) ?>
        </div>
        <div class="col-md">
            <dl class="row info-list mb-0">
                <dt class="col-sm-4">NIM</dt>
                <dd class="col-sm-8"><?= esc($mahasiswa['nim']) ?></dd>
                <dt class="col-sm-4">Program studi</dt>
                <dd class="col-sm-8"><a href="<?= site_url('program/' . esc($mahasiswa['slug_prodi'], 'url')) ?>"><?= esc($mahasiswa['nama_prodi']) ?></a></dd>
                <dt class="col-sm-4">Angkatan</dt>
                <dd class="col-sm-8"><?= esc($mahasiswa['angkatan']) ?></dd>
                <dt class="col-sm-4">Terdaftar sejak</dt>
                <dd class="col-sm-8"><?= esc(date('d M Y', strtotime($mahasiswa['created_at']))) ?></dd>
            </dl>
        </div>
    </div>
</div>
<p class="mhs-meta mt-3 mb-0"><i class="bi bi-shield-lock" aria-hidden="true"></i> Email dan IPK hanya dapat dilihat petugas melalui panel admin.</p>
<?= $this->endSection() ?>
