<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Program Studi</h1>
    <a href="<?= site_url('admin/program/new') ?>" class="btn btn-primary shadow-sm mt-3 mt-sm-0"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Program Studi</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="pl-4">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Slug (URL publik)</th>
                    <th scope="col" class="text-center">Mahasiswa</th>
                    <th scope="col" class="text-right pr-4">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($programStudi as $p) : ?>
                    <tr>
                        <td class="pl-4"><span class="badge badge-primary px-2 py-1"><?= esc($p['kode']) ?></span></td>
                        <td class="font-weight-bold text-gray-800"><?= esc($p['nama']) ?></td>
                        <td class="small"><?= esc($p['fakultas']) ?></td>
                        <td><a href="<?= site_url('program/' . esc($p['slug'], 'url')) ?>" target="_blank" rel="noopener"><code>/program/<?= esc($p['slug']) ?></code></a></td>
                        <td class="text-center"><?= (int) $p['jumlah_mahasiswa'] ?></td>
                        <td class="text-right pr-4 text-nowrap">
                            <a href="<?= site_url('admin/program/' . $p['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i> Edit</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modalHapus"
                                    data-action="<?= site_url('admin/program/' . $p['id']) ?>" data-nama="<?= esc($p['nama'], 'attr') ?>">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<p class="small text-gray-600"><i class="fas fa-info-circle"></i> Program studi yang masih memiliki mahasiswa tidak dapat dihapus.</p>
<?= $this->endSection() ?>
