<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelaksanaModel;

class PelaksanaController extends BaseController
{

    protected $pelaksana;

    function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->pelaksana = new PelaksanaModel();
    }

    function RulesPL()
    {
        $rulesPL = [
            'nama_pelaksana' => [
                'label' => 'Nama Pelaksana',
                'rules'  => 'required'
            ],
        ];

        return $rulesPL;
    }

    function index()
    {
        $data = [
            'title' => 'Kelola Pelaksana',
            'pelaksana' => $this->pelaksana->getAllPelaksana(),
        ];

        return view('admin/pelaksana/index', $data);
    }

    function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->RulesPL());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/kelola-pelaksana'));
        }

        $pelaksana = [
            'nama_pelaksana' => $data['nama_pelaksana'],
        ];

        $this->pelaksana->insertPelaksana($pelaksana);

        session()->setFlashdata("success", "Data berhasil ditambahkan");
        return redirect()->to(base_url('admin/kelola-pelaksana'));
    }

    function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'pelaksana' => $this->pelaksana->getPelaksana($id),
            ];

            $encoded_data = base64_encode(json_encode($data));

            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->RulesPL());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('admin/kelola-pelaksana'));
        }

        $pelaksana = [
            'nama_pelaksana' => $data['nama_pelaksana']
        ];

        $this->pelaksana->updatePelaksana($pelaksana, $data['id']);

        session()->setFlashdata("success", "Berhasil memperbarui data");
        return redirect()->to(base_url('admin/kelola-pelaksana'));
    }

    function delete($id)
    {
        $this->pelaksana->deletePelaksana($id);

        session()->setFlashdata("success", "Data berhasil dihapus");
        return redirect()->to(base_url('admin/kelola-pelaksana'));
    }
}
