<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AgendaRapat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_agenda' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_admin' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_instansi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_bidang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_bidang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_rapat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'agenda_rapat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'jam' => [
                'type' =>  'VARCHAR',
                'constraint' => 6,
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'link_rapat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            // 'status' => [
            //     'type' => 'enum',
            //     'constraint' => ['tersedia', 'selesai'],
            // ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_agenda', true);
        $this->forge->addUniqueKey('id_agenda');
        // $this->forge->addUniqueKey('kode_rapat');
        // $this->forge->addUniqueKey('id_admin');
        // $this->forge->addForeignKey('id_admin', 'admins', 'id_admin', 'CASCADE', 'CASCADE');
        $this->forge->createTable('agendarapats');
    }

    public function down()
    {
        $this->forge->dropTable('agendarapats');
    }
}
