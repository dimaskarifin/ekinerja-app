<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class UsersController extends BaseController
{
    protected $users;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Data Users',
            'users' => $this->users->getDetails(),
        ];

        return view('mandor/users/index', $data);
    }

    public function indexPelaksana()
    {
        $data = [
            'title' => 'Kelola Data Tukang',
            'users' => $this->users->getDetailTukang(),
        ];
        return view('pelaksana/tukang/index', $data);
    }

    public function store()
    {
        //mengambil semua request
        $data = $this->request->getPost();
    }

    public function storePelaksana()
    {
        //mengambil semua request
        $data = $this->request->getPost();
    }
}
