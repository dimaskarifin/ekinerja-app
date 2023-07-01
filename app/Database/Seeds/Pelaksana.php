<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pelaksana extends Seeder
{
    public function run()
    {
        $pelaksana = [
            [
                'nama_pelaksana' => 'Sutiyono',
            ],
            [
                'nama_pelaksana' => 'Suryono',
            ],
        ];

        $this->db->table('pelaksana')->insertBatch($pelaksana);
    }
}
