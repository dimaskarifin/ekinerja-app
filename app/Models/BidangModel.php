<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangModel extends Model
{

    public function __construct()
    {

        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('bidang');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'bidang';
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

    public function getBidang($id)
    {
        $this->where(['id' => $id])->first();
    }
    public function getBidangs()
    {
        $this->orderBy('updated_at', 'desc');
    }
    public function insertBidang($data)
    {
        $this->insert($data);
    }
    public function updateBidang($data, $id)
    {
        $this->update($id, $data);
    }
    public function deleteBidang($id)
    {
        $this->delete($id);
    }
}
