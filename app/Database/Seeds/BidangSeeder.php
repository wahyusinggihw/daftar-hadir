<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Faker\Factory;

class BidangSeeder extends Seeder
{
    public function run()
    {
        $uuid = Uuid::uuid4()->toString();
        $dataBidang = [
            'id_bidang' => $uuid,
            'nama_bidang' => 'Persandian dan Statistik',
            'slug' => 'persandian-dan-statistik',
            'id_instansi' => '75010306',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('bidanginstansis')->insert($dataBidang);
    }
}
