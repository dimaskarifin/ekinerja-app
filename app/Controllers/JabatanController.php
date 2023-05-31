<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JabatanModel;

class JabatanController extends BaseController
{

    protected $jabatan;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->jabatan = new JabatanModel();
    }

    public function rulesJb()
    {
        $jbRules = [
            'nama_jabatan' => [
                'label' => 'Nama Jabatan',
                'rules' => 'required'
            ]
        ];
        return $jbRules;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Jabatan',
            'jabatan' => $this->jabatan->getJabatans(),
        ];

        return view('mandor/jabatan/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesJb());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);

            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-jabatan'));
        }

        $jabatan = [
            'nama_jabatan' => $data['nama_jabatan']
        ];

        $this->jabatan->insertJabatan($jabatan);
        session()->setFlashdata("success", "Data berhasil ditambahkan");
        return redirect()->to(base_url('mandor/kelola-jabatan'));
    }
}
