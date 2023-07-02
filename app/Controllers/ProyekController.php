<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\ProyekModel;
use App\Models\UsersModel;

class ProyekController extends BaseController
{

    protected $users;
    protected $kegiatan;
    protected $proyek;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
        $this->kegiatan = new KegiatanModel();
        $this->proyek = new ProyekModel();
    }

    function rulesProyekPelaksana()
    {
        $rules = [
            'no_proyek' => [
                'label' => 'No. Proyek',
                'rules' => 'required|is_unique[proyek.no_proyek]',
                'errors' => [
                    'is_unique' => '{field} No. Proyek sudah digunakan',
                ],
            ],
            'nama_proyek' => [
                'label' => 'Nama Proyek',
                'rules' => 'required',
            ],
            'pelaksana_id' => [
                'label' => 'Nama Pelaksana',
                'rules' => 'required',
            ],
            'mandor_id' => [
                'label' => 'Nama Mandor',
                'rules' => 'required',
            ],
            'kegiatan_id' => [
                'label' => 'Kegiatan',
                'rules' => 'required',
            ],
            'target' => [
                'label' => 'Target',
                'rules' => 'required',
            ],
            'satuan' => [
                'label' => 'satuan',
                'rules' => 'required',
            ],
            'tanggal_pelaksanaan' => [
                'label' => 'Tanggal Pelaksanaan',
                'rules' => 'required',
            ],
            'tanggal_selesai_pelaksanaan' => [
                'label' => 'Tanggal Selesai Pelaksanaan',
                'rules' => 'required'
            ]
        ];

        return $rules;
    }


    function indexPelaksana()
    {
        $data = [
            'title' => 'Kelola Proyek',
            'mandor' => $this->users->where('role', 'mandor')->findAll(),
            'pelaksana' => $this->users->where('role', 'pelaksana')->findAll(),
            'tukang' => $this->users->where('role', 'tukang')->findAll(),
            'kegiatan' => $this->kegiatan->getKegiatans(),
            'proyek' => $this->proyek->getDetailProyekPelaksana(),
        ];

        // dd($data['proyek']);

        return view('pelaksana/proyek/index', $data);
    }

    function indexMandor()
    {
        $data = [
            'title'  => 'Kelola Proyek',
            'mandor' => $this->users->where('role', 'mandor')->findAll(),
            'pelaksana' => $this->users->where('role', 'pelaksana')->findAll(),
            'kegiatan' => $this->kegiatan->getKegiatans(),
            'tukang' => $this->users->where('role', 'tukang')->findAll(),
            'proyek' => $this->proyek->getDetailProyekMandor()
        ];

        return view('mandor/proyek/index', $data);
    }
    function indexTukang()
    {
        $data = [
            'title' => 'Kelola Proyek',
            'mandor' => $this->users->where('role', 'mandor')->findAll(),
            'pelaksana' => $this->users->where('role', 'pelaksana')->findAll(),
            'kegiatan' => $this->kegiatan->getKegiatans(),
            'proyek' => $this->proyek->getDetailProyekTukang(),
        ];

        return view('tukang/proyek/index', $data);
    }

    function storePelaksana()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rulesProyekPelaksana());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pelaksana/kelola-proyek'));
        }

        $dataPL = [
            'no_proyek' => $data['no_proyek'],
            'nama_proyek' => $data['nama_proyek'],
            'pelaksana_id' => $data['pelaksana_id'],
            'mandor_id' => $data['mandor_id'],
            'kegiatan_id' => $data['kegiatan_id'],
            'target' => $data['target'],
            'satuan' => $data['satuan'],
            'tanggal_pelaksanaan' => $data['tanggal_pelaksanaan'],
            'tanggal_selesai_pelaksanaan' => $data['tanggal_selesai_pelaksanaan'],
        ];

        $this->proyek->insertProyek($dataPL);

        session()->setFlashdata("success", "Berhasil menambahkan data proyek");
        return redirect()->to(base_url('pelaksana/kelola-proyek'));
    }

    function editPelaksana()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'proyek' => $this->proyek->editDetailProyekPelaksana($id)
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
        }
    }

    function updatePelaksana()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();


        $arrRules = $this->rulesProyekPelaksana();
        //check no. proyek baru atau lama
        $get_data_proyek = $this->proyek->getProyek($data['id']);
        // dd($get_data_proyek);
        if ($get_data_proyek['no_proyek'] === $data['no_proyek']) {
            unset($arrRules['no_proyek']);
        }


        $validation->setRules($arrRules);
        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('pelaksana/kelola-proyek'));
        }

        $dataPL = [
            'no_proyek' => $data['no_proyek'],
            'nama_proyek' => $data['nama_proyek'],
            'pelaksana_id' => $data['pelaksana_id'],
            'mandor_id' => $data['mandor_id'],
            'kegiatan_id' => $data['kegiatan_id'],
            'target' => $data['target'],
            'satuan' => $data['satuan'],
            'tanggal_pelaksanaan' => $data['tanggal_pelaksanaan'],
            'tanggal_selesai_pelaksanaan' => $data['tanggal_selesai_pelaksanaan'],
        ];

        // dd($dataPL);

        $this->proyek->updateProyek($dataPL, $data['id']);


        session()->setFlashdata("success", "Berhasil memperbarui data proyek");
        return redirect()->to(base_url('pelaksana/kelola-proyek'));
    }

    function deletePelaksana($id)
    {
        $this->proyek->deleteProyek($id);

        session()->setFlashdata("success", "data proyek berhasil di hapus");
        return redirect()->to(base_url('pelaksana/kelola-proyek'));
    }

    function editMandor()
    {
    }

    function updateMandor()
    {
    }

    function editTukang()
    {
    }

    function updateTukang()
    {
    }
}
