<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>
    <a href="<?= site_url('admin/users/new') ?>" class="btn btn-primary shadow-sm mt-3 mt-sm-0"><i class="fas fa-user-plus fa-sm mr-1"></i> Tambah User</a>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" class="pl-4">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        <th scope="col" class="text-right pr-4">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $u) : ?>
                        <?php $diriSendiri = (int) $u['id'] === (int) session('user_id'); ?>
                        <tr>
                            <td class="pl-4 font-weight-bold text-gray-800">
                                <?= esc($u['nama']) ?>
                                <?php if ($diriSendiri) : ?><span class="badge badge-light ml-1">Anda</span><?php endif ?>
                            </td>
                            <td><code><?= esc($u['username']) ?></code></td>
                            <td><span class="badge badge-role badge-<?= $u['role'] === 'admin' ? 'primary' : 'success' ?>"><?= esc(ucfirst($u['role'])) ?></span></td>
                            <td class="text-right pr-4 text-nowrap">
                                <a href="<?= site_url('admin/users/' . $u['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-pen"></i> Edit</a>
                                <?php if (! $diriSendiri) : ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#modalHapus"
                                            data-action="<?= site_url('admin/users/' . $u['id']) ?>" data-nama="<?= esc($u['username'], 'attr') ?>">
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
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Hak Akses</h2></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0 small">
                    <thead><tr><th class="pl-3">Fitur</th><th class="text-center">Admin</th><th class="text-center">Staff</th></tr></thead>
                    <tbody>
                    <?php
                    $matriks = [
                        ['Dashboard & lihat data', true, true],
                        ['Tambah / edit mahasiswa', true, true],
                        ['Hapus mahasiswa', true, false],
                        ['Kelola program studi', true, false],
                        ['Kelola user', true, false],
                    ];
                    ?>
                    <?php foreach ($matriks as [$fitur, $admin, $staff]) : ?>
                        <tr>
                            <td class="pl-3"><?= $fitur ?></td>
                            <td class="text-center"><?= $admin ? '<i class="fas fa-check text-success" aria-label="Ya"></i>' : '<i class="fas fa-times text-danger" aria-label="Tidak"></i>' ?></td>
                            <td class="text-center"><?= $staff ? '<i class="fas fa-check text-success" aria-label="Ya"></i>' : '<i class="fas fa-times text-danger" aria-label="Tidak"></i>' ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
