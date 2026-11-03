<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Program extends BaseController
{
    public function detail(string $slug): string
    {
        $program = (new ProgramStudiModel())->findBySlug($slug);

        if ($program === null) {
            throw PageNotFoundException::forPageNotFound("Program studi \"{$slug}\" tidak ditemukan.");
        }

        return view('pages/program_detail', [
            'title'     => $program['nama'],
            'program'   => $program,
            'mahasiswa' => (new MahasiswaModel())->findByProdi((int) $program['id']),
        ]);
    }
}
