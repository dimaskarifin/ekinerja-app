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
            [
                'uraian_kegiatan' => 'Pembentukan (Badan jalan / rancangan )',
            ],
            [
                'uraian_kegiatan' => 'Pemadatan (Proses pemadatan menggunakan alat khusus)',
            ],
            [
                'uraian_kegiatan' => 'Pondasi (Material batu-batuan, aspal)',
            ],
            [
                'uraian_kegiatan' => 'Hotmix (Material aspal, yang tersusun : agregat halus, filler / bahan pengisi)',
            ],
            [
                'uraian_kegiatan' => 'Permukaan (Menggunakan tandem roller / mesin)',
            ],
            [
                'uraian_kegiatan' => 'Finishing (Perataan pengaspalan hotmix)',
            ],
            [
                'uraian_kegiatan' => 'Marka jalan (tanda dipermukaan jalan)'
            ]
        ];

        $this->db->table('kegiatan')->insertBatch($kegiatan);
    }
}
