<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $user = [
            [
                'nik' => random_int('1111111111111111', '9999999999999999'),
                'nama' => 'Wirosableng',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'mandor',
                'foto' => 'wiro.jpeg',
                'pengawas_id' => 1,
                'jabatan_id' => 1,
                'bidang_id' => 1,
            ],
            [
                'nik' => random_int('1111111111111111', '9999999999999999'),
                'nama' => 'Wiro Hustle',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'pelaksana',
                'foto' => 'wiro.jpeg',
                'pengawas_id' => 2,
                'jabatan_id' => 2,
                'bidang_id' => 2,
            ],
            [
                'nik' => random_int('1111111111111111', '9999999999999999'),
                'nama' => 'Semoga Bisa',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'wiro.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 3,
                'bidang_id' => 3,
            ],
        ];

        $this->db->table('users')->insertBatch($user);
    }
}
