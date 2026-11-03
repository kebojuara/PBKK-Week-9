<?php
$segmen  = service('uri')->getSegment(2);
$isAdmin = session('role') === 'admin';

$aktif = static fn (string $nama): string => $segmen === $nama ? 'active' : '';
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('admin') ?>">
        <div class="sidebar-brand-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="sidebar-brand-text mx-3">Student<sup>Portal</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item <?= $aktif('') ?>">
        <a class="nav-link" href="<?= site_url('admin') ?>"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Data Akademik</div>

    <li class="nav-item <?= $aktif('mahasiswa') ?>">
        <a class="nav-link" href="<?= site_url('admin/mahasiswa') ?>"><i class="fas fa-fw fa-users"></i><span>Mahasiswa</span></a>
    </li>
    <?php if ($isAdmin) : ?>
        <li class="nav-item <?= $aktif('program') ?>">
            <a class="nav-link" href="<?= site_url('admin/program') ?>"><i class="fas fa-fw fa-university"></i><span>Program Studi</span></a>
        </li>
    <?php endif ?>
    <li class="nav-item <?= $aktif('pesan') ?>">
        <a class="nav-link" href="<?= site_url('admin/pesan') ?>"><i class="fas fa-fw fa-envelope"></i><span>Pesan Masuk</span></a>
    </li>

    <?php if ($isAdmin) : ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Pengaturan</div>
        <li class="nav-item <?= $aktif('users') ?>">
            <a class="nav-link" href="<?= site_url('admin/users') ?>"><i class="fas fa-fw fa-user-shield"></i><span>Kelola User</span></a>
        </li>
    <?php endif ?>

    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle" aria-label="Ciutkan sidebar"></button>
    </div>
</ul>
