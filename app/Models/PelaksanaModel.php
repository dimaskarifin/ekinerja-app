<?php

namespace App\Models;

use CodeIgniter\Model;

class PelaksanaModel extends Model
{

    public function __construct()
    {
        parent::__construct();

        //get all fields
        $fields = $this->db->getFieldNames('pelaksana');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'pelaksana';
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

    function getPelaksana($id)
    {
        return $this->where(['id' => $id])->first();
    }

    function getAllPelaksana()
    {
        return $this->where('deleted_at', null)->orderBy('updated_at', 'desc')->findAll();
    }

    function insertPelaksana($data)
    {
        return $this->insert($data);
    }

    function updatePelaksana($data, $id)
    {
        return $this->update($id, $data);
    }

    function deletePelaksana($id)
    {
        return $this->delete($id);
    }
}
