<?php

namespace App\Models;

use CodeIgniter\Model;

class EkinerjaModel extends Model
{

    public function __construct()
    {

        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('ekinerja');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table = 'ekinerja';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getDetailKinerja()
    {
        $builder = $this->db->table('ekinerja');
        $builder->select('ekinerja.*, ekinerja.id as id_ekinerja, users.nama, kegiatan.uraian_kegiatan')
            ->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->where('ekinerja.deleted_at', null)
            ->where('nik', session('nik'));

        $query = $builder->get();
        return $query->getResult();
    }

    public function getDetailKinerjaMP()
    {
        $builder = $this->db->table('ekinerja');
        $builder->select('ekinerja.*, ekinerja.id as id_ekinerja, users.nama, kegiatan.uraian_kegiatan')
            ->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->where('ekinerja.deleted_at', null);

        $query = $builder->get();
        return $query->getResult();
    }

    public function editDetailKinerja($id)
    {
        $builder = $this->db->table('ekinerja');
        $builder->select('ekinerja.*, ekinerja.id as id_ekinerja, users.nama, kegiatan.uraian_kegiatan')
            ->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->where('ekinerja.id', $id);

        $query = $builder->get();
        return $query->getResult();
    }

    public function getEkinerjaEachUser($id_users)
    {
        $builder = $this->db->table('ekinerja');
        $builder->select('ekinerja.*, ekinerja.id as id_ekinerja, users.*, kegiatan.uraian_kegiatan')
            ->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->where('id_users', $id_users);

        $query = $builder->get();
        return $query->getResult();
    }

    public function insertEkinerja($data)
    {
        return $this->insert($data);
    }

    public function updateEkinerja($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deleteEkinerja($id)
    {
        return $this->delete($id);
    }

    public function getLaporanMandor(array $params = [])
    {
        $query = $this->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->select('kegiatan.*, users.*, ekinerja.*')
            ->where('ekinerja.deleted_at', null);

        if (!empty($params)) {
            if (!empty($params['nik'])) {
                $query->where('nik', $params['nik']);
            }

            if (!empty($params['tanggal'])) {
                $date_explode = explode('-', $params['tanggal']);
                if ($params['kategori'] == 'month' && count($date_explode) == 2) {
                    $query->where('MONTH(ekinerja.created_at)', $date_explode[1])->where('YEAR(ekinerja.created_at)', $date_explode[0]);
                } else if ($params['kategori'] == 'week') {
                    $query->where("DATE(ekinerja.created_at) BETWEEN '{$params['date_range']['start_date']}' AND '{$params['date_range']['end_date']}'");
                } else {
                    $date_explode = explode('/', $params['tanggal']);
                    if (count($date_explode) == 3) {
                        $date_explode = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
                    } else {
                        $date_explode = $params['tanggal'];
                    }
                    $query->where('DATE(ekinerja.created_at)', $date_explode);
                }
            }
        }

        return $query->find();
    }

    public function getLaporanTukang(array $params = [])
    {
        $query = $this->join('users', 'users.id = ekinerja.id_users')
            ->join('kegiatan', 'kegiatan.id = ekinerja.id_kegiatan')
            ->select('kegiatan.*, users.*, ekinerja.*')
            ->where('ekinerja.deleted_at', null)
            ->where('nik', session('nik'));

        if (!empty($params)) {

            if (!empty($params['tanggal'])) {
                $date_explode = explode('-', $params['tanggal']);
                if ($params['kategori'] == 'month' && count($date_explode) == 2) {
                    $query->where('MONTH(ekinerja.created_at)', $date_explode[1])->where('YEAR(ekinerja.created_at)', $date_explode[0]);
                } else if ($params['kategori'] == 'week') {
                    $query->where("DATE(ekinerja.created_at) BETWEEN '{$params['date_range']['start_date']}' AND '{$params['date_range']['end_date']}'");
                } else {
                    $date_explode = explode('/', $params['tanggal']);
                    if (count($date_explode) == 3) {
                        $date_explode = $date_explode[2] . '-' . $date_explode[1] . '-' . $date_explode[0];
                    } else {
                        $date_explode = $params['tanggal'];
                    }
                    $query->where('DATE(ekinerja.created_at)', $date_explode);
                }
            }
        }

        return $query->find();
    }

    public function getTotalEkinerjaEachUser($tanggal = '')
    {
        $query = $this->join('users', 'ekinerja.id_users = users.id')
            ->select('users.nama, COUNT(ekinerja.id_users) as total_kinerja')
            ->where('ekinerja.deleted_at', null)
            ->groupBy('ekinerja.id_users');

        if (!empty($tanggal)) {
            $explode = explode('-', $tanggal['tanggal']);
            $query->where('MONTH(ekinerja.created_at)', $explode[1]);
            $query->where('YEAR(ekinerja.created_at)', $explode[0]);
        }

        return $query->find();
    }
}
