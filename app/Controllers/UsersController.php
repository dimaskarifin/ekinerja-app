<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\JabatanModel;
use App\Models\PengawasModel;
use App\Models\UsersModel;

class UsersController extends BaseController
{
    protected $users;
    protected $pengawas;
    protected $jabatan;
    protected $bidang;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
        $this->pengawas = new PengawasModel();
        $this->jabatan = new JabatanModel();
        $this->bidang = new BidangModel();
    }

    public function RulesUsers()
    {
        $rulesUsers = [
            'nik' => [
                'label' => 'NIK',
                'rules' => 'required|is_unique[users.nik]',
                'errors' => [
                    'is_unique' => '{field} Sudah di pakai oleh user lain',
                ],
            ],
            'nama' => [
                'label' => 'Nama',
                'rules' => 'required'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required'
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required'
            ],
            'foto' => [
                'label' => 'Foto',
                'rules' => 'uploaded[foto]|max_size[foto,5120]|ext_in[foto,jpg,jpeg,png]'
            ],
            'pengawas_id' => [
                'label' => 'Nama Pengawas',
                'rules' => 'required'
            ],
            'jabatan_id' => [
                'label' => 'Nama Jabatan',
                'rules' => 'required'
            ],
            'bidang_id' => [
                'label' => 'Nama Bidang',
                'rules' => 'required'
            ],

        ];
        return $rulesUsers;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Users',
            'users' => $this->users->getDetails(),
            'pengawas' => $this->pengawas->getAllPengawas(),
            'jabatan' => $this->jabatan->getJabatans(),
            'bidang' => $this->bidang->getBidangs()
        ];

        dd($data['users']);

        return view('mandor/users/index', $data);
    }

    public function indexPelaksana()
    {
        $data = [
            'title' => 'Kelola Data Tukang',
            'users' => $this->users->getDetailTukang(),
            'pengawas' => $this->pengawas->getAllPengawas(),
            'jabatan' => $this->jabatan->getJabatans(),
            'bidang' => $this->bidang->getBidangs()
        ];
        return view('pelaksana/tukang/index', $data);
    }

    public function store()
    {
        //mengambil semua request
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->RulesUsers());
        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-users'));
        }
        $file = $this->request->getFile('foto');
        $nameFile = $data['nik'] . '.' . $file->getClientExtension();
        $file->move(FCPATH . 'assets/uploads', $nameFile);

        $dataUsers = [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'],
            'foto' => $nameFile,
            'pengawas_id' => $data['pengawas_id'],
            'jabatan_id' => $data['jabatan_id'],
            'bidang_id' => $data['bidang_id']
        ];

        $this->users->insertUser($dataUsers);

        session()->setFlashdata("success", "Berhasil menambahkan data!");
        return redirect()->to(base_url('mandor/kelola-users'));
    }

    public function storePelaksana()
    {
        //mengambil semua request
        $data = $this->request->getPost();
    }

    public function editMandor()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'users' => $this->users->getDetailEdit($id),
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')
                ->setJSON(array('data' => $encoded_data));
        }
    }

    public function updateMandor()
    {
        $data = $this->request->getPost();
        // dd($data);

        $validation = \Config\Services::validation();
        //define file
        $file = $this->request->getFile('foto');
        $arrRules = $this->RulesUsers();

        //jika file valid
        if (!$file->isValid()) {
            unset($arrRules['foto']);
        }

        // Check NIK baru== NIK LAMA
        $get_data_user = $this->users->getUser($data['id']);
        if ($get_data_user['nik'] == $data['nik']) {
            unset($arrRules['nik']);
        }

        // Check PASSWORD Kosong atau tidak, kalo kosong hapus rules
        if (empty($data['password'])) {
            unset($arrRules['password']);
        }

        $validation->setRules($arrRules);
        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-users'));
        }

        //data insert
        $dataUser = [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'role' => $data['role'],
            'pengawas_id' => $data['pengawas_id'],
            'jabatan_id' => $data['jabatan_id'],
            'bidang_id' => $data['bidang_id']
        ];

        // Jika password tidak kosong maka update password
        if (!empty($data['password'])) {
            $dataUser['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        //condition jika file valid maka jalankan
        if ($file->isValid() && !$file->hasMoved()) {
            $nameFile = $data['nik'] . '.' . $file->getClientExtension();
            $file->move(FCPATH . 'assets/uploads', $nameFile);

            $dataUser['foto'] = $nameFile;
        }

        $this->users->updateUser($dataUser, $data['id']);
        return redirect()->to(base_url('mandor/kelola-users'));
    }

    public function editPelaksana()
    {
    }

    public function delete($id)
    {
        // dd($id);
        $this->users->deleteUser($id);
        session()->setFlashdata("success", "Data berhasil dihapus");
        return redirect()->to(base_url('mandor/kelola-users'));
    }
}
