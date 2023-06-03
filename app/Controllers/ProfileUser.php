<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfileUser extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Profile User'
        ];

        return view('profile/index', $data);
    }
}
