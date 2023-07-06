<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\ProyekModel;
use App\Models\UsersModel;

class DashboardController extends BaseController
{
    protected $kegiatan, $users, $proyek;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);

        $this->kegiatan = new KegiatanModel;
        $this->users = new UsersModel;
        $this->proyek = new ProyekModel;
    }

    public function index()
    {
        $get_data = $this->request->getGet();

        $data = [
            'title' => 'Dashboard Panel E-Kinerja',
            'total_kegiatan' => $this->kegiatan->where('deleted_at', null)->countAllResults(),
            'total_proyek' => $this->proyek->where('deleted_at', null)->countAllResults(),
            'total_user' => $this->users->where('deleted_at', null)->countAllResults(),
            'chart' => $this->proyek->getTotalProyekTukangUser($get_data)
        ];

        return view('dashboard', $data);
    }
}
