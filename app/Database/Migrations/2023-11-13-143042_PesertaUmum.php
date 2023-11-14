<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesertaUmum extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peserta_umum' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'NIK' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'asal_instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_peserta_umum', true);
        $this->forge->addUniqueKey('NIK');
        $this->forge->createTable('pesertaumums');
    }

    public function down()
    {
        $this->forge->dropTable('pesertaumums');
    }
}
