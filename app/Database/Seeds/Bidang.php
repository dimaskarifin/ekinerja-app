<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Bidang extends Seeder
{
    public function run()
    {
        $bidang = [
            [
                'nama_bidang' => 'Bidang Operational',
            ],
            [
                'nama_bidang' => 'Bidang Kejuruan',
            ],
            [
                'nama_bidang' => 'Bidang Onderdil',
            ],
        ];

        $this->db->table('bidang')->insertBatch($bidang);
    }
}
