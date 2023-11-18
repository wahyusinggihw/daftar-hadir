<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DaftarHadir extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_daftar_hadir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            // 'kode_rapat' => [
            //     'type' => 'VARCHAR',
            //     'constraint' => 255,
            // ],
            'id_agenda_rapat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'NIK' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'asal_instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ttd' => [
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
        $this->forge->addKey('id_daftar_hadir', true);
        $this->forge->addForeignKey('id_agenda_rapat', 'agendarapats', 'id_agenda', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('NIK', 'pesertaumums', 'NIK', 'CASCADE', 'CASCADE');
        $this->forge->createTable('daftarhadirs');
    }

    public function down()
    {
        $this->forge->dropTable('daftarhadirs');
    }
}
