<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pengawas extends Seeder
{
    public function run()
    {
        $pengawas = [
            [
                'nama_pengawas' => 'Sutiyono',
            ],
            [
                'nama_pengawas' => 'Suryono',
            ],
        ];

        $this->db->table('pengawas')->insertBatch($pengawas);
    }
}