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
            ],
            [
                'uraian_kegiatan' => 'Pembersihan (Membersihkan rumput/semak)',
            ],
        ];

        $this->db->table('kegiatan')->insertBatch($kegiatan);
    }
}
