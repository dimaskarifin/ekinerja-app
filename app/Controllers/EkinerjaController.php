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

    public function indexMandor()
    {
        $data = [
            'title' => 'Kelola E-Kinerja',
            'ekinerja' => $this->ekinerja->getDetailKinerja(),
            'users'    => $this->users->getUsers(),
            'kegiatan' => $this->kegiatan->getKegiatansAll(),
        ];

        return view('mandor/kinerja/index', $data);
    }

    public function indexPelaksana()
    {
        $data = [
            'title' => 'Kelola E-Kinerja',
            'ekinerja' => $this->ekinerja->getDetailKinerja(),
            'users'    => $this->users->getUsers(),
            'kegiatan' => $this->kegiatan->getKegiatansAll(),
        ];

        return view('pelaksana/kinerja/index', $data);
    }

    public function indexTukang()
    {
        $data = [
            'title' => 'Kelola E-Kinerja',
            'ekinerja' => $this->ekinerja->getDetailKinerja(),
            'users'    => $this->users->getUsers(),
            'kegiatan' => $this->kegiatan->getKegiatansAll(),
        ];

        return view('tukang/kinerja/index', $data);
    }


    public function storeMandor()
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
    public function storePelaksana()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesEK());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pelaksana/kelola-ekinerja'));
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
        return redirect()->to(base_url('pelaksana/kelola-ekinerja'));
    }

    public function storeTukang()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesEK());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('tukang/kelola-ekinerja'));
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
        return redirect()->to(base_url('tukang/kelola-ekinerja'));
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'kinerja' => $this->ekinerja->editDetailKinerja($id),
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    public function editTukang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'kinerja' => $this->ekinerja->editDetailKinerja($id),
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    public function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesEK());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('kelola-ekinerja'));
        }

        $dataEK = [
            'id_users' => $data['id_users'],
            'id_kegiatan' => $data['id_kegiatan'],
            'output' => $data['output'],
            'waktu_mulai' => $data['tanggal_mulai'],
            'waktu_selesai' => $data['tanggal_selesai']
        ];

        $this->ekinerja->updateEkinerja($dataEK, $data['id']);
        session()->setFlashdata("success", "Berhasil memperbarui data");
        return redirect()->to(base_url('kelola-ekinerja'));
    }

    public function updateTukang()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesEK());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('tukang/kelola-ekinerja'));
        }

        $dataEK = [
            'id_users' => $data['id_users'],
            'id_kegiatan' => $data['id_kegiatan'],
            'output' => $data['output'],
            'waktu_mulai' => $data['tanggal_mulai'],
            'waktu_selesai' => $data['tanggal_selesai']
        ];

        $this->ekinerja->updateEkinerja($dataEK, $data['id']);
        session()->setFlashdata("success", "Berhasil memperbarui data");
        return redirect()->to(base_url('tukang/kelola-ekinerja'));
    }

    public function delete($id)
    {
        $this->ekinerja->deleteEkinerja($id);

        session()->setFlashdata("success", "Berhasil menghapus data");
        return redirect()->to(base_url('kelola-ekinerja'));
    }

    public function deleteTukang($id)
    {
        $this->ekinerja->deleteEkinerja($id);

        session()->setFlashdata("success", "Berhasil menghapus data");
        return redirect()->to(base_url('tukang/kelola-ekinerja'));
    }
}
