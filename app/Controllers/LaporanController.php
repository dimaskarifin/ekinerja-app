<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LaporanController extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Laporan'
        ];

        return view('pelaporan/laporan/index', $data);
    }
}
