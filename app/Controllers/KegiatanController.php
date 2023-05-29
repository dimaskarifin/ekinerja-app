<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class KegiatanController extends BaseController
{
    public function index()
    {
        return view('tukang/kegiatan/index');
    }
}
