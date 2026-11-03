<?php
$role  = session('role');
$path  = trim(service('uri')->getPath(), '/');
$aktif = static fn (string $prefix, bool $persis = false): string
    => ($persis ? $path === $prefix : str_starts_with($path, $prefix)) ? 'active' : '';

$menu = match ($role) {
    'admin' => [
        'Utama'        => [['admin', 'fa-tachometer-alt', 'Dashboard', true]],
        'Data Master'  => [
            ['admin/mahasiswa', 'fa-user-graduate', 'Mahasiswa', false],
            ['admin/dosen', 'fa-chalkboard-teacher', 'Dosen', false],
            ['admin/matakuliah', 'fa-book', 'Mata Kuliah', false],
        ],
    ],
    'dosen' => [
        'Pengajaran' => [['dosen', 'fa-chalkboard', 'Kelas & Nilai', true]],
        'Akademik'   => [['dosen/perwalian', 'fa-users', 'Perwalian', false]],
    ],
    default => [
        'Utama'    => [['mahasiswa', 'fa-home', 'Dashboard', true]],
        'Akademik' => [
            ['mahasiswa/krs', 'fa-clipboard-list', 'KRS', false],
            ['mahasiswa/khs', 'fa-file-alt', 'KHS', false],
            ['mahasiswa/transkrip', 'fa-scroll', 'Transkrip', false],
        ],
    ],
};
?>
<ul class="navbar-nav sidebar sidebar-dark sidebar-siakad accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('/') ?>">
        <div class="sidebar-brand-icon"><i class="fas fa-university"></i></div>
        <div class="sidebar-brand-text mx-3">SIAKAD</div>
    </a>

    <?php foreach ($menu as $judul => $items) : ?>
        <hr class="sidebar-divider<?= $judul === array_key_first($menu) ? ' my-0' : '' ?>">
        <div class="sidebar-heading"><?= esc($judul) ?></div>
        <?php foreach ($items as [$url, $ikon, $label, $persis]) : ?>
            <?php // Halaman input nilai (dosen/kelas/..) tetap menandai menu "Kelas & Nilai".
            $kelas = $aktif($url, $persis) ?: ($url === 'dosen' && str_starts_with($path, 'dosen/kelas') ? 'active' : ''); ?>
            <li class="nav-item <?= $kelas ?>">
                <a class="nav-link" href="<?= site_url($url) ?>"<?= $kelas ? ' aria-current="page"' : '' ?>>
                    <i class="fas fa-fw <?= $ikon ?>"></i><span><?= esc($label) ?></span>
                </a>
            </li>
        <?php endforeach ?>
    <?php endforeach ?>

    <hr class="sidebar-divider">
    <li class="nav-item <?= $aktif('password', true) ?>">
        <a class="nav-link" href="<?= site_url('password') ?>"><i class="fas fa-fw fa-key"></i><span>Ganti Password</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Ciutkan sidebar"></button>
    </div>
</ul>
