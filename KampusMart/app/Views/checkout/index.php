<?= $this->extend('layouts/toko') ?>

<?= $this->section('content') ?>
<?php
$errors = session('errors') ?? [];
$cls    = static fn (string $f): string => isset($errors[$f]) ? 'is-invalid' : '';
?>
<h1 class="h2 fw-bold mb-4">Checkout</h1>
<form action="<?= site_url('checkout') ?>" method="post" novalidate>
    <?= csrf_field() ?>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="surface p-4 mb-4">
                <h2 class="h5 fw-bold mb-3"><i class="bi bi-geo-alt text-toko"></i> Alamat pengiriman</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_penerima" class="form-label fw-bold">Nama penerima</label>
                        <input type="text" id="nama_penerima" name="nama_penerima" value="<?= esc(old('nama_penerima', $user['nama'])) ?>" class="form-control <?= $cls('nama_penerima') ?>">
                        <div class="invalid-feedback"><?= esc($errors['nama_penerima'] ?? '') ?></div>
                    </div>
                    <div class="col-md-6">
                        <label for="telepon" class="form-label fw-bold">No. HP</label>
                        <input type="tel" id="telepon" name="telepon" value="<?= esc(old('telepon', $user['telepon'] ?? '')) ?>" class="form-control <?= $cls('telepon') ?>">
                        <div class="invalid-feedback"><?= esc($errors['telepon'] ?? '') ?></div>
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label fw-bold">Alamat lengkap</label>
                        <textarea id="alamat" name="alamat" rows="3" class="form-control <?= $cls('alamat') ?>"><?= esc(old('alamat', $user['alamat'] ?? '')) ?></textarea>
                        <div class="invalid-feedback"><?= esc($errors['alamat'] ?? '') ?></div>
                    </div>
                    <div class="col-12">
                        <label for="catatan" class="form-label fw-bold">Catatan <span class="fw-normal text-secondary">(opsional)</span></label>
                        <input type="text" id="catatan" name="catatan" value="<?= esc(old('catatan')) ?>" maxlength="255" placeholder="Mis. titip di pos satpam" class="form-control <?= $cls('catatan') ?>">
                        <div class="invalid-feedback"><?= esc($errors['catatan'] ?? '') ?></div>
                    </div>
                </div>
            </div>
            <div class="surface p-4">
                <h2 class="h5 fw-bold mb-3"><i class="bi bi-bank text-toko"></i> Pembayaran</h2>
                <p class="mb-2">Transfer bank manual. Setelah pesanan dibuat, transfer sesuai total lalu unggah bukti pembayaran dalam <?= config('Toko')->batasBayarJam ?> jam.</p>
                <ul class="list-unstyled mb-0 small">
                    <?php foreach (config('Toko')->rekening as $r) : ?>
                        <li><strong><?= esc($r['bank']) ?></strong> <?= esc($r['nomor']) ?> a.n. <?= esc($r['atas_nama']) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="surface p-4 mb-3">
                <h2 class="h5 fw-bold mb-3"><?= count($isi) ?> produk</h2>
                <?php foreach ($isi as $b) : ?>
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div class="cart-thumb sm"><?= foto_produk($b) ?></div>
                        <div class="flex-grow-1 small"><div class="fw-bold"><?= esc($b['nama']) ?></div><span class="text-secondary"><?= $b['qty'] ?> × <?= rupiah($b['harga']) ?></span></div>
                        <div class="fw-bold small"><?= rupiah($b['subtotal']) ?></div>
                    </div>
                <?php endforeach ?>
            </div>
            <?= $this->setData(['ringkasan' => $ringkasan])->include('partials/ringkasan') ?>
            <button type="submit" class="btn btn-cta btn-lg w-100 mt-3"><i class="bi bi-lock"></i> Buat pesanan</button>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
