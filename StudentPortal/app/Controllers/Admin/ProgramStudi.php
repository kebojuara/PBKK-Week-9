<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ProgramStudi extends BaseController
{
    private ProgramStudiModel $model;

    public function __construct()
    {
        $this->model = new ProgramStudiModel();
    }

    public function index(): string
    {
        return view('admin/program/index', [
            'title'        => 'Program Studi',
            'programStudi' => $this->model->withJumlahMahasiswa(),
        ]);
    }

    public function new(): string
    {
        return view('admin/program/form', ['title' => 'Tambah Program Studi', 'program' => null]);
    }

    public function create(): RedirectResponse
    {
        $data = $this->request->getPost(['kode', 'nama', 'fakultas', 'deskripsi']);

        if (! $this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/program')->with('success', "Program studi {$data['nama']} berhasil ditambahkan.");
    }

    public function edit(int $id): string
    {
        return view('admin/program/form', ['title' => 'Edit Program Studi', 'program' => $this->cariAtau404($id)]);
    }

    public function update(int $id): RedirectResponse
    {
        $this->cariAtau404($id);
        $data = ['id' => $id] + $this->request->getPost(['kode', 'nama', 'fakultas', 'deskripsi']);

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/program')->with('success', "Program studi {$data['nama']} berhasil diperbarui.");
    }

    public function delete(int $id): RedirectResponse
    {
        $program = $this->cariAtau404($id);
        $jumlah  = (new MahasiswaModel())->where('program_studi_id', $id)->countAllResults();

        if ($jumlah > 0) {
            return redirect()->to('/admin/program')
                ->with('error', "Program studi {$program['nama']} masih memiliki {$jumlah} mahasiswa, tidak dapat dihapus.");
        }

        $this->model->delete($id);

        return redirect()->to('/admin/program')->with('success', "Program studi {$program['nama']} berhasil dihapus.");
    }

    private function cariAtau404(int $id): array
    {
        $program = $this->model->find($id);

        if ($program === null) {
            throw PageNotFoundException::forPageNotFound('Program studi tidak ditemukan.');
        }

        return $program;
    }
}
