<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_admin' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type' => 'enum',
                'constraint' => ['superadmin', 'admin', 'operator'],
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'avatar' => [
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
        $this->forge->addKey('id_admin', true);
        // relation to agendarapats
        // $this->forge->addForeignKey('id_admin', 'agendarapats', 'id_admin_rapat', 'CASCADE', 'CASCADE');
        return $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
