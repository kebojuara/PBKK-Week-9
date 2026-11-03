<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<header class="page-header">
    <div class="container">
        <h1 class="fw-bold">Direktori Mahasiswa</h1>
        <p>Cari berdasarkan nama atau NIM, lalu saring per program studi.</p>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<form method="get" action="<?= site_url('direktori') ?>" class="surface p-3 p-md-4 mb-4" role="search">
    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label for="q" class="form-label">Kata kunci</label>
            <input type="search" id="q" name="q" value="<?= esc($keyword) ?>" class="form-control" placeholder="contoh: Andi atau 5025241001">
        </div>
        <div class="col-md-4">
            <label for="prodi" class="form-label">Program studi</label>
            <select id="prodi" name="prodi" class="form-select">
                <option value="">Semua program studi</option>
                <?php foreach ($programStudi as $p) : ?>
                    <option value="<?= $p['id'] ?>" <?= $prodiId === (int) $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-portal"><i class="bi bi-search" aria-hidden="true"></i> Cari</button>
        </div>
    </div>
</form>

<p class="mhs-meta" aria-live="polite">
    Menampilkan <?= count($mahasiswa) ?> dari <?= $pager->getTotal() ?> mahasiswa
    <?= $keyword !== '' ? 'untuk “' . esc($keyword) . '”' : '' ?>
</p>

<?php if ($mahasiswa === []) : ?>
    <div class="surface empty-state">
        <i class="bi bi-person-x" aria-hidden="true"></i>
        <p class="mt-2 mb-0">Tidak ada mahasiswa yang cocok dengan pencarian.</p>
    </div>
<?php else : ?>
    <div class="row g-3">
        <?php foreach ($mahasiswa as $m) : ?>
            <div class="col-md-6 col-lg-3">
                <div class="surface mhs-card position-relative h-100 d-flex gap-3 align-items-center">
                    <?= view('partials/avatar', ['m' => $m]) ?>
                    <div class="min-w-0">
                        <a href="<?= site_url('mahasiswa/' . esc($m['nim'], 'url')) ?>" class="stretched-link"><?= esc($m['nama']) ?></a>
                        <div class="mhs-meta"><?= esc($m['nim']) ?></div>
                        <div class="mhs-meta"><?= esc($m['nama_prodi']) ?> &middot; <?= esc($m['angkatan']) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
<?php endif ?>
<?= $this->endSection() ?>
