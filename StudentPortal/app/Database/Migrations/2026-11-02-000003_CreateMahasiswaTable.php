<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMahasiswaTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nim'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'nama'             => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'program_studi_id' => ['type' => 'INT', 'unsigned' => true],
            'angkatan'         => ['type' => 'SMALLINT', 'unsigned' => true],
            'ipk'              => ['type' => 'DECIMAL', 'constraint' => '3,2', 'default' => '0.00'],
            'foto'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nim');
        $this->forge->addKey('program_studi_id');
        $this->forge->addForeignKey('program_studi_id', 'program_studi', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('mahasiswa');
    }

    public function down(): void
    {
        $this->forge->dropTable('mahasiswa');
    }
}
