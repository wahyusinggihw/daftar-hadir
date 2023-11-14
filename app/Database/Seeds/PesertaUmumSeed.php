<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PesertaUmumSeed extends Seeder
{
    public function run()
    {
        $uuid = Uuid::uuid4()->toString();
        $uuid2 = Uuid::uuid4()->toString();


        // faker name
        $data = [
            [
                'id' => $uuid,
                'NIK' => '1234567890123456',
                'nama' => 'Kurnia Ramadhan',
                'alamat' => 'Jl. Peserta Umum',
                'no_hp' => '081234567890',
                'asal_instansi' => 'Peserta Umum',
                'created_at' => date('Y-m-d H:i:s'),

            ],
            [
                'id' => $uuid2,
                'NIK' => '1234567890123456',
                'nama' => 'Rama Dani',
                'alamat' => 'Jl. Peserta Umum',
                'no_hp' => '081234567890',
                'asal_instansi' => 'Peserta Umum',
                'created_at' => date('Y-m-d H:i:s'),

            ],
        ];

        $this->forge->addKey('id', true);
        $this->db->table('pesertaumums')->insertBatch($data);
    }
}
