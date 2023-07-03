<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {

        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('users');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }

    protected $table            = 'users';
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

    public function getDetails()
    {
        $builder = $this->db->table('users');
        $builder->select('users.*, users.id as id_users, jabatan.*, bidang.*')
            ->join('jabatan', 'jabatan.id = users.jabatan_id')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->where('users.deleted_at', null)
            ->orderBy('users.updated_at', 'desc');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDetailEdit($id)
    {
        $builder = $this->db->table('users');
        $builder->select('users.*, users.id as id_users, jabatan.*, bidang.*')
            ->join('jabatan', 'jabatan.id = users.jabatan_id')
            ->join('bidang', 'bidang.id = users.bidang_id', 'left')
            ->where('users.id', $id);
        $query = $builder->get();

        return $query->getResult();
    }

    public function getUser($id)
    {
        return $this->where(['id' => $id])->first();
    }

    public function getUsers()
    {
        return $this->orderBy('updated_at', 'desc')->findAll();
    }
    public function insertUser($data)
    {
        return $this->insert($data);
    }
    public function updateUser($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}
