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

    protected $DBGroup = 'default';
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
            ->where('ekinerja.deleted_at', null);

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

    public function getLaporan(array $params = [])
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
                if ($params['kategori'] == 'month' || count($date_explode) == 2) {
                    $query->where('MONTH(ekinerja.created_at)', $date_explode[1])->where('YEAR(ekinerja.created_at)', $date_explode[0]);
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
}