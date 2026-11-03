<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesanTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'subjek'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'isi'        => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pesan');
    }

    public function down(): void
    {
        $this->forge->dropTable('pesan');
    }
}
