<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EkinerjaModel;
use App\Models\KegiatanModel;
use App\Models\UsersModel;

use CodeIgniter\Database\Seeder;

class EkinerjaController extends BaseController
{

    protected $ekinerja;
    protected $users;
    protected $kegiatan;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->ekinerja = new EkinerjaModel();
        $this->users = new UsersModel();
        $this->kegiatan = new KegiatanModel();
    }

    public function rulesEK()
    {
        $rulesEK = [
            'id_users' => [
                'label' => 'Nama Pegawai',
                'rules' => 'required'
            ],
            'id_kegiatan' => [
                'label' => 'Uraian Kegiatan',
                'rules' => 'required'
            ],
            'output' => [
                'label' => 'Output',
                'rules' => 'required'
            ],
            // 'tanggal_mulai' => [
            //     'label' => 'Tanggal Mulai',
            //     'rules' => 'required'
            // ],
            // 'tanggal_selesai' => [
            //     'label' => 'Tanggal Selesai',
            //     'rules' => 'required'
            // ],
        ];
        return $rulesEK;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola E-Kinerja',
            'ekinerja' => $this->ekinerja->getDetailKinerja(),
            'users'    => $this->users->getUsers(),
            'kegiatan' => $this->kegiatan->getKegiatans(),
        ];

        return view('mandor/kinerja/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesEK());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-ekinerja'));
        }

        $dataEK = [
            'id_users' => $data['id_users'],
            'id_kegiatan' => $data['id_kegiatan'],
            'output' => $data['output'],
            'waktu_mulai' => $data['tanggal_mulai'],
            'waktu_selesai' => $data['tanggal_selesai']
        ];

        $this->ekinerja->insertEkinerja($dataEK);

        session()->setFlashdata('success', 'Berhasil menambahkan data kinerja');
        return redirect()->to(base_url('kelola-ekinerja'));
    }
}
