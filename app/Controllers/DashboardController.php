<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard Panel E-Kinerja'
        ];
        return view('dashboard', $data);
    }
}
