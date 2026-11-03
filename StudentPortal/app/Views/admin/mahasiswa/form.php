<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $mahasiswa !== null;
$errors = session('errors') ?? [];
$nilai  = static fn (string $f) => old($f, $mahasiswa[$f] ?? '');
$fotoUrl = $isEdit && ! empty($mahasiswa['foto']) ? base_url('uploads/mahasiswa/' . $mahasiswa['foto']) : null;
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/mahasiswa') ?>">Data Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $isEdit ? 'Edit' : 'Tambah' ?></li>
    </ol>
</nav>
<h1 class="h3 mb-4 text-gray-800"><?= esc($title) ?></h1>

<form action="<?= $isEdit ? site_url('admin/mahasiswa/' . $mahasiswa['id']) : site_url('admin/mahasiswa') ?>"
      method="post" enctype="multipart/form-data" novalidate>
    <?= csrf_field() ?>
    <?php if ($isEdit) : ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif ?>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Data Diri</h2></div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="nim" class="font-weight-bold">NIM</label>
                            <input type="text" id="nim" name="nim" value="<?= esc($nilai('nim')) ?>" inputmode="numeric" maxlength="10"
                                   class="form-control <?= isset($errors['nim']) ? 'is-invalid' : '' ?>" aria-describedby="nim-help">
                            <small id="nim-help" class="form-text text-muted">10 digit angka, harus unik.</small>
                            <div class="invalid-feedback"><?= esc($errors['nim'] ?? '') ?></div>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="nama" class="font-weight-bold">Nama lengkap</label>
                            <input type="text" id="nama" name="nama" value="<?= esc($nilai('nama')) ?>"
                                   class="form-control <?= isset($errors['nama']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback"><?= esc($errors['nama'] ?? '') ?></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email</label>
                        <input type="email" id="email" name="email" value="<?= esc($nilai('email')) ?>"
                               class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback"><?= esc($errors['email'] ?? '') ?></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="program_studi_id" class="font-weight-bold">Program studi</label>
                            <select id="program_studi_id" name="program_studi_id" class="form-control <?= isset($errors['program_studi_id']) ? 'is-invalid' : '' ?>">
                                <option value="">— Pilih —</option>
                                <?php foreach ($programStudi as $p) : ?>
                                    <option value="<?= $p['id'] ?>" <?= (string) $nilai('program_studi_id') === (string) $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($errors['program_studi_id'] ?? '') ?></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="angkatan" class="font-weight-bold">Angkatan</label>
                            <input type="number" id="angkatan" name="angkatan" value="<?= esc($nilai('angkatan') ?: date('Y')) ?>" min="2000" max="2030"
                                   class="form-control <?= isset($errors['angkatan']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback"><?= esc($errors['angkatan'] ?? '') ?></div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ipk" class="font-weight-bold">IPK</label>
                            <input type="number" id="ipk" name="ipk" value="<?= esc($nilai('ipk')) ?>" step="0.01" min="0" max="4"
                                   class="form-control <?= isset($errors['ipk']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback"><?= esc($errors['ipk'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Foto</h2></div>
                <div class="card-body text-center">
                    <img id="preview" src="<?= $fotoUrl ? esc($fotoUrl, 'attr') : '' ?>" alt="Pratinjau foto"
                         class="foto-preview mb-3 <?= $fotoUrl ? '' : 'd-none' ?>">
                    <div id="preview-kosong" class="foto-preview mb-3 mx-auto align-items-center justify-content-center text-gray-400 <?= $fotoUrl ? 'd-none' : 'd-flex' ?>">
                        <i class="fas fa-camera fa-2x"></i>
                    </div>
                    <div class="custom-file text-left">
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp"
                               class="custom-file-input <?= isset($errors['foto']) ? 'is-invalid' : '' ?>">
                        <label class="custom-file-label" for="foto">Pilih gambar…</label>
                        <div class="invalid-feedback"><?= esc($errors['foto'] ?? '') ?></div>
                    </div>
                    <small class="form-text text-muted text-left">JPG, PNG, atau WEBP, maksimal 2 MB.</small>
                    <?php if ($fotoUrl) : ?>
                        <div class="custom-control custom-checkbox text-left mt-3">
                            <input type="checkbox" class="custom-control-input" id="hapus_foto" name="hapus_foto" value="1">
                            <label class="custom-control-label" for="hapus_foto">Hapus foto saat ini</label>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> <?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?></button>
        <a href="<?= site_url('admin/mahasiswa') ?>" class="btn btn-light ml-2">Batal</a>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Pratinjau foto sebelum diunggah
    document.getElementById('foto').addEventListener('change', function () {
        var file = this.files[0];
        if (!file) { return; }
        this.nextElementSibling.textContent = file.name;
        var img = document.getElementById('preview');
        img.src = URL.createObjectURL(file);
        img.classList.remove('d-none');
        var kosong = document.getElementById('preview-kosong');
        kosong.classList.remove('d-flex');
        kosong.classList.add('d-none');
    });
</script>
<?= $this->endSection() ?>
