<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pengawas extends Seeder
{
    public function run()
    {
        $pengawas = [
            [
                'nama_pengawas' => 'Ir.Keren Banget',
            ],
            [
                'nama_pengawas' => 'Dr.Semangat',
            ],
            [
                'nama_pengawas' => 'Dr.Semngat',
            ],
        ];

        $this->db->table('pengawas')->insertBatch($pengawas);
    }
}
