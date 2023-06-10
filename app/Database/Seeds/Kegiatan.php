<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kegiatan extends Seeder
{
    public function run()
    {
        $kegiatan = [
            [
                'uraian_kegiatan' => 'Pemetaan (Pengukuran Jalan)',
                'satuan'          => 'm',
                'target'          => '10'
            ],
            [
                'uraian_kegiatan' => 'Pembersihan (Membersihkan rumput/semak)',
                'satuan'          => 'm',
                'target'          => '20'
            ],
        ];

        $this->db->table('kegiatan')->insertBatch($kegiatan);
    }
}
