<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<?php $persenSks = min(100, (int) round($sksIni / max(1, $batasSks) * 100)); ?>
<h1 class="h3 mb-1 text-gray-800">Halo, <?= esc(strtok($mhs['nama'], ' ')) ?></h1>
<p class="text-gray-600 mb-4"><?= esc($mhs['nim']) ?> &middot; Angkatan <?= esc($mhs['angkatan']) ?> &middot; Dosen wali: <?= esc($mhs['nama_wali']) ?></p>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="ipk-hero shadow p-4 h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="label">Indeks Prestasi Kumulatif</div>
                <div class="angka my-2"><?= $sksLulus > 0 ? format_ip($ipk) : '–' ?></div>
                <div class="small">dari <?= $sksLulus ?> SKS yang sudah dinilai</div>
            </div>
            <a href="<?= site_url('mahasiswa/transkrip') ?>" class="btn btn-light btn-sm mt-4 align-self-start">Lihat transkrip <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
    </div>
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase">KRS <?= esc(label_periode($akademik->tahunAjaran, $akademik->semester)) ?></div>
                        <div class="h4 font-weight-bold text-gray-800 mb-0 tabular"><?= $sksIni ?> <span class="h6 text-gray-600">/ <?= $batasSks ?> SKS</span></div>
                    </div>
                    <span class="badge <?= $krsTerbuka ? 'badge-success' : 'badge-secondary' ?> p-2"><?= $krsTerbuka ? 'Masa KRS dibuka' : 'Masa KRS ditutup' ?></span>
                </div>
                <div class="meter mb-3" role="img" aria-label="<?= $sksIni ?> dari <?= $batasSks ?> SKS"><span style="width:<?= $persenSks ?>%"></span></div>
                <p class="small text-gray-600">Masa pengisian: <?= esc($akademik->krsMulai) ?> s.d. <?= esc($akademik->krsSelesai) ?>. Batas SKS ditentukan dari IP semester sebelumnya.</p>
                <a href="<?= site_url('mahasiswa/krs') ?>" class="btn btn-primary btn-sm"><i class="fas fa-clipboard-list mr-1"></i> <?= $sksIni === 0 ? 'Isi KRS sekarang' : 'Kelola KRS' ?></a>
                <hr>
                <h2 class="h6 font-weight-bold text-gray-800">Perkembangan IP</h2>
                <canvas id="grafikIp" height="110" role="img" aria-label="Grafik IP dan IPK per semester"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php $dinilai = array_values(array_filter($perPeriode, static fn (array $p): bool => $p['dinilai'])); ?>
<script src="<?= base_url('assets/sb-admin-2/vendor/chart.js/Chart.min.js') ?>"></script>
<script>
    new Chart(document.getElementById('grafikIp'), {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($dinilai, 'label')) ?>,
            datasets: [
                { label: 'IP semester', data: <?= json_encode(array_column($dinilai, 'ip')) ?>, borderColor: '#1e40af', backgroundColor: 'rgba(30,64,175,.08)', lineTension: 0.2 },
                { label: 'IPK', data: <?= json_encode(array_column($dinilai, 'ipk')) ?>, borderColor: '#15803d', fill: false, borderDash: [6, 4], lineTension: 0.2 }
            ]
        },
        options: {
            animation: { duration: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 600 },
            scales: { yAxes: [{ ticks: { min: 0, max: 4, stepSize: 1 } }] }
        }
    });
</script>
<?= $this->endSection() ?>
