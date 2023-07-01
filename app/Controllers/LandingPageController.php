<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LandingPageController extends BaseController
{
    public function index()
    {

        $session = \Config\Services::session();

        if ($session->get('logged_in')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('landingpage/index');
    }
}
