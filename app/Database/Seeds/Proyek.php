<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Proyek extends Seeder
{
    public function run()
    {
        $proyek = [
            [
                'no_proyek' => '01/P50/2023',
                'nama_proyek' => 'Pembangunan Jalan Tol',
                'pelaksana_id' => 3,
                'mandor_id' => 4,
                'tukang_id' => 5,
                'kegiatan_id' => 1,
                'target' => 10,
                'satuan' => 'Km',
                'output' => 'selesai',
                'tanggal_pelaksanaan' => date('Y-m-d ', strtotime('now', strtotime(date('Y-m-d')))),
                'tanggal_selesai_pelaksanaan' => date('Y-m-d', strtotime('+7 days', strtotime(date('Y-m-d')))),
            ],
            [
                'no_proyek' => '02/P50/2023',
                'nama_proyek' => 'Pembangunan Jalan Desa',
                'pelaksana_id' => 2,
                'mandor_id' => 4,
                'tukang_id' => 6,
                'kegiatan_id' => 2,
                'target' => 10,
                'satuan' => 'Km',
                'output' => 'selesai',
                'tanggal_pelaksanaan' => date('Y-m-d ', strtotime('now', strtotime(date('Y-m-d')))),
                'tanggal_selesai_pelaksanaan' => date('Y-m-d', strtotime('+7 days', strtotime(date('Y-m-d')))),
            ]
        ];
        $this->db->table('proyek')->insertBatch($proyek);
    }
}
