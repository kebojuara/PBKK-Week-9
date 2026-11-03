<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $db = \App\Libraries\DemoSeedGuard::requireEmpty();
        $db->transException(true)->transBegin();
        try {
            $this->seedDemo();
            if (! $db->transStatus()) {
                throw new \RuntimeException('Demo seed gagal; transaksi dibatalkan.');
            }
            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            throw $e;
        }
    }

    private function seedDemo(): void
    {
        $this->call('UserSeeder');
        $this->call('ProgramStudiSeeder');
        $this->call('MahasiswaSeeder');
    }
}
