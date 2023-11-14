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

        $this->forge->addKey('id_admin', true);
        // Admin Data
        $adminData = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887d',
            'slug' => 'super-admin',
            'nama' => 'Super Admin',
            'role' => 'superadmin',
            'id_instansi' => 'superadmin',
            'username' => 'super',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('super', PASSWORD_DEFAULT),
            'created_at' => $faker->date('Y-m-d H:i:s'),
        ];

        // admin instansi data
        $adminInstansiData = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887f',
            'slug' => 'kominfo',
            'nama' => 'Kominfo',
            'role' => 'admin',
            'id_instansi' => '75010306',
            'nama_instansi' => 'Kominfosanti',
            'username' => 'kominfo',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('kominfo', PASSWORD_DEFAULT),
            'created_at' => $faker->date('Y-m-d H:i:s'),
        ];

        // operator data
        $operatorData = [
            'id_admin' => '21486571-73f7-4570-b8de-d412aa4c887e',
            'slug' => 'op-persandian',
            'nama' => 'Op Persandian',
            'role' => 'operator',
            'id_instansi' => '75010306',
            'nama_instansi' => 'Kominfosanti',
            'id_bidang' => $faker->uuid,
            'nama_bidang' => 'Persandian dan Statistik',
            'username' => 'sandi',
            'avatar' => 'default.png', // 'avatar' => 'default.png
            'password' => password_hash('sandi', PASSWORD_DEFAULT),
            'created_at' => $faker->date('Y-m-d H:i:s'),
        ];
        $this->db->table('admins')->insert($adminData);
        $this->db->table('admins')->insert($adminInstansiData);
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
