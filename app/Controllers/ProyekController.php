<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KegiatanModel;
use App\Models\TimelineKegiatanModel;
use App\Models\ProyekModel;
use App\Models\UsersModel;

class ProyekController extends BaseController
{
    protected $users;
    protected $kegiatan;
    protected $timelineKegiatan;
    protected $proyek;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->users = new UsersModel();
        $this->kegiatan = new KegiatanModel();
        $this->timelineKegiatan = new TimelineKegiatanModel();
        $this->proyek = new ProyekModel();
    }

    private function date_indo($date, $delimiter)
    {
        $array_month = [
            '01' => 'januari',
            '02' => 'februari',
            '03' => 'maret',
            '04' => 'april',
            '05' => 'mei',
            '06' => 'juni',
            '07' => 'juli',
            '08' => 'agustus',
            '09' => 'september',
            '10' => 'oktober',
            '11' => 'november',
            '12' => 'december'
        ];
        $explode_date = explode($delimiter, $date);
        $date_return = $explode_date[2] . ' ' . ucfirst($array_month[$explode_date[1]]) . ' ' . $explode_date[0];
        return $date_return;
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
            'tukang' => $this->users->where('role', 'tukang')->findAll(),
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

            $dataProyek = $this->proyek->editDetailProyek($id);
            $dataTimelineKegiatan = $this->timelineKegiatan->getTimelineKegiatanByKegiatanId($dataProyek[0]->kegiatan_id);

            $listTimelineKegiatan = [];
            $no = 0;
            foreach ($dataTimelineKegiatan as $item) {
                $no++;
                array_push($listTimelineKegiatan, "{$no}. Pada tanggal {$this->date_indo($item->tanggal_kegiatan, '-')}, Kegiatan {$item->detail_kegiatan}.<br>");
            }

            $data = [
                'proyek' => $dataProyek,
                'timelineKegiatan' => implode('', str_replace('<br>', "\n", $listTimelineKegiatan))
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
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
        }

        $dataProyek = $this->proyek->editDetailProyek($id);
        $dataTimelineKegiatan = $this->timelineKegiatan->getTimelineKegiatanByKegiatanId($dataProyek[0]->kegiatan_id);

        $listTimelineKegiatan = [];
        $no = 0;
        foreach ($dataTimelineKegiatan as $item) {
            $no++;
            array_push($listTimelineKegiatan, "{$no}. Pada tanggal {$this->date_indo($item->tanggal_kegiatan, '-')}, Kegiatan {$item->detail_kegiatan}.<br>");
        }

        $data = [
            'proyek' => $dataProyek,
            'timelineKegiatan' => implode('', str_replace('<br>', "\n", $listTimelineKegiatan))
        ];

        $encoded_data = base64_encode(json_encode($data));
        return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
    }

    function updateMandor()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'tukang_id' => [
                    'label' => 'Nama Tukang',
                    'rules' => 'required',
                ]
            ]
        );

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('mandor/kelola-proyek'));
        }

        $dataTK = [
            'tukang_id' => $data['tukang_id']
        ];

        $this->proyek->updateProyek($dataTK, $data['id']);

        session()->setFlashdata("success", "Berhasil memperbarui data proyek");
        return redirect()->to(base_url('mandor/kelola-proyek'));
    }

    function editTukang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
        }

        $dataProyek = $this->proyek->editDetailProyek($id);
        $dataTimelineKegiatan = $this->timelineKegiatan->getTimelineKegiatanByKegiatanId($dataProyek[0]->kegiatan_id);

        $listTimelineKegiatan = [];
        $no = 0;
        foreach ($dataTimelineKegiatan as $item) {
            $no++;
            array_push($listTimelineKegiatan, "{$no}. Pada tanggal {$this->date_indo($item->tanggal_kegiatan, '-')}, Kegiatan {$item->detail_kegiatan}.<br>");
        }

        $data = [
            'proyek' => $dataProyek,
            'timelineKegiatan' => implode('', str_replace('<br>', "\n", $listTimelineKegiatan))
        ];

        $encoded_data = base64_encode(json_encode($data));
        return $this->response->setContentType('application/json')->setJSON(array('data' => $encoded_data));
    }

    function updateTukang()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'output' => [
                    'label' => 'Output Proyek',
                    'rules' => 'required',
                ]
            ]
        );

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('tukang/kelola-proyek'));
        }

        $dataOT = [
            'output' => $data['output']
        ];

        $this->proyek->updateProyek($dataOT, $data['id']);

        session()->setFlashdata("success", "Berhasil memperbarui data proyek");
        return redirect()->to(base_url('tukang/kelola-proyek'));
    }
}
