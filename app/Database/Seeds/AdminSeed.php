<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;
// fake
use Faker\Factory;

class AdminSeed extends Seeder
{
    public function run()
    {
        // user
        $faker = Factory::create();
        helper('my_helper');

        $instansis = [
            'dap.bulelengkab.go.id',
            'disbud.bulelengkab.go.id',
            'disdukcapil.bulelengkab.go.id',
            'dinkes.bulelengkab.go.id',
            'dkpp.bulelengkab.go.id',
            'kominfosanti.bulelengkab.go.id',
            'dlh.bulelengkab.go.id',
            'dispar.bulelengkab.go.id',
            'putr.bulelengkab.go.id',
            'damkar.bulelengkab.go.id',
            'dispmd.bulelengkab.go.id',
            'dpmptsp.bulelengkab.go.id',
            'disdikpora.bulelengkab.go.id',
            'daldukkbpppa.bulelengkab.go.id',
            'disdagperinkopukm.bulelengkab.go.id',
            'dishub.bulelengkab.go.id',
            'distan.bulelengkab.go.id',
            'disperkimta.buleleng.go.id',
            'dinsos.bulelengkab.go.id',
            'disnaker.bulelengkab.go.id',
            'bkpsdm.bulelengkab.go.id',
            'bkbp.bulelengkab.go.id',
            'bpbd.bulelengkab.go.id',
            'balitbang.bulelengkab.go.id',
            'bpkpd.bulelengkab.go.id',
            'bappeda.bulelengkab.go.id',
            'inspektoratdaerah.bulelengkab.go.id',
            'polpp.bulelengkab.go.id',
            'perumdapasar.bulelengkab.go.id',
            'perumdaswatantra.bulelengkab.go.id',
            'rsud.bulelengkab.go.id',
            'dprd.bulelengkab.go.id',
            'pkk.bulelengkab.go.id',
            'korpri.bulelengkab.go.id',
            'buleleng.bulelengkab.go.id',
            'sukasada.bulelengkab.go.id',
            'sawan.bulelengkab.go.id',
            'kubutambahan.bulelengkab.go.id',
            'banjar.bulelengkab.go.id',
            'seririt.bulelengkab.go.id',
            'busungbiu.bulelengkab.go.id',
            'gerokgak.bulelengkab.go.id',
            'tejakula.bulelengkab.go.id'
        ];


        $adminInstansiData = [];

        // foreach ($instansis as $instansi) {
        //     $instanceNameWithoutDomain = str_replace('.bulelengkab.go.id', '', $instansi);
        //     $adminInstansiData[] = [
        //         'id_admin' => $faker->uuid,
        //         'slug' => str_replace(['.', '-'], '', $instanceNameWithoutDomain),
        //         'nama' => 'Admin ' . ucfirst($instanceNameWithoutDomain),
        //         'role' => 'admin',
        //         'id_instansi' => $faker->randomNumber(8),
        //         'nama_instansi' => ucfirst($instanceNameWithoutDomain),
        //         'username' => strtolower($instanceNameWithoutDomain),
        //         'avatar' => 'default.png',
        //         'password' => password_hash('Admin123', PASSWORD_DEFAULT),
        //         'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        //     ];
        // }

        $this->forge->addKey('id_admin', true);
        // Admin Data
        $superAdmin = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887d',
            'slug' => 'super-admin',
            'nama' => 'Super Admin',
            'role' => 'superadmin',
            'id_instansi' => 'superadmin',
            'nama_instansi' => 'Super Admin',
            'id_bidang' => 'superadmin',
            'nama_bidang' => 'Super Admin',
            'username' => 'super',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('super', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // admin instansi data
        $adminInstansiData = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887f',
            'slug' => 'kominfo',
            'nama' => 'Kominfosanti',
            'role' => 'admin',
            'id_instansi' => '75010306',
            'nama_instansi' => 'Kominfosanti',
            'username' => 'kominfosanti',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('kominfosanti', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // operator data
        $operatorData = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887e',
            'slug' => 'op-persandian',
            'nama' => 'Op Persandian',
            'role' => 'operator',
            'id_instansi' => '75010306',
            'nama_instansi' => 'Kominfosanti',
            'id_bidang' => 'd51476a5-627d-37e4-9734-eac706850787',
            'nama_bidang' => 'Persandian dan Statistik',
            'username' => 'sandi',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('sandi', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('admins')->insert($superAdmin);
        $this->db->table('admins')->insertBatch($adminInstansiData);
        $this->db->table('admins')->insert($operatorData);

        // for ($i = 0; $i < 3; $i++) {
        //     # code...
        //     $operator = [
        //         'id_admin' => $faker->uuid,
        //         'slug' => $faker->slug,
        //         'nama' => $faker->name,
        //         'role' => 'operator',
        //         'id_instansi' => 'instansi1',
        //         'username' => $faker->userName,
        //         'password' => password_hash('operator', PASSWORD_DEFAULT),
        //         'created_at' => $faker->date('Y-m-d H:i:s'),
        //     ];
        //     // Insert Admin Data
        //     $this->db->table('admins')->insert($operator);
        // }
        // for ($i = 0; $i < 3; $i++) {
        //     # code...
        //     $operator = [
        //         'id_admin' => $faker->uuid,
        //         'slug' => $faker->slug,
        //         'nama' => $faker->name,
        //         'role' => 'operator',
        //         'id_instansi' => 'instansi2',
        //         'username' => $faker->userName,
        //         'password' => password_hash('operator', PASSWORD_DEFAULT),
        //         'created_at' => $faker->date('Y-m-d H:i:s'),
        //     ];
        //     // Insert Admin Data
        //     $this->db->table('admins')->insert($operator);
        // }
        // for ($i = 0; $i < 3; $i++) {
        //     # code...
        //     $operator = [
        //         'id_admin' => $faker->uuid,
        //         'slug' => $faker->slug,
        //         'nama' => $faker->name,
        //         'role' => 'operator',
        //         'id_instansi' => 'instansi3',
        //         'username' => $faker->userName,
        //         'password' => password_hash('operator', PASSWORD_DEFAULT),
        //         'created_at' => $faker->date('Y-m-d H:i:s'),
        //     ];
        //     // Insert Admin Data
        //     $this->db->table('admins')->insert($operator);
        // }

        // // die;
        // for ($i = 0; $i < 3; $i++) {
        //     $adminData = [
        //         'id_admin' => $faker->uuid,
        //         'slug' => $faker->slug,
        //         'nama' => $faker->name,
        //         'role' => 'admin',
        //         'id_instansi' => 'instansi' . ($i + 1),
        //         'username' => $faker->userName,
        //         'password' => password_hash('admin', PASSWORD_DEFAULT),
        //         'created_at' => $faker->date('Y-m-d H:i:s'),
        //     ];

        // Insert Admin Data
        // $this->db->table('admins')->insert($adminData);
        // }



        // $data = [
        //     [
        //         'id_admin' => $uuid,
        //         'slug' => 'super-admin',
        //         'nama' => 'Super Admin',
        //         'role' => 'superadmin',
        //         'id_instansi' => 'superadmin',
        //         'username' => 'super',
        //         'password' => password_hash('super', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'id_admin' => $uuid2,
        //         'slug' => 'admin1',
        //         'nama' => 'Admin Satu',
        //         'role' => 'admin',
        //         'id_instansi' => 'instansi1',
        //         'username' => 'admin1',
        //         'password' => password_hash('admin1', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'id_admin' => $uuid3,
        //         'slug' => 'operator1',
        //         'nama' => 'Operator Satu',
        //         'role' => 'operator',
        //         'id_instansi' => 'instansi1',
        //         'username' => 'operator1',
        //         'password' => password_hash('operator1', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'id_admin' => $uuid4,
        //         'slug' => 'admin2',
        //         'nama' => 'Admin Dua',
        //         'role' => 'admin',
        //         'id_instansi' => 'instansi2',
        //         'username' => 'admin2',
        //         'password' => password_hash('admin2', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        //     [
        //         'id_admin' => $uuid5,
        //         'slug' => 'operator2',
        //         'nama' => 'Operator Dua',
        //         'role' => 'operator',
        //         'id_instansi' => 'instansi2',
        //         'username' => 'operator2',
        //         'password' => password_hash('operator2', PASSWORD_DEFAULT),
        //         'created_at' => date('Y-m-d H:i:s'),
        //     ],
        // ];


        // $this->forge->addKey('id_admin', true);
        // $this->db->table('admins')->insertBatch($data);

        // uuid

    }
}
