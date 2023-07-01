<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Jabatan extends Seeder
{
    public function run()
    {
        $jabatan = [
            [
                'nama_jabatan' => 'Tukang',
            ],
            [
                'nama_jabatan' => 'Sopir',
            ],
            [
                'nama_jabatan' => 'Pelaksana',
            ],
            [
                'nama_jabatan' => 'Operator',
            ],
            [
                'nama_jabatan' => 'Mandor',
            ],
            [
                'nama_jabatan' => 'Tenaga Kebersihan',
            ],
            [
                'nama_jabatan' => 'Admin',
            ],
        ];

        $this->db->table('jabatan')->insertBatch($jabatan);
    }
}