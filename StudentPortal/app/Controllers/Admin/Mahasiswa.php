<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\ProgramStudiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RedirectResponse;

class Mahasiswa extends BaseController
{
    private const FOTO_DIR = FCPATH . 'uploads/mahasiswa/';

    private const FOTO_RULES = [
        'label' => 'Foto',
        'rules' => 'uploaded[foto]'
            . '|is_image[foto]'
            . '|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
            . '|ext_in[foto,jpg,jpeg,png,webp]'
            . '|max_size[foto,2048]',
    ];

    private MahasiswaModel $model;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
    }

    public function index(): string
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $prodi   = $this->request->getGet('prodi');
        $prodiId = ctype_digit((string) $prodi) ? (int) $prodi : null;

        return view('admin/mahasiswa/index', [
            'title'        => 'Data Mahasiswa',
            'mahasiswa'    => $this->model->cari($keyword, $prodiId, 10),
            'pager'        => $this->model->pager,
            'keyword'      => $keyword,
            'prodiId'      => $prodiId,
            'programStudi' => $this->daftarProdi(),
        ]);
    }

    public function new(): string
    {
        return view('admin/mahasiswa/form', [
            'title'        => 'Tambah Mahasiswa',
            'mahasiswa'    => null,
            'programStudi' => $this->daftarProdi(),
        ]);
    }

    public function create(): RedirectResponse
    {
        $data = $this->ambilInput();

        if (! $this->model->validate($data)) {
            return $this->gagal($this->model->errors());
        }

        $foto = $this->request->getFile('foto');
        if ($this->adaFile($foto)) {
            if (! $this->validate(['foto' => self::FOTO_RULES])) {
                return $this->gagal($this->validator->getErrors());
            }
            $data['foto'] = $this->simpanFoto($foto);
        }

        $this->model->insert($data, false);

        return redirect()->to('/admin/mahasiswa')->with('success', "Mahasiswa {$data['nama']} berhasil ditambahkan.");
    }

    public function edit(int $id): string
    {
        return view('admin/mahasiswa/form', [
            'title'        => 'Edit Mahasiswa',
            'mahasiswa'    => $this->cariAtau404($id),
            'programStudi' => $this->daftarProdi(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $lama = $this->cariAtau404($id);
        $data = ['id' => $id] + $this->ambilInput();

        if (! $this->model->validate($data)) {
            return $this->gagal($this->model->errors());
        }

        $foto = $this->request->getFile('foto');
        if ($this->adaFile($foto)) {
            if (! $this->validate(['foto' => self::FOTO_RULES])) {
                return $this->gagal($this->validator->getErrors());
            }
            $data['foto'] = $this->simpanFoto($foto);
            $this->hapusFoto($lama['foto']);
        } elseif ($this->request->getPost('hapus_foto') === '1') {
            $data['foto'] = null;
            $this->hapusFoto($lama['foto']);
        }

        unset($data['id']);
        $this->model->skipValidation(true)->update($id, $data);

        return redirect()->to('/admin/mahasiswa')->with('success', "Data {$data['nama']} berhasil diperbarui.");
    }

    public function delete(int $id): RedirectResponse
    {
        $mahasiswa = $this->cariAtau404($id);

        $this->model->delete($id);
        $this->hapusFoto($mahasiswa['foto']);

        return redirect()->to('/admin/mahasiswa')->with('success', "Mahasiswa {$mahasiswa['nama']} berhasil dihapus.");
    }

    // ------------------------------------------------------------------

    private function ambilInput(): array
    {
        $input = $this->request->getPost(['nim', 'nama', 'email', 'program_studi_id', 'angkatan', 'ipk']);

        return array_map(static fn ($v) => is_string($v) ? trim($v) : $v, $input);
    }

    private function gagal(array $errors): RedirectResponse
    {
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    private function cariAtau404(int $id): array
    {
        $mahasiswa = $this->model->find($id);

        if ($mahasiswa === null) {
            throw PageNotFoundException::forPageNotFound('Data mahasiswa tidak ditemukan.');
        }

        return $mahasiswa;
    }

    private function daftarProdi(): array
    {
        return (new ProgramStudiModel())->orderBy('nama')->findAll();
    }

    private function adaFile(?UploadedFile $file): bool
    {
        return $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
    }

    /**
     * Nama file diacak agar tidak bentrok dan tidak bisa ditebak.
     */
    private function simpanFoto(UploadedFile $file): string
    {
        $nama = $file->getRandomName();
        $file->move(self::FOTO_DIR, $nama);

        return $nama;
    }

    private function hapusFoto(?string $nama): void
    {
        if ($nama === null || $nama === '') {
            return;
        }

        $path = self::FOTO_DIR . basename($nama);
        if (is_file($path)) {
            unlink($path);
        }
    }
}
