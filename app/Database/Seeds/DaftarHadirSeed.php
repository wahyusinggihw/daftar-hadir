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
                'id_agenda_rapat' => 'c63021b2-5f35-49c3-9587-731ad0f28e24',
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
