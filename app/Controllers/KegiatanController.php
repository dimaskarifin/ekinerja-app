<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\UsersModel;

class KegiatanController extends BaseController
{

    protected $kegiatan;
    protected $users;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->kegiatan = new KegiatanModel();
        $this->users = new UsersModel();
    }

    public function rulesKG()
    {
        $rulesKG = [
            'id_users' => [
                'label' => 'Nama Pegawai',
                'rules' => 'required'
            ],
            'uraian_kegiatan' => [
                'label' => 'Uraian Kegiatan',
                'rules' => 'required'
            ],
            'satuan' => [
                'label' => 'Satuan',
                'rules' => 'required'
            ],
            'target' => [
                'label' => 'Target',
                'rules' => 'required'
            ]
        ];
        return $rulesKG;
    }

    public function index()
    {

        $data = [
            'title' => 'Kelola Kegiatan',
            'kegiatan' => $this->kegiatan->getKegiatanDetail(),
            'users' => $this->users->select('users.id, users.nama, users.role')->findAll()
        ];

        return view('mandor/kegiatan/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesKG());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-kegiatan'));
        }

        $dataKG = [
            'id_users' => $data['id_users'],
            'uraian_kegiatan' => $data['uraian_kegiatan'],
            'satuan' => $data['satuan'],
            'target' => $data['target']
        ];

        $this->kegiatan->insertKegiatan($dataKG);

        session()->setFlashdata("success", "Berhasil menambahkan data");
        return redirect()->to(base_url('mandor/kelola-kegiatan'));
    }
}
