<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BidangModel;
use App\Models\JabatanModel;
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
            'tempat_lahir' => [
                'label' => 'Tempat lahir',
                'rules' => 'required'
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal lahir',
                'rules' => 'required'
            ],
            'alamat' => [
                'label' => 'Alamat',
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
            'title' => 'Kelola Data Pengguna',
            'users' => $this->users->getDetails(),

            'jabatan' => $this->jabatan->getJabatans(),
            'bidang' => $this->bidang->getBidangs()
        ];

        // dd($data['users']);

        return view('admin/pengguna/index', $data);
    }

    // public function indexPelaksana()
    // {
    //     $data = [
    //         'title' => 'Kelola Data Tukang',
    //         'users' => $this->users->getDetailTukang(),
    //         'pengawas' => $this->pengawas->getAllPengawas(),
    //         'jabatan' => $this->jabatan->getJabatans(),
    //         'bidang' => $this->bidang->getBidangs()
    //     ];
    //     return view('pelaksana/tukang/index', $data);
    // }

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
            return redirect()->to(base_url('admin/kelola-pengguna'));
        }
        $file = $this->request->getFile('foto');
        $nameFile = $data['nik'] . '.' . $file->getClientExtension();
        $file->move(FCPATH . 'assets/uploads', $nameFile);

        $dataUsers = [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'alamat' => $data['alamat'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'],
            'foto' => $nameFile,
            'jabatan_id' => $data['jabatan_id'],
            'bidang_id' => $data['bidang_id']
        ];

        $this->users->insertUser($dataUsers);

        session()->setFlashdata("success", "Berhasil menambahkan data!");
        return redirect()->to(base_url('admin/kelola-pengguna'));
    }

    public function edit()
    {
        $id = $this->request->getVar('id');

        if ($this->request->isAJAX()) {

            $data = [
                'users' => $this->users->getDetailEdit($id),
            ];

            $encoded_data = base64_encode(json_encode($data));

            return $this->response->setContentType('application/json')
                ->setJSON(array('data' => $encoded_data));
        }
    }

    public function update()
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
        // dd($get_data_user);
        if ($get_data_user['nik'] === $data['nik']) {
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
            return redirect()->to(base_url('admin/kelola-pengguna'));
        }

        //data insert
        $dataUser = [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'alamat' => $data['alamat'],
            'role' => $data['role'],
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
        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->to(base_url('admin/kelola-pengguna'));
    }

    // public function storePelaksana()
    // {
    //     //mengambil semua request
    //     $data = $this->request->getPost();

    //     $validation = \Config\Services::validation();
    //     $validation->setRules($this->RulesUsers());
    //     if (!$validation->run($_POST)) {
    //         $errors = $validation->getErrors();
    //         $arr = implode("<br>", $errors);
    //         session()->setFlashdata("warning", $arr);
    //         return redirect()->to(base_url('pelaksana/kelola-tukang'));
    //     }
    //     $file = $this->request->getFile('foto');
    //     $nameFile = $data['nik'] . '.' . $file->getClientExtension();
    //     $file->move(FCPATH . 'assets/uploads', $nameFile);

    //     $dataUsers = [
    //         'nik' => $data['nik'],
    //         'nama' => $data['nama'],
    //         'password' => password_hash($data['password'], PASSWORD_DEFAULT),
    //         'role' => $data['role'],
    //         'foto' => $nameFile,
    //         'pengawas_id' => $data['pengawas_id'],
    //         'jabatan_id' => $data['jabatan_id'],
    //         'bidang_id' => $data['bidang_id']
    //     ];

    //     $this->users->insertUser($dataUsers);

    //     session()->setFlashdata("success", "Berhasil menambahkan data!");
    //     return redirect()->to(base_url('pelaksana/kelola-tukang'));
    // }

    // public function updatePelaksana()
    // {
    //     $data = $this->request->getPost();
    //     // dd($data);

    //     $validation = \Config\Services::validation();
    //     //define file
    //     $file = $this->request->getFile('foto');
    //     $arrRules = $this->RulesUsers();

    //     //jika file valid
    //     if (!$file->isValid()) {
    //         unset($arrRules['foto']);
    //     }


    //     // Check NIK baru== NIK LAMA
    //     $get_data_user = $this->users->getUser($data['id']);
    //     if ($get_data_user['nik'] === $data['nik']) {
    //         unset($arrRules['nik']);
    //     }

    //     // Check PASSWORD Kosong atau tidak, kalo kosong hapus rules
    //     if (empty($data['password'])) {
    //         unset($arrRules['password']);
    //     }

    //     $validation->setRules($arrRules);
    //     if (!$validation->run($_POST)) {
    //         $errors = $validation->getErrors();
    //         $arr = implode("<br>", $errors);
    //         session()->setFlashdata("warning", $arr);
    //         return redirect()->to(base_url('pelaksana/kelola-tukang'));
    //     }

    //     //data insert
    //     $dataUser = [
    //         'nik' => $data['nik'],
    //         'nama' => $data['nama'],
    //         'role' => $data['role'],
    //         'pengawas_id' => $data['pengawas_id'],
    //         'jabatan_id' => $data['jabatan_id'],
    //         'bidang_id' => $data['bidang_id']
    //     ];

    //     // Jika password tidak kosong maka update password
    //     if (!empty($data['password'])) {
    //         $dataUser['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    //     }

    //     //condition jika file valid maka jalankan
    //     if ($file->isValid() && !$file->hasMoved()) {
    //         $nameFile = $data['nik'] . '.' . $file->getClientExtension();
    //         $file->move(FCPATH . 'assets/uploads', $nameFile);

    //         $dataUser['foto'] = $nameFile;
    //     }

    //     $this->users->updateUser($dataUser, $data['id']);
    //     session()->setFlashdata('success', 'Berhasil memperbarui data tukang');
    //     return redirect()->to(base_url('pelaksana/kelola-tukang'));
    // }

    // public function deletePelaksana($id)
    // {
    //     // dd($id);
    //     $this->users->deleteUser($id);
    //     session()->setFlashdata("success", "Data berhasil dihapus");
    //     return redirect()->to(base_url('pelaksana/kelola-tukang'));
    // }

    public function delete($id)
    {
        // dd($id);
        $this->users->deleteUser($id);
        session()->setFlashdata("success", "Data berhasil dihapus");
        return redirect()->to(base_url('admin/kelola-pengguna'));
    }
}
