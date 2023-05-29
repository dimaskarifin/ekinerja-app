<?php

namespace App\Models;

use CodeIgniter\Model;

class PengawasModel extends Model
{

    public function __construct()
    {

        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('pengawas');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'pengawas';
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

    public function getPengawas($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getAllPengawas()
    {
        return $this->orderBy('updated_at', 'desc')->findAll();
    }
    public function insertPengawas($data)
    {
        $this->insert($data);
    }
    public function updatePengawas($data, $id)
    {
        $this->update($id, $data);
    }
    public function deletePengawas($id)
    {
        $this->delete($id);
    }
}
