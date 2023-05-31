<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kegiatan extends Seeder
{
    public function run()
    {
        $kegiatan = [
            [
                'id_users'        => 1,
                'uraian_kegiatan' => 'Pemetaan (Pengukuran Jalan)',
                'satuan'          => 'M',
                'target'          => '10'
            ],
            [
                'id_users' => 2,
                'uraian_kegiatan' => 'Pembersihan (Membersihkan rumput/semak)',
                'satuan'          => 'M',
                'target'          => '20'
            ],
        ];

        $this->db->table('kegiatan')->insertBatch($kegiatan);
    }
}
