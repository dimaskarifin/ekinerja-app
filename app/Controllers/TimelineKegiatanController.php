<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TimelineKegiatanModel;
use App\Models\KegiatanModel;

class TimelineKegiatanController extends BaseController
{
    protected $timelineKegiatan;
    protected $kegiatan;

    public function __construct()
    {
        helper(['form', 'url', 'validation', 'session', 'text']);
        $this->timelineKegiatan = new TimelineKegiatanModel();
        $this->kegiatan = new KegiatanModel();
    }

    public function rules()
    {
        $rules = [
            'kegiatan_id' => [
                'label' => 'Kegiatan',
                'rules' => 'required'
            ],
            'detail_kegiatan' => [
                'label' => 'Detail Kegiatan',
                'rules' => 'required'
            ],
            'tanggal_kegiatan' => [
                'label' => 'Detail Tanggal Kegiatan',
                'rules' => 'required'
            ],
        ];

        return $rules;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Timeline Kegiatan',
            'timelineKegiatan' => $this->timelineKegiatan->getTimelineKegiatans(),
            'kegiatan' => $this->kegiatan->getKegiatanByUser()
        ];

        return view('timeline/index', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rules());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('tukang/kelola-timeline-kegiatan'));
        }

        $array_data = [
            'kegiatan_id' => $data['kegiatan_id'],
            'detail_kegiatan' => $data['detail_kegiatan'],
            'tanggal_kegiatan' => $data['tanggal_kegiatan'],
        ];

        $this->timelineKegiatan->insertTimelineKegiatan($array_data);

        session()->setFlashdata("success", "Berhasil menambahkan data");
        return redirect()->to(base_url('tukang/kelola-timeline-kegiatan'));
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'timelineKegiatan' => $this->timelineKegiatan->getTimelineKegiatan($id)
            ];

            $encoded_data = base64_encode(json_encode($data));
            return $this->response->setContentType('application/json')
                ->setJSON(array('data' => $encoded_data));
        }
    }
    public function update()
    {
        $data = $this->request->getPost();

        $validation = \Config\Services::validation();
        $validation->setRules($this->rules());

        if (!$validation->run($_POST)) {
            $errors = $validation->getErrors();
            $arr = implode("<br>", $errors);
            session()->setFlashdata("warning", $arr);
            return redirect()->to(base_url('tukang/kelola-timeline-kegiatan'));
        }

        $array_data = [
            'kegiatan_id' => $data['kegiatan_id'],
            'detail_kegiatan' => $data['detail_kegiatan'],
            'tanggal_kegiatan' => $data['tanggal_kegiatan'],
        ];
        
        $this->timelineKegiatan->updateTimelineKegiatan($array_data, $data['id']);

        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->to(base_url('tukang/kelola-timeline-kegiatan'));
    }

    public function delete($id)
    {
        $this->timelineKegiatan->deleteTimelineKegiatan($id);

        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to(base_url('tukang/kelola-timeline-kegiatan'));
    }
}
