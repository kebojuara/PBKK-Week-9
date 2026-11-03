<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table         = 'mahasiswa';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nim', 'nama', 'email', 'program_studi_id', 'angkatan', 'ipk', 'foto'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'id'               => 'permit_empty|is_natural_no_zero',
        'nim'              => ['label' => 'NIM', 'rules' => 'required|numeric|exact_length[10]|is_unique[mahasiswa.nim,id,{id}]'],
        'nama'             => ['label' => 'Nama lengkap', 'rules' => 'required|min_length[3]|max_length[100]'],
        'email'            => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[100]'],
        'program_studi_id' => ['label' => 'Program studi', 'rules' => 'required|is_not_unique[program_studi.id]'],
        'angkatan'         => ['label' => 'Angkatan', 'rules' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2030]'],
        'ipk'              => ['label' => 'IPK', 'rules' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[4]'],
    ];

    protected $validationMessages = [
        'nim' => [
            'is_unique'    => 'NIM sudah terdaftar.',
            'exact_length' => 'NIM harus terdiri dari 10 digit.',
        ],
        'program_studi_id' => ['is_not_unique' => 'Program studi tidak valid.'],
        'ipk'              => ['less_than_equal_to' => 'IPK maksimal 4.00.'],
    ];

    /**
     * Query dasar yang selalu menyertakan nama program studi.
     */
    private function withProdi(): self
    {
        return $this->select('mahasiswa.*, program_studi.nama AS nama_prodi, program_studi.slug AS slug_prodi')
            ->join('program_studi', 'program_studi.id = mahasiswa.program_studi_id');
    }

    /**
     * Pencarian + filter program studi, hasilnya dipaginasi.
     */
    public function cari(?string $keyword, ?int $prodiId, int $perPage = 8): array
    {
        $builder = $this->withProdi();

        if ($keyword !== null && $keyword !== '') {
            $builder->groupStart()
                ->like('mahasiswa.nama', $keyword)
                ->orLike('mahasiswa.nim', $keyword)
                ->orLike('mahasiswa.email', $keyword)
                ->groupEnd();
        }

        if ($prodiId !== null) {
            $builder->where('mahasiswa.program_studi_id', $prodiId);
        }

        return $builder->orderBy('mahasiswa.nim', 'ASC')->paginate($perPage);
    }

    public function findByNim(string $nim): ?array
    {
        return $this->withProdi()->where('mahasiswa.nim', $nim)->first();
    }

    public function findByProdi(int $prodiId): array
    {
        return $this->where('program_studi_id', $prodiId)->orderBy('nama', 'ASC')->findAll();
    }

    public function terbaru(int $limit = 5): array
    {
        return $this->withProdi()->orderBy('mahasiswa.created_at', 'DESC')->orderBy('mahasiswa.id', 'DESC')->findAll($limit);
    }

    public function rataRataIpk(): float
    {
        $row = $this->selectAvg('ipk', 'rata')->first();

        return round((float) ($row['rata'] ?? 0), 2);
    }
}
