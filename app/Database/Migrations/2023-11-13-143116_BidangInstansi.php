<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BidangInstansi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bidang' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_bidang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'id_instansi' => [
                'type' => 'INT',
                'constraint' => 11,
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
        $this->forge->addKey('id_bidang', true);
        // $this->forge->addForeignKey('id_instansi', 'instansis', 'id_instansi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bidanginstansis');
    }

    public function down()
    {
        $this->forge->dropTable('bidanginstansis');
    }
}
