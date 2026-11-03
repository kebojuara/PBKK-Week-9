<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $isAdmin = session('role') === 'admin'; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mahasiswa</h1>
    <a href="<?= site_url('admin/mahasiswa/new') ?>" class="btn btn-primary shadow-sm mt-3 mt-sm-0"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Mahasiswa</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <form method="get" action="<?= site_url('admin/mahasiswa') ?>" class="form-row align-items-center" role="search">
            <div class="col-md-6 mb-2 mb-md-0">
                <label for="q" class="sr-only">Cari</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text bg-white"><i class="fas fa-search text-gray-500"></i></span></div>
                    <input type="search" id="q" name="q" value="<?= esc($keyword) ?>" class="form-control" placeholder="Cari nama, NIM, atau email">
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <label for="prodi" class="sr-only">Program studi</label>
                <select id="prodi" name="prodi" class="form-control">
                    <option value="">Semua program studi</option>
                    <?php foreach ($programStudi as $p) : ?>
                        <option value="<?= $p['id'] ?>" <?= $prodiId === (int) $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-md-2 d-flex">
                <button class="btn btn-primary flex-grow-1">Cari</button>
                <?php if ($keyword !== '' || $prodiId !== null) : ?>
                    <a href="<?= site_url('admin/mahasiswa') ?>" class="btn btn-light ml-2" title="Reset filter"><i class="fas fa-times"></i></a>
                <?php endif ?>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="pl-4">Mahasiswa</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Program Studi</th>
                    <th scope="col">Angkatan</th>
                    <th scope="col" style="min-width: 8rem">IPK</th>
                    <th scope="col" class="text-right pr-4">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($mahasiswa === []) : ?>
                    <tr><td colspan="6" class="text-center text-gray-600 py-5"><i class="fas fa-user-slash fa-2x mb-2 d-block text-gray-300"></i>Tidak ada data yang cocok.</td></tr>
                <?php endif ?>
                <?php foreach ($mahasiswa as $m) : ?>
                    <tr>
                        <td class="pl-4">
                            <div class="d-flex align-items-center">
                                <?= view('partials/avatar', ['m' => $m]) ?>
                                <div class="ml-3">
                                    <div class="font-weight-bold text-gray-800"><?= esc($m['nama']) ?></div>
                                    <div class="small text-gray-600"><?= esc($m['email']) ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= esc($m['nim']) ?></td>
                        <td><?= esc($m['nama_prodi']) ?></td>
                        <td><?= esc($m['angkatan']) ?></td>
                        <td>
                            <div class="font-weight-bold text-gray-800"><?= esc($m['ipk']) ?></div>
                            <div class="ipk-bar" aria-hidden="true"><span style="width: <?= (float) $m['ipk'] / 4 * 100 ?>%"></span></div>
                        </td>
                        <td class="text-right pr-4 text-nowrap">
                            <a href="<?= site_url('admin/mahasiswa/' . $m['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i> Edit</a>
                            <?php if ($isAdmin) : ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modalHapus"
                                        data-action="<?= site_url('admin/mahasiswa/' . $m['id']) ?>" data-nama="<?= esc($m['nama'], 'attr') ?>">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white d-flex flex-wrap justify-content-between align-items-center">
        <span class="small text-gray-600 mb-2 mb-md-0">Total <?= $pager->getTotal() ?> mahasiswa &middot; halaman <?= $pager->getCurrentPage() ?> dari <?= max(1, $pager->getPageCount()) ?></span>
        <?= $pager->links('default', 'bootstrap') ?>
    </div>
</div>
<?php if (! $isAdmin) : ?>
    <p class="small text-gray-600"><i class="fas fa-info-circle"></i> Akun staff dapat menambah dan mengubah data, tetapi tidak dapat menghapus.</p>
<?php endif ?>
<?= $this->endSection() ?>
