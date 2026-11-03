<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Direktori extends BaseController
{
    public function index(): string
    {
        $model   = new MahasiswaModel();
        $keyword = trim((string) $this->request->getGet('q'));
        $prodi   = $this->request->getGet('prodi');
        $prodiId = ctype_digit((string) $prodi) ? (int) $prodi : null;

        return view('pages/direktori', [
            'title'        => 'Direktori Mahasiswa',
            'mahasiswa'    => $model->cari($keyword, $prodiId, 8),
            'pager'        => $model->pager,
            'keyword'      => $keyword,
            'prodiId'      => $prodiId,
            'programStudi' => (new ProgramStudiModel())->orderBy('nama')->findAll(),
        ]);
    }

    public function detail(string $nim): string
    {
        $mahasiswa = (new MahasiswaModel())->findByNim($nim);

        if ($mahasiswa === null) {
            throw PageNotFoundException::forPageNotFound("Mahasiswa dengan NIM {$nim} tidak ditemukan.");
        }

        return view('pages/mahasiswa_detail', [
            'title'     => $mahasiswa['nama'],
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
