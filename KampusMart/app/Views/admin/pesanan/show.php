<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
use App\Libraries\OrderStatus;

$errors = session('errors') ?? [];
// Label tombol yang lebih jelas untuk setiap tujuan status
$aksi = [
    OrderStatus::DIPROSES            => ['Terima pembayaran', 'success', 'check'],
    OrderStatus::MENUNGGU_PEMBAYARAN => ['Tolak bukti bayar', 'warning', 'undo'],
    OrderStatus::DIKIRIM             => ['Kirim pesanan', 'primary', 'truck'],
    OrderStatus::SELESAI             => ['Tandai selesai', 'success', 'check-double'],
    OrderStatus::DIBATALKAN          => ['Batalkan pesanan', 'outline-danger', 'times'],
];
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0 mb-2">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/pesanan') ?>">Pesanan</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($order['kode']) ?></li>
    </ol>
</nav>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800"><?= esc($order['kode']) ?></h1>
        <span class="text-gray-600"><?= date('d M Y H:i', strtotime($order['created_at'])) ?> &middot; <?= esc($order['nama_pembeli']) ?> (<?= esc($order['email']) ?>)</span>
    </div>
    <?= badge_status($order['status']) ?>
</div>

<div class="row">
    <div class="col-xl-7 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Item pesanan</h2></div>
            <table class="table mb-0">
                <thead><tr><th class="pl-4">Produk</th><th class="text-right">Harga</th><th class="text-center">Qty</th><th class="text-right pr-4">Subtotal</th></tr></thead>
                <tbody>
                <?php foreach ($items as $it) : ?>
                    <tr><td class="pl-4"><?= esc($it['nama_produk']) ?></td><td class="text-right tabular"><?= rupiah($it['harga']) ?></td><td class="text-center"><?= $it['qty'] ?></td><td class="text-right pr-4 tabular"><?= rupiah($it['subtotal']) ?></td></tr>
                <?php endforeach ?>
                </tbody>
                <tfoot class="font-weight-bold">
                    <tr><td colspan="3" class="pl-4 text-right">Subtotal</td><td class="text-right pr-4 tabular"><?= rupiah($order['subtotal']) ?></td></tr>
                    <tr><td colspan="3" class="pl-4 text-right">Ongkir</td><td class="text-right pr-4 tabular"><?= $order['ongkir'] ? rupiah($order['ongkir']) : 'Gratis' ?></td></tr>
                    <tr class="text-primary"><td colspan="3" class="pl-4 text-right">Total</td><td class="text-right pr-4 tabular h5 font-weight-bold"><?= rupiah($order['total']) ?></td></tr>
                </tfoot>
            </table>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <h2 class="h6 font-weight-bold">Pengiriman</h2>
                <p class="mb-1"><strong><?= esc($order['nama_penerima']) ?></strong> &middot; <?= esc($order['telepon']) ?></p>
                <p class="mb-2 text-gray-700"><?= nl2br(esc($order['alamat'])) ?></p>
                <?php if ($order['catatan']) : ?><p class="small mb-1"><i class="fas fa-comment-alt text-gray-400"></i> <?= esc($order['catatan']) ?></p><?php endif ?>
                <?php if ($order['resi']) : ?><p class="mb-0">Resi: <code class="h6"><?= esc($order['resi']) ?></code></p><?php endif ?>
            </div>
        </div>
    </div>

    <div class="col-xl-5 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Bukti pembayaran</h2></div>
            <div class="card-body text-center">
                <?php if ($order['bukti_bayar']) : ?>
                    <a href="<?= site_url('bukti/' . $order['bukti_bayar']) ?>" target="_blank" rel="noopener">
                        <img src="<?= site_url('bukti/' . $order['bukti_bayar']) ?>" alt="Bukti bayar <?= esc($order['kode'], 'attr') ?>" class="bukti-admin">
                    </a>
                <?php else : ?>
                    <p class="text-gray-600 mb-0">Belum ada bukti pembayaran.</p>
                <?php endif ?>
            </div>
        </div>

        <div class="card shadow border-left-primary">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Ubah status</h2></div>
            <div class="card-body">
                <?php if ($tujuan === []) : ?>
                    <p class="text-gray-600 mb-0">Pesanan <?= strtolower(OrderStatus::label($order['status'])) ?>. Menunggu tindakan pembeli atau tidak ada aksi lanjutan.</p>
                <?php else : ?>
                    <form action="<?= site_url('admin/pesanan/' . $order['kode'] . '/status') ?>" method="post" novalidate>
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        <?php if (in_array(OrderStatus::DIKIRIM, $tujuan, true)) : ?>
                            <div class="form-group">
                                <label for="resi" class="font-weight-bold">Nomor resi <small class="text-gray-600">(wajib untuk "Kirim")</small></label>
                                <input type="text" id="resi" name="resi" value="<?= esc(old('resi')) ?>" class="form-control text-uppercase <?= isset($errors['resi']) ? 'is-invalid' : '' ?>">
                                <div class="invalid-feedback"><?= esc($errors['resi'] ?? '') ?></div>
                            </div>
                        <?php endif ?>
                        <div class="form-group">
                            <label for="catatan_admin" class="font-weight-bold">Catatan untuk pembeli <small class="text-gray-600">(mis. alasan penolakan)</small></label>
                            <input type="text" id="catatan_admin" name="catatan_admin" value="<?= esc(old('catatan_admin')) ?>" maxlength="255" class="form-control">
                        </div>
                        <div class="d-flex flex-wrap" style="gap:.5rem">
                            <?php foreach ($tujuan as $t) : ?>
                                <?php [$label, $warna, $ikon] = $aksi[$t]; ?>
                                <button type="submit" name="status" value="<?= $t ?>" class="btn btn-<?= $warna ?>"><i class="fas fa-<?= $ikon ?> mr-1"></i><?= $label ?></button>
                            <?php endforeach ?>
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
