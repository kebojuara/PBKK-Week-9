<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\PesanModel;
use App\Models\ProgramStudiModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $mahasiswaModel = new MahasiswaModel();
        $programStudi   = (new ProgramStudiModel())->withJumlahMahasiswa();

        return view('admin/dashboard', [
            'title'          => 'Dashboard',
            'totalMahasiswa' => $mahasiswaModel->countAllResults(),
            'totalProdi'     => count($programStudi),
            'totalPesan'     => (new PesanModel())->countAllResults(),
            'rataIpk'        => $mahasiswaModel->rataRataIpk(),
            'programStudi'   => $programStudi,
            'terbaru'        => $mahasiswaModel->terbaru(5),
        ]);
    }
}
