<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= esc($title ?? 'Admin') ?> · Admin StudentPortal</title>
    <link href="<?= base_url('assets/sb-admin-2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/sb-admin-2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
</head>
<body id="page-top">
<div id="wrapper">

    <?= $this->include('partials/sidebar') ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" aria-label="Tampilkan menu">
                    <i class="fa fa-bars"></i>
                </button>
                <span class="h5 mb-0 text-gray-800 font-weight-bold d-none d-sm-inline"><?= esc($title ?? '') ?></span>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/') ?>" target="_blank" rel="noopener" title="Buka situs publik">
                            <i class="fas fa-globe fa-fw"></i><span class="d-none d-lg-inline ml-1 small">Situs publik</span>
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-700"><?= esc(session('nama')) ?></span>
                            <span class="badge badge-role badge-<?= session('role') === 'admin' ? 'primary' : 'success' ?>"><?= esc(ucfirst((string) session('role'))) ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="userDropdown">
                            <span class="dropdown-item-text small text-gray-600">Login sebagai <strong><?= esc(session('username')) ?></strong></span>
                            <div class="dropdown-divider"></div>
                            <form action="<?= site_url('logout') ?>" method="post" class="m-0">
                                <?= csrf_field() ?>
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-500"></i> Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid">
                <?= $this->include('partials/alerts') ?>
                <?= $this->renderSection('content') ?>
            </div>
        </div>

        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>StudentPortal &middot; Template SB Admin 2 &middot; CodeIgniter <?= \CodeIgniter\CodeIgniter::CI_VERSION ?></span>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Modal konfirmasi hapus (dipakai semua tombol .btn-hapus) -->
<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" method="post" id="formHapus">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalHapusLabel">Hapus data?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                Data <strong id="namaHapus"></strong> akan dihapus permanen dan tidak dapat dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i> Ya, hapus</button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url('assets/sb-admin-2/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('assets/sb-admin-2/js/sb-admin-2.min.js') ?>"></script>
<script>
    // Isi action & nama pada modal hapus sesuai tombol yang diklik
    $('#modalHapus').on('show.bs.modal', function (e) {
        var btn = $(e.relatedTarget);
        $('#formHapus').attr('action', btn.data('action'));
        $('#namaHapus').text(btn.data('nama'));
    });
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
