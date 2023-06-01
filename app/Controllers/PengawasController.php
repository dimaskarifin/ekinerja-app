<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengawasModel;

class PengawasController extends BaseController
{

    protected $pengawas;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->pengawas = new PengawasModel();
    }

    public function RulesPs()
    {
        $rules = [
            'nama_pengawas' => [
                'label' => 'Nama Pengawas',
                'rules' => 'required'
            ]
        ];
        return $rules;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Pengawas',
            'pengawas' => $this->pengawas->getAllPengawas()
        ];

        return view('mandor/pengawas/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->RulesPs());
        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-pengawas'));
        }

        $pengawas = [
            'nama_pengawas' => $data['nama_pengawas']
        ];

        $this->pengawas->insertPengawas($pengawas);

        session()->setFlashdata("success", "Data berhasil ditambahkan");
        return redirect()->to(base_url('mandor/kelola-pengawas'));
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'pengawas' => $this->pengawas->getPengawas($id),
            ];

            $encoded_data = base64_encode(json_encode($data));

            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    public function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->RulesPs());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-pengawas'));
        }

        $pengawas = [
            'nama_pengawas' => $data['nama_pengawas']
        ];

        $this->pengawas->updatePengawas($pengawas, $data['id']);

        session()->setFlashdata('success', 'Berhasil memperbarui data pengawas');
        return redirect()->to(base_url('mandor/kelola-pengawas'));
    }

    public function delete($id)
    {
        $this->pengawas->deletePengawas($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('mandor/kelola-pengawas'));
    }
}
