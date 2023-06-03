<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class ProfileUser extends BaseController
{
    protected $user;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);

        $this->user = new UsersModel;
    }
    public function index()
    {
        $data = [
            'title' => 'Profile User',
            'user' => $this->user->where('nik', session('nik'))->first(),
        ];

        return view('profile/index', $data);
    }

    private function setRules($kategori = 'data')
    {
        if ($kategori == 'password') {
            $rules = [
                'new_password' => [
                    'label' => "Password",
                    'rules' => ['required', 'min_length[8]']
                ],
                'confirm_password' => [
                    'label' => "Konfirmasi Password",
                    'rules' => ['required_with[new_password]', 'matches[new_password]', 'min_length[8]']
                ]
            ];
        } else {
            $rules = [
                'nik' => [
                    'label' => 'NIK',
                    'rules' => 'required'
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required'
                ]
            ];
        }

        return $rules;
    }

    public function update($id)
    {
        $input = $this->request->getPost();

        $validation = \Config\Services::validation();
        
        if (isset($input['new_password'])) {
            $validation->setRules($this->setRules('password'));
            
            if (!$validation->run($_POST)) {
                $errors = $validation->getErrors();
                $arr = implode("<br>", $errors);
                session()->setFlashdata("warning", $arr);
                return redirect()->to(base_url('profile-user'));
            }
            
            $this->user->updateUser([
                'password' => password_hash($input['new_password'], PASSWORD_DEFAULT),
            ], $id);
        } else {
            $validation->setRules($this->setRules());

            if (!$validation->run($_POST)) {
                $errors = $validation->getErrors();
                $arr = implode("<br>", $errors);
                session()->setFlashdata("warning", $arr);
                return redirect()->to(base_url('profile-user'));
            }
    
            $this->user->updateUser([
                'nik' => $input['nik'],
                'nama' => $input['nama'],
            ], $id);
        }

        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->to(base_url('profile-user'));
    }
}