<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EkinerjaModel;
use App\Models\KegiatanModel;
use App\Models\UsersModel;

class DashboardController extends BaseController
{
    protected $kegiatan, $ekinerja, $user;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);

        $this->kegiatan = new KegiatanModel;
        $this->ekinerja = new EkinerjaModel;
        $this->user = new UsersModel;
    }

    public function index()
    {
        $get_data = $this->request->getGet();

        $data = [
            'title' => 'Dashboard Panel E-Kinerja',
            'total_kegiatan' => $this->kegiatan->where('deleted_at', null)->countAllResults(),
            'total_ekinerja' => $this->ekinerja->where('deleted_at', null)->countAllResults(),
            'total_user' => $this->user->where('deleted_at', null)->countAllResults(),
            'chart' => $this->ekinerja->getTotalEkinerjaEachUser($get_data)
        ];

        return view('dashboard', $data);
    }
}
