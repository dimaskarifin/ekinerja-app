<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Bidang extends Seeder
{
    public function run()
    {
        $bidang = [
            [
                'nama_bidang' => 'Konstruksi Bangunan',
            ],
            [
                'nama_bidang' => 'Konstruksi Teknik',
            ],
            [
                'nama_bidang' => 'Konstruksi Industri',
            ],
        ];

        $this->db->table('bidang')->insertBatch($bidang);
    }
}
