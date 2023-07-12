<?php

namespace App\Models;

use CodeIgniter\Model;

class TimelineKegiatanModel extends Model
{
    protected $allowedFields;

    public function __construct()
    {
        parent::__construct();
        //get all fields array
        $fields = $this->db->getFieldNames('timeline_kegiatan');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields[] = $field;
            }
        }
        helper(['session']);
    }


    protected $table            = 'timeline_kegiatan';
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

    public function getTimelineKegiatans() {
        $builder = $this->db->table('timeline_kegiatan');
        $builder->select('timeline_kegiatan.*, kegiatan.uraian_kegiatan')
            ->join('kegiatan', 'kegiatan.id = timeline_kegiatan.kegiatan_id')
            ->join('proyek', 'proyek.kegiatan_id = timeline_kegiatan.kegiatan_id')
            ->where('timeline_kegiatan.deleted_at', null)
            ->where('proyek.tukang_id', session()->get('id'));

        $query = $builder->get();
        return $query->getResult();
    }

    public function getTimelineKegiatan($id) {
        $builder = $this->db->table('timeline_kegiatan');
        $builder->select('timeline_kegiatan.*, kegiatan.uraian_kegiatan')
            ->join('kegiatan', 'kegiatan.id = timeline_kegiatan.kegiatan_id')
            ->where('timeline_kegiatan.id', $id)
            ->where('timeline_kegiatan.deleted_at', null);

        $query = $builder->get();
        return $query->getResult();
    }

    public function getTimelineKegiatanByKegiatanId($id) {
        $builder = $this->db->table('timeline_kegiatan');
        $builder->select('timeline_kegiatan.*, kegiatan.uraian_kegiatan')
            ->join('kegiatan', 'kegiatan.id = timeline_kegiatan.kegiatan_id')
            ->where('timeline_kegiatan.kegiatan_id', $id)
            ->where('timeline_kegiatan.deleted_at', null);

        $query = $builder->get();
        return $query->getResult();
    }

    public function insertTimelineKegiatan($data)
    {
        return $this->insert($data);
    }
    public function updateTimelineKegiatan($data, $id)
    {
        return $this->update($id, $data);
    }
    public function deleteTimelineKegiatan($id)
    {
        return $this->delete($id);
    }
}
