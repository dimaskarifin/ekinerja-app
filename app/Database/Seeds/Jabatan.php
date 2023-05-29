<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Jabatan extends Seeder
{
    public function run()
    {
        $jabatan = [
            [
                'nama_jabatan' => 'ketua',
            ],
            [
                'nama_jabatan' => 'sekretaris',
            ],
            [
                'nama_jabatan' => 'bendahara',
            ],
        ];

        $this->db->table('jabatan')->insertBatch($jabatan);
    }
}
