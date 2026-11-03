<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProgramStudiTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 10],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 120],
            'fakultas'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('program_studi');
    }

    public function down(): void
    {
        $this->forge->dropTable('program_studi');
    }
}
