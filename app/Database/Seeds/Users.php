<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $user = [
            [
                'nik' => 3506220101610010,
                'nama' => 'Imam Sururi',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'mandor',
                'foto' => 'Imam.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 5,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3504050606790003,
                'nama' => 'Suryono',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'pelaksana',
                'foto' => 'Suryono.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 3,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3571010602680010,
                'nama' => 'Sutiyono',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'pelaksana',
                'foto' => 'Sutiyono.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 3,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3506220104920001,
                'nama' => 'Andrian Prasetyo',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Andrian.jpeg',
                'pengawas_id' => 1,
                'jabatan_id' => 1,
                'bidang_id' => 1,
            ],
            [
                'nik' => 3506131201910004,
                'nama' => 'Puji Santoso',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Puji.jpeg',
                'pengawas_id' => 2,
                'jabatan_id' => 1,
                'bidang_id' => 2,
            ],
            [
                'nik' => 3506011303800001,
                'nama' => 'Samiaji',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Samiaji.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 2,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3506111504610002,
                'nama' => 'Kuswandi',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Kuswandi.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 2,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3571022903830003,
                'nama' => 'Eko Joko Prasetyo',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Eko.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 1,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3518061012700002,
                'nama' => 'Kurnia',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Kurnia.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 2,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3506132111710001,
                'nama' => 'Wijianto',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Wijianto.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 4,
                'bidang_id' => 3,
            ],
            [
                'nik' => 3506220404700002,
                'nama' => 'Jaelani',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'tukang',
                'foto' => 'Jaelani.jpeg',
                'pengawas_id' => 3,
                'jabatan_id' => 2,
                'bidang_id' => 3,
            ],
        ];

        $this->db->table('users')->insertBatch($user);
    }
}
