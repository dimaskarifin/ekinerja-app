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

    public function index()
    {
        $data = [
            'title' => 'Kelola Bidang',
            'bidang' => $this->bidang->getBidangs()
        ];

        return view('mandor/bidang/index', $data);
    }
}
