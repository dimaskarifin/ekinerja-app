<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Ekinerja extends Seeder
{
    public function run()
    {

        $ekinerja = [
            [
                'id_users'        => 1,
                'id_kegiatan'     => 1,
                'output'          => 'Pemetaan Selesai',
                'waktu_mulai'     => date('Y-m-d ', strtotime('now', strtotime(date('Y-m-d')))),
                'waktu_selesai'   => date('Y-m-d', strtotime('+7 days', strtotime(date('Y-m-d')))),
            ],
            [
                'id_users'        => 2,
                'id_kegiatan'     => 2,
                'output'          => 'Pembangunan Selesai',
                'waktu_mulai'     => date('Y-m-d', strtotime('now', strtotime(date('Y-m-d')))),
                'waktu_selesai'   => date('Y-m-d', strtotime('+7 days', strtotime(date('Y-m-d')))),
            ],
        ];

        $this->db->table('ekinerja')->insertBatch($ekinerja);
    }
}
