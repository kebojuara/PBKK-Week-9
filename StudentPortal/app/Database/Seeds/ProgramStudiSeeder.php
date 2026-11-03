<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        helper('url');

        $now  = date('Y-m-d H:i:s');
        $data = [
            ['IF', 'Teknik Informatika', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Mempelajari rekayasa perangkat lunak, algoritma, kecerdasan buatan, dan sistem komputer.'],
            ['SI', 'Sistem Informasi', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Menggabungkan teknologi informasi dengan proses bisnis dan manajemen organisasi.'],
            ['TK', 'Teknik Komputer', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Fokus pada perangkat keras, sistem tertanam, jaringan, dan Internet of Things.'],
            ['TE', 'Teknik Elektro', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Mempelajari sistem tenaga, elektronika, telekomunikasi, dan kendali.'],
            ['MA', 'Matematika', 'Fakultas Sains dan Analitika Data', 'Mempelajari matematika murni dan terapan, pemodelan, serta analisis data.'],
        ];

        $rows = array_map(static fn (array $p): array => [
            'kode'       => $p[0],
            'nama'       => $p[1],
            'slug'       => url_title($p[1], '-', true),
            'fakultas'   => $p[2],
            'deskripsi'  => $p[3],
            'created_at' => $now,
            'updated_at' => $now,
        ], $data);

        $this->db->table('program_studi')->insertBatch($rows);
    }
}
