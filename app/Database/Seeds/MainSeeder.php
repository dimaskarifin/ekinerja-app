<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->call('users');
        $this->call('pengawas');
        $this->call('bidang');
        $this->call('jabatan');
    }
}
