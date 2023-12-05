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
            'id_bidang' => 'd51476a5-627d-37e4-9734-eac706850787',
            'nama_bidang' => 'Persandian dan Statistik',
            'nama_kepala_bidang' => 'Drs. H. M. Syafruddin, M.Si',
            'nip_kepala_bidang' => '196606011992031001',
            'slug' => 'persandian-dan-statistik',
            'id_instansi' => '75010306',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('bidanginstansis')->insert($dataBidang);
    }
}
