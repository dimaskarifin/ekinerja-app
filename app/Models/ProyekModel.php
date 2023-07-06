<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyekModel extends Model
{

    function __construct()
    {
        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('proyek');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }


    protected $table            = 'proyek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getDetailProyekPelaksana()
    {
        $builder = $this->db->table('proyek');
        $builder->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.uraian_kegiatan')
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->where('proyek.deleted_at', null)
            ->where('p.nik', session()->get('nik'));

        $query = $builder->get();
        return $query->getResult();
    }

    function getDetailProyekMandor()
    {
        $builder = $this->db->table('proyek');
        $builder->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.uraian_kegiatan')
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->where('proyek.deleted_at', null)
            ->where('m.nik', session()->get('nik'));

        $query = $builder->get();
        return $query->getResult();
    }

    function getDetailProyekTukang()
    {
        $builder = $this->db->table('proyek');
        $builder->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.uraian_kegiatan')
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->where('proyek.deleted_at', null)
            ->where('t.nik', session()->get('nik'));

        $query = $builder->get();
        return $query->getResult();
    }

    function editDetailProyek($id)
    {
        $builder = $this->db->table('proyek');
        $builder->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.uraian_kegiatan')
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->where('proyek.id', $id);

        $query = $builder->get();
        return $query->getResult();
    }

    public function getLaporan(array $params = [], $idPelaksana = null)
    {
        $query = $this
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, m.nik as nik_mandor, p.nama as nama_pelaksana, 
            p.nik as nik_pelaksana, t.nama as nama_tukang, t.nik as nik_tukang ,kegiatan.uraian_kegiatan')
            ->where('proyek.deleted_at', null);

        if (!empty($params)) {
            if (!empty($params['nik'])) {
                $query->where('t.nik', $params['nik']);
            }

            if (!empty($params['tanggal'])) {
                $date_explode = explode('-', $params['tanggal']);
                if ($params['kategori'] == 'month' && count($date_explode) == 2) {
                    $query->where('MONTH(proyek.created_at)', $date_explode[1])->where('YEAR(proyek.created_at)', $date_explode[0]);
                } else if ($params['kategori'] == 'week') {
                    $query->where("DATE(proyek.created_at) BETWEEN '{$params['date_range']['start_date']}' AND '{$params['date_range']['end_date']}'");
                } else {
                    $date_explode = explode('/', $params['tanggal']);
                    if (count($date_explode) == 3) {
                        $date_explode = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
                    } else {
                        $date_explode = $params['tanggal'];
                    }
                    $query->where('DATE(proyek.created_at)', $date_explode);
                }
            }
        }

        if (!empty($idPelaksana)) {
            // $query->where('proyek.pelaksana_id', $idPelaksana);
        }

        return $query->find();
    }

    public function getLaporanTukang(array $params = [])
    {
        $query = $this
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.uraian_kegiatan')
            ->where('proyek.deleted_at', null)
            ->where('t.nik', session('nik'));

        if (!empty($params)) {
            if (!empty($params['nik'])) {
                $query->where('t.nik', $params['nik']);
            }

            if (!empty($params['tanggal'])) {
                $date_explode = explode('-', $params['tanggal']);
                if ($params['kategori'] == 'month' && count($date_explode) == 2) {
                    $query->where('MONTH(proyek.created_at)', $date_explode[1])->where('YEAR(proyek.created_at)', $date_explode[0]);
                } else if ($params['kategori'] == 'week') {
                    $query->where("DATE(proyek.created_at) BETWEEN '{$params['date_range']['start_date']}' AND '{$params['date_range']['end_date']}'");
                } else {
                    $date_explode = explode('/', $params['tanggal']);
                    if (count($date_explode) == 3) {
                        $date_explode = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
                    } else {
                        $date_explode = $params['tanggal'];
                    }
                    $query->where('DATE(proyek.created_at)', $date_explode);
                }
            }
        }

        return $query->find();
    }

    function getProyek($id)
    {
        return $this->where(['id' => $id])->first();
    }

    function insertProyek($data)
    {
        return $this->insert($data);
    }

    function updateProyek($data, $id)
    {
        return $this->update($id, $data);
    }


    function deleteProyek($id)
    {
        return $this->delete($id);
    }

    function getTotalProyekTukangUser($tanggal = '')
    {
        $query = $this
            ->join('users as t', 't.id = proyek.tukang_id', 'left')
            ->select('t.nama, COUNT(proyek.tukang_id) as total_proyek')
            ->where('proyek.deleted_at', null)
            ->groupBy('proyek.tukang_id');

        if (!empty($tanggal)) {
            $explode = explode('-', $tanggal['tanggal']);
            $query->where('MONTH(proyek.created_at)', $explode[1]);
            $query->where('YEAR(proyek.created_at)', $explode[0]);
        }

        return $query->find();
    }
}
