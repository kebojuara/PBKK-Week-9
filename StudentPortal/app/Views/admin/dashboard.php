<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <p class="mb-0 text-gray-600">Ringkasan data akademik hari ini, <?= esc(date('d M Y')) ?>.</p>
    </div>
    <a href="<?= site_url('admin/mahasiswa/new') ?>" class="btn btn-primary shadow-sm mt-3 mt-sm-0"><i class="fas fa-plus fa-sm mr-1"></i> Tambah Mahasiswa</a>
</div>

<div class="row">
    <?php
    $kartu = [
        ['Mahasiswa', number_format($totalMahasiswa), 'fa-users', 'primary'],
        ['Program Studi', $totalProdi, 'fa-university', 'success'],
        ['Rata-rata IPK', number_format($rataIpk, 2), 'fa-chart-line', 'info'],
        ['Pesan Masuk', $totalPesan, 'fa-envelope', 'warning'],
    ];
    ?>
    <?php foreach ($kartu as [$label, $nilai, $ikon, $warna]) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= $warna ?> shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-<?= $warna ?> text-uppercase mb-1"><?= $label ?></div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $nilai ?></div>
                        </div>
                        <div class="col-auto"><i class="fas <?= $ikon ?> fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Mahasiswa per Program Studi</h6></div>
            <div class="card-body">
                <div style="height: 300px"><canvas id="chartProdi" aria-label="Grafik jumlah mahasiswa per program studi" role="img"></canvas></div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Baru Ditambahkan</h6>
                <a href="<?= site_url('admin/mahasiswa') ?>" class="small">Lihat semua &rarr;</a>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($terbaru as $m) : ?>
                    <li class="list-group-item d-flex align-items-center">
                        <?= view('partials/avatar', ['m' => $m]) ?>
                        <div class="ml-3 flex-grow-1">
                            <div class="font-weight-bold text-gray-800"><?= esc($m['nama']) ?></div>
                            <div class="small text-gray-600"><?= esc($m['nim']) ?> &middot; <?= esc($m['nama_prodi']) ?></div>
                        </div>
                        <span class="badge badge-light">IPK <?= esc($m['ipk']) ?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/sb-admin-2/vendor/chart.js/Chart.min.js') ?>"></script>
<script>
    new Chart(document.getElementById('chartProdi'), {
        type: 'horizontalBar',
        data: {
            labels: <?= json_encode(array_column($programStudi, 'nama')) ?>,
            datasets: [{
                label: 'Mahasiswa',
                data: <?= json_encode(array_map('intval', array_column($programStudi, 'jumlah_mahasiswa'))) ?>,
                backgroundColor: '#1e40af',
                hoverBackgroundColor: '#1e3a8a',
                barThickness: 22
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                xAxes: [{ ticks: { beginAtZero: true, precision: 0 }, gridLines: { color: '#eaecf4' } }],
                yAxes: [{ gridLines: { display: false } }]
            }
        }
    });
</script>
<?= $this->endSection() ?>
