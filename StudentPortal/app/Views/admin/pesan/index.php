<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $isAdmin = session('role') === 'admin'; ?>
<h1 class="h3 mb-4 text-gray-800">Pesan Masuk</h1>

<?php if ($pesan === []) : ?>
    <div class="card shadow"><div class="card-body text-center text-gray-600 py-5">
        <i class="fas fa-inbox fa-2x mb-2 d-block text-gray-300"></i>Belum ada pesan dari halaman Kontak.
    </div></div>
<?php endif ?>

<?php foreach ($pesan as $p) : ?>
    <div class="card shadow mb-3 border-left-primary">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-wrap">
                <div>
                    <h2 class="h6 font-weight-bold text-gray-800 mb-1"><?= esc($p['subjek']) ?></h2>
                    <div class="small text-gray-600 mb-2">
                        <?= esc($p['nama']) ?> &lt;<a href="mailto:<?= esc($p['email'], 'attr') ?>"><?= esc($p['email']) ?></a>&gt;
                        &middot; <?= esc(date('d M Y H:i', strtotime($p['created_at']))) ?>
                    </div>
                </div>
                <?php if ($isAdmin) : ?>
                    <button type="button" class="btn btn-sm btn-outline-danger align-self-start" data-toggle="modal" data-target="#modalHapus"
                            data-action="<?= site_url('admin/pesan/' . $p['id']) ?>" data-nama="pesan “<?= esc($p['subjek'], 'attr') ?>”">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                <?php endif ?>
            </div>
            <p class="mb-0 text-gray-800" style="white-space: pre-line"><?= esc($p['isi']) ?></p>
        </div>
    </div>
<?php endforeach ?>

<div class="d-flex justify-content-center"><?= $pager->links('default', 'bootstrap') ?></div>
<?= $this->endSection() ?>
