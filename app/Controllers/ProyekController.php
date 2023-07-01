<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\ProyekModel;
use App\Models\UsersModel;

class ProyekController extends BaseController
{

    protected $users;
    protected $kegiatan;
    protected $proyek;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
        $this->kegiatan = new KegiatanModel();
        $this->proyek = new ProyekModel();
    }

    function rulesProyek()
    {
        $rules = [];

        return $rules;
    }


    function indexPelaksana()
    {
        $data = [
            'title' => 'Kelola Proyek',
            'mandor' => $this->users->where('role', 'mandor')->findAll(),
            'pelaksana' => $this->users->where('role', 'pelaksana')->findAll(),
            'proyek' => $this->proyek->getDetailProyekPelaksana(),
            'kegiatan' => $this->kegiatan->getKegiatans(),
        ];

        // dd($data['mandor']);

        return view('pelaksana/proyek/index', $data);
    }

    function indexMandor()
    {
        $data = [
            'title'  => 'Kelola Proyek',
        ];

        return view('mandor/proyek/index', $data);
    }
    function indexTukang()
    {
        $data = [
            'title' => 'Kelola Proyek',
        ];

        return view('tukang/proyek/index', $data);
    }

    function storePelaksana()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        // $validation->setRules($this->rulesProyek);
    }
}
