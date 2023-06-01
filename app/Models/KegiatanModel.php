<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{

    protected $allowedFields;

    public function __construct()
    {

        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('kegiatan');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
    }


    protected $table            = 'kegiatan';
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

    public function getKegiatanDetail()
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kegiatan.id as id_kegiatan, users.nama ')
            ->join('users', 'users.id = kegiatan.id_users')
            ->where('kegiatan.deleted_at', null);

        $query = $builder->get();
        return $query->getResult();
    }

    public function editDetailKegiatan($id)
    {
        $builder = $this->db->table('kegiatan');
        $builder->select('kegiatan.*, kegiatan.id as id_kegiatan, users.nama')
            ->join('users', 'users.id = kegiatan.id_users')
            ->where('kegiatan.id', $id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getKegiatan($id)
    {
        return $this->where(['id' => $id])->first();
    }
    public function getKegiatans()
    {
        return $this->orderBy('updated_at', 'desc')->findAll();
    }
    public function insertKegiatan($data)
    {
        return $this->insert($data);
    }
    public function updateKegiatan($data, $id)
    {
        return $this->update($id, $data);
    }
    public function deleteKegiatan($id)
    {
        return $this->delete($id);
    }
}
