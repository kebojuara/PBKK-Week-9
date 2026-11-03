<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;

class Home extends BaseController
{
    public function index(): string
    {
        $mahasiswaModel = new MahasiswaModel();
        $programStudi   = (new ProgramStudiModel())->withJumlahMahasiswa();

        // Program studi dengan mahasiswa terbanyak ditampilkan paling depan (kartu besar).
        usort($programStudi, static fn (array $a, array $b): int => $b['jumlah_mahasiswa'] <=> $a['jumlah_mahasiswa']);

        return view('pages/home', [
            'title'          => 'Beranda',
            'programStudi'   => $programStudi,
            'totalMahasiswa' => $mahasiswaModel->countAllResults(),
            'rataIpk'        => $mahasiswaModel->rataRataIpk(),
            'terbaru'        => $mahasiswaModel->terbaru(4),
        ]);
    }
}
