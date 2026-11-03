<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<section class="hero pt-5 pb-5" aria-labelledby="judul-hero">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="hero-eyebrow mb-3"><i class="bi bi-mortarboard" aria-hidden="true"></i> Penerimaan Mahasiswa 2026/2027</span>
                <h1 id="judul-hero" class="mt-3 mb-3">Satu portal untuk data mahasiswa &amp; program studi.</h1>
                <p class="lead mb-4">Telusuri program studi, temukan rekan satu angkatan, dan hubungi bagian akademik tanpa perlu antre di loket.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= site_url('direktori') ?>" class="btn btn-light btn-lg">Buka Direktori</a>
                    <a href="#program-studi" class="btn btn-outline-light btn-lg">Lihat Program Studi</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="surface p-4 text-body">
                    <div class="section-kicker mb-2">Baru terdaftar</div>
                    <ul class="list-unstyled mb-0 d-grid gap-3">
                        <?php foreach ($terbaru as $m) : ?>
                            <li class="d-flex align-items-center gap-3">
                                <?= view('partials/avatar', ['m' => $m]) ?>
                                <div class="flex-grow-1">
                                    <a href="<?= site_url('mahasiswa/' . esc($m['nim'], 'url')) ?>" class="fw-bold text-decoration-none"><?= esc($m['nama']) ?></a>
                                    <div class="mhs-meta"><?= esc($m['nim']) ?> &middot; <?= esc($m['nama_prodi']) ?></div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="stat-strip row g-0 text-center text-md-start">
        <div class="col-md-4 stat">
            <div class="stat-value"><?= number_format($totalMahasiswa) ?></div>
            <div class="stat-label">Mahasiswa terdaftar</div>
        </div>
        <div class="col-md-4 stat">
            <div class="stat-value"><?= count($programStudi) ?></div>
            <div class="stat-label">Program studi aktif</div>
        </div>
        <div class="col-md-4 stat">
            <div class="stat-value"><?= number_format($rataIpk, 2) ?></div>
            <div class="stat-label">Rata-rata IPK seluruh mahasiswa</div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section id="program-studi" aria-labelledby="judul-prodi" class="pt-3">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
        <div>
            <div class="section-kicker">Program Studi</div>
            <h2 id="judul-prodi" class="section-title mb-0">Pilih jalur belajarmu</h2>
        </div>
        <a href="<?= site_url('direktori') ?>" class="fw-bold text-decoration-none">Semua mahasiswa <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
    </div>

    <div class="row g-4">
        <?php foreach ($programStudi as $i => $p) : ?>
            <div class="<?= $i === 0 ? 'col-lg-6' : 'col-md-6 col-lg-3' ?>">
                <a href="<?= site_url('program/' . esc($p['slug'], 'url')) ?>" class="surface prodi-card <?= $i === 0 ? 'featured' : '' ?>">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="kode"><?= esc($p['kode']) ?></span>
                        <span class="badge rounded-pill badge-prodi"><?= (int) $p['jumlah_mahasiswa'] ?> mahasiswa</span>
                    </div>
                    <h3 class="h5 fw-bold mb-2"><?= esc($p['nama']) ?></h3>
                    <p class="mhs-meta mb-3"><?= esc($i === 0 ? $p['deskripsi'] : character_limiter($p['deskripsi'] ?? '', 70, '…')) ?></p>
                    <span class="fw-bold arrow d-inline-block">Lihat detail <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</section>
<?= $this->endSection() ?>
