<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $program !== null;
$errors = session('errors') ?? [];
$nilai  = static fn (string $f) => old($f, $program[$f] ?? '');
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/program') ?>">Program Studi</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

<div class="card shadow mb-4" style="max-width: 48rem">
    <div class="card-body">
        <form action="<?= $isEdit ? site_url('admin/program/' . $program['id']) : site_url('admin/program') ?>" method="post" novalidate>
            <?= csrf_field() ?>
            <?php if ($isEdit) : ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif ?>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="kode" class="font-weight-bold">Kode</label>
                    <input type="text" id="kode" name="kode" value="<?= esc($nilai('kode')) ?>" maxlength="10"
                           class="form-control text-uppercase <?= isset($errors['kode']) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= esc($errors['kode'] ?? '') ?></div>
                </div>
                <div class="form-group col-md-9">
                    <label for="nama" class="font-weight-bold">Nama program studi</label>
                    <input type="text" id="nama" name="nama" value="<?= esc($nilai('nama')) ?>" aria-describedby="nama-help"
                           class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>">
                    <small id="nama-help" class="form-text text-muted">Slug URL dibuat otomatis dari nama.</small>
                    <div class="invalid-feedback"><?= esc($errors['nama'] ?? '') ?></div>
                </div>
            </div>
            <div class="form-group">
                <label for="fakultas" class="font-weight-bold">Fakultas</label>
                <input type="text" id="fakultas" name="fakultas" value="<?= esc($nilai('fakultas')) ?>"
                       class="form-control <?= isset($errors['fakultas']) ? 'is-invalid' : '' ?>">
                <div class="invalid-feedback"><?= esc($errors['fakultas'] ?? '') ?></div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="font-weight-bold">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control"><?= esc($nilai('deskripsi')) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="<?= site_url('admin/program') ?>" class="btn btn-light ml-2">Batal</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
