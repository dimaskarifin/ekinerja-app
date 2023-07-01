<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\UsersModel;

class KegiatanController extends BaseController
{

    protected $kegiatan;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->kegiatan = new KegiatanModel();
    }

    public function rulesKG()
    {
        $rulesKG = [
            'uraian_kegiatan' => [
                'label' => 'Uraian Kegiatan',
                'rules' => 'required'
            ],
        ];
        return $rulesKG;
    }

    public function index()
    {

        $data = [
            'title' => 'Kelola Kegiatan',
            'kegiatan' => $this->kegiatan->getKegiatans(),
        ];

        return view('kegiatan/index', $data);
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
            return redirect()->to(base_url('kelola-kegiatan'));
        }

        $dataKG = [
            'uraian_kegiatan' => $data['uraian_kegiatan'],
        ];

        $this->kegiatan->insertKegiatan($dataKG);

        session()->setFlashdata("success", "Berhasil menambahkan data");
        return redirect()->to(base_url('kelola-kegiatan'));
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'kegiatan' => $this->kegiatan->getKegiatan($id)
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')
                ->setJSON(array('data' => $encoded_data));
        }
    }
    public function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesKG());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('kelola-kegiatan'));
        }

        $dataKG = [
            'uraian_kegiatan' => $data['uraian_kegiatan'],
        ];

        $this->kegiatan->updateKegiatan($dataKG, $data['id']);

        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->to(base_url('kelola-kegiatan'));
    }

    public function delete($id)
    {
        $this->kegiatan->deleteKegiatan($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('kelola-kegiatan'));
    }
}
