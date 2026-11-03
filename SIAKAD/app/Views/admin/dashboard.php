<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Akademik</h1>
    <span class="text-gray-600 small">Masa KRS: <?= esc($akademik->krsMulai) ?> s.d. <?= esc($akademik->krsSelesai) ?></span>
</div>

<div class="row">
    <?php foreach ([
        ['Mahasiswa', $jumlahMhs, 'fa-user-graduate', 'primary', 'admin/mahasiswa'],
        ['Dosen', $jumlahDosen, 'fa-chalkboard-teacher', 'info', 'admin/dosen'],
        ['Mata Kuliah', $jumlahMk, 'fa-book', 'success', 'admin/matakuliah'],
        ['Isian KRS semester ini', $jumlahKrs, 'fa-clipboard-list', 'warning', null],
    ] as [$label, $nilai, $ikon, $warna, $url]) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-<?= $warna ?> shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-<?= $warna ?> text-uppercase mb-1"><?= $label ?></div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800 tabular"><?= $nilai ?></div>
                        </div>
                        <div class="col-auto"><i class="fas <?= $ikon ?> fa-2x text-gray-300"></i></div>
                    </div>
                    <?php if ($url) : ?><a href="<?= site_url($url) ?>" class="stretched-link" aria-label="Kelola <?= $label ?>"></a><?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Keterisian kelas — <?= esc(label_periode($akademik->tahunAjaran, $akademik->semester)) ?></h2></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th class="pl-4">Mata kuliah</th><th>Dosen</th><th style="width:30%">Peserta / kuota</th></tr></thead>
                    <tbody>
                    <?php foreach ($ditawarkan as $mk) : ?>
                        <?php $persen = min(100, (int) round($mk['peserta'] / max(1, $mk['kuota']) * 100)); ?>
                        <tr>
                            <td class="pl-4"><span class="font-weight-bold"><?= esc($mk['kode']) ?></span> <?= esc($mk['nama']) ?><div class="small text-gray-600">Smt <?= $mk['semester'] ?> &middot; <?= $mk['sks'] ?> SKS</div></td>
                            <td class="small"><?= esc($mk['nama_dosen']) ?></td>
                            <td>
                                <div class="d-flex justify-content-between small tabular"><span><?= $mk['peserta'] ?> / <?= $mk['kuota'] ?></span><span><?= $persen ?>%</span></div>
                                <div class="meter <?= $persen >= 100 ? 'penuh' : ($persen >= 80 ? 'hampir' : '') ?>" role="img" aria-label="Terisi <?= $persen ?> persen"><span style="width:<?= $persen ?>%"></span></div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Distribusi nilai (semua periode)</h2></div>
            <div class="card-body">
                <canvas id="grafikNilai" height="240" role="img" aria-label="Grafik jumlah nilai per huruf mutu"></canvas>
                <table class="table table-sm mt-3 mb-0 small">
                    <tr><?php foreach ($distribusi as $h => $n) : ?><th class="text-center"><?= $h ?></th><?php endforeach ?></tr>
                    <tr><?php foreach ($distribusi as $n) : ?><td class="text-center tabular"><?= $n ?></td><?php endforeach ?></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/sb-admin-2/vendor/chart.js/Chart.min.js') ?>"></script>
<script>
    new Chart(document.getElementById('grafikNilai'), {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($distribusi)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($distribusi)) ?>,
                backgroundColor: ['#15803d', '#16a34a', '#1e40af', '#3b82f6', '#d97706', '#dc2626', '#991b1b']
            }]
        },
        options: {
            legend: { display: false },
            animation: { duration: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 0 : 600 },
            scales: { yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }] }
        }
    });
</script>
<?= $this->endSection() ?>
