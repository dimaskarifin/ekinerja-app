<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class AuthController extends BaseController
{
    protected $users;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
    }

    public function index()
    {
        $session = \Config\Services::session();

        if ($session->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login');
    }

    public function postLogin()
    {
        $data = $this->request->getPost();

        //ambil data users dari database berdasarkan nik
        $users = $this->users->where('nik', $data['nik'])->first();

        //cek nik apakah sesuai dengan database atau belum
        if ($users) {
            //cek password, jika salah kembalikan dengan error di halaman login
            if (!password_verify($data['password'], $users['password'])) {
                return redirect()->to(base_url('signin'))->with('error', 'Invalid username or password');
            }
            //jika sesuai, arahkan user masuk ke admin dashboard

            $session = session();
            $session->set('logged_in', true);
            $session->set('id', $users['id']);
            $session->set('nik', $users['nik']);
            $session->set('nama', $users['nama']);
            $session->set('role', $users['role']);


            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->to(base_url('/'))->with('error', 'Invalid nik or password');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to(base_url('signin'));
    }

    public function errors()
    {
        return view('errors');
    }
}
