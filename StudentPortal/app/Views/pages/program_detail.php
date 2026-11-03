<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<header class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Program Studi</li>
            </ol>
        </nav>
        <h1 class="fw-bold"><?= esc($program['nama']) ?> <span class="opacity-75">(<?= esc($program['kode']) ?>)</span></h1>
        <p><?= esc($program['fakultas']) ?></p>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="surface p-4">
            <h2 class="h5 fw-bold">Tentang program</h2>
            <p class="mb-3"><?= esc($program['deskripsi']) ?></p>
            <div class="stat-value"><?= count($mahasiswa) ?></div>
            <div class="stat-label">mahasiswa terdaftar</div>
        </div>
    </div>
    <div class="col-lg-8">
        <h2 class="h5 fw-bold mb-3">Daftar mahasiswa</h2>
        <?php if ($mahasiswa === []) : ?>
            <div class="surface empty-state">
                <i class="bi bi-people" aria-hidden="true"></i>
                <p class="mt-2 mb-0">Belum ada mahasiswa di program studi ini.</p>
            </div>
        <?php else : ?>
            <div class="row g-3">
                <?php foreach ($mahasiswa as $m) : ?>
                    <div class="col-md-6">
                        <div class="surface mhs-card position-relative d-flex gap-3 align-items-center">
                            <?= view('partials/avatar', ['m' => $m]) ?>
                            <div>
                                <a href="<?= site_url('mahasiswa/' . esc($m['nim'], 'url')) ?>" class="stretched-link"><?= esc($m['nama']) ?></a>
                                <div class="mhs-meta"><?= esc($m['nim']) ?> &middot; Angkatan <?= esc($m['angkatan']) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</div>
<?= $this->endSection() ?>
