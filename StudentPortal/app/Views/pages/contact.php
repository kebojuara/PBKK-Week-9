<?= $this->extend('layouts/public') ?>

<?= $this->section('hero') ?>
<header class="page-header">
    <div class="container">
        <h1 class="fw-bold">Hubungi Bagian Akademik</h1>
        <p>Pertanyaan seputar pendaftaran, perubahan data, atau program studi.</p>
    </div>
</header>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $errors = session('errors') ?? []; ?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="surface p-4 h-100">
            <h2 class="h5 fw-bold mb-3">Kantor Akademik</h2>
            <dl class="info-list mb-0">
                <dt>Alamat</dt><dd>Gedung Rektorat Lt. 1, Kampus ITS Sukolilo, Surabaya</dd>
                <dt>Jam layanan</dt><dd>Senin–Jumat, 08.00–15.00 WIB</dd>
                <dt>Email</dt><dd>akademik@studentportal.test</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-8">
        <form action="<?= site_url('contact') ?>" method="post" class="surface p-4 p-md-5" novalidate>
            <?= csrf_field() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?= esc(old('nama')) ?>" autocomplete="name"
                           class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" required>
                    <div class="invalid-feedback"><?= esc($errors['nama'] ?? '') ?></div>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="<?= esc(old('email')) ?>" autocomplete="email"
                           class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" required>
                    <div class="invalid-feedback"><?= esc($errors['email'] ?? '') ?></div>
                </div>
                <div class="col-12">
                    <label for="subjek" class="form-label">Subjek</label>
                    <input type="text" id="subjek" name="subjek" value="<?= esc(old('subjek')) ?>"
                           class="form-control <?= isset($errors['subjek']) ? 'is-invalid' : '' ?>" required>
                    <div class="invalid-feedback"><?= esc($errors['subjek'] ?? '') ?></div>
                </div>
                <div class="col-12">
                    <label for="isi" class="form-label">Pesan</label>
                    <textarea id="isi" name="isi" rows="5" aria-describedby="isi-help"
                              class="form-control <?= isset($errors['isi']) ? 'is-invalid' : '' ?>" required><?= esc(old('isi')) ?></textarea>
                    <div id="isi-help" class="form-text">Minimal 10 karakter.</div>
                    <div class="invalid-feedback"><?= esc($errors['isi'] ?? '') ?></div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-portal btn-lg"><i class="bi bi-send" aria-hidden="true"></i> Kirim Pesan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
