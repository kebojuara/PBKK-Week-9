<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramStudiModel extends Model
{
    protected $table          = 'program_studi';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['kode', 'nama', 'slug', 'fakultas', 'deskripsi'];
    protected $useTimestamps  = true;
    protected $beforeInsert   = ['buatSlug'];
    protected $beforeUpdate   = ['buatSlug'];

    protected $validationRules = [
        'id'       => 'permit_empty|is_natural_no_zero',
        'kode'     => ['label' => 'Kode', 'rules' => 'required|alpha_numeric|max_length[10]|is_unique[program_studi.kode,id,{id}]'],
        'nama'     => ['label' => 'Nama program studi', 'rules' => 'required|min_length[3]|max_length[100]|is_unique[program_studi.nama,id,{id}]'],
        'fakultas' => ['label' => 'Fakultas', 'rules' => 'required|max_length[100]'],
    ];

    protected $validationMessages = [
        'kode' => ['is_unique' => 'Kode program studi sudah dipakai.'],
        'nama' => ['is_unique' => 'Nama program studi sudah terdaftar.'],
    ];

    /**
     * Slug dibuat otomatis dari nama, sehingga URL publik selalu konsisten.
     */
    protected function buatSlug(array $data): array
    {
        if (isset($data['data']['nama'])) {
            helper('url');
            $data['data']['slug'] = url_title($data['data']['nama'], '-', true);
        }

        return $data;
    }

    /**
     * Daftar program studi beserta jumlah mahasiswanya.
     */
    public function withJumlahMahasiswa(): array
    {
        return $this->select('program_studi.*, COUNT(mahasiswa.id) AS jumlah_mahasiswa')
            ->join('mahasiswa', 'mahasiswa.program_studi_id = program_studi.id', 'left')
            ->groupBy('program_studi.id')
            ->orderBy('program_studi.nama', 'ASC')
            ->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->first();
    }
}
