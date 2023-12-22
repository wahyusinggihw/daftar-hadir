<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class DaftarHadirSeed extends Seeder
{
    public function run()
    {


        for ($i = 1; $i < 21; $i++) {
            # code...
            $uuid = Uuid::uuid4()->toString();
            $faker = Factory::create();
            $dataDaftarHadir = [
                'id_daftar_hadir' => $uuid,
                'slug' => $faker->slug(),
                'id_agenda_rapat' => '515dfc1e-a60f-4a81-b2d3-269f39a8a541',
                'NIK' => $faker->randomNumber(9, true),
                'nama' => $faker->name(),
                'no_hp' => $faker->phoneNumber(),
                'status' => 'pegawai',
                'asal_instansi' => 'Kominfo',
                'ttd' => 'ttd',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->table('daftarhadirs')->insert($dataDaftarHadir);
        }
    }
}
