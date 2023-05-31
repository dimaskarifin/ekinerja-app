<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;

class BidangController extends BaseController
{
    protected $bidang;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->bidang = new BidangModel();
    }

    public function rulesBD()
    {
        $rulesBD = [
            'nama_bidang' => [
                'label' => 'Nama Bidang',
                'rules' => 'required',
            ]
        ];
        return $rulesBD;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Bidang',
            'bidang' => $this->bidang->getBidangs()
        ];

        return view('mandor/bidang/index', $data);
    }
    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesBD());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-bidang'));
        }

        $bidang = [
            'nama_bidang' => $data['nama_bidang']
        ];

        $this->bidang->insertBidang($bidang);
        session()->setFlashdata("success", "Berhasil menambahkan data");
        return redirect()->to(base_url('mandor/kelola-bidang'));
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'bidang' => $this->bidang->getBidang($id),
            ];
            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    public function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesBD());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-bidang'));
        }

        $bidang = [
            'nama_bidang' => $data['nama_bidang']
        ];
        $this->bidang->updateBidang($bidang, $data['id']);
        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->to(base_url('mandor/kelola-bidang'));
    }

    public function delete($id)
    {
        $this->bidang->deleteBidang($id);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('mandor/kelola-bidang'));
    }
}
