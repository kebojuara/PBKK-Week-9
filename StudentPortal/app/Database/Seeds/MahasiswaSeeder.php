<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $now   = date('Y-m-d H:i:s');
        $prodi = array_column(
            $this->db->table('program_studi')->select('id, kode')->get()->getResultArray(),
            'id',
            'kode'
        );

        $data = [
            ['5025241001', 'Andi Pratama', 'IF', 2024, 3.75],
            ['5025241002', 'Budi Santoso', 'IF', 2024, 3.42],
            ['5025241003', 'Citra Lestari', 'IF', 2024, 3.88],
            ['5026241004', 'Dewi Anggraini', 'SI', 2024, 3.61],
            ['5026241005', 'Eko Saputra', 'SI', 2024, 3.15],
            ['5024241006', 'Fajar Nugroho', 'TK', 2024, 3.27],
            ['5024231007', 'Gita Permata', 'TK', 2023, 3.94],
            ['5022231008', 'Hendra Wijaya', 'TE', 2023, 2.98],
            ['5022231009', 'Intan Maharani', 'TE', 2023, 3.55],
            ['5002231010', 'Joko Susilo', 'MA', 2023, 3.08],
            ['5002241011', 'Kartika Sari', 'MA', 2024, 3.70],
            ['5025231012', 'Lukman Hakim', 'IF', 2023, 3.33],
        ];

        $rows = array_map(static fn (array $m): array => [
            'nim'              => $m[0],
            'nama'             => $m[1],
            'email'            => strtolower(str_replace(' ', '.', $m[1])) . '@student.its.ac.id',
            'program_studi_id' => $prodi[$m[2]],
            'angkatan'         => $m[3],
            'ipk'              => $m[4],
            'foto'             => null,
            'created_at'       => $now,
            'updated_at'       => $now,
        ], $data);

        $this->db->table('mahasiswa')->insertBatch($rows);
    }
}
