<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyekModel extends Model
{

    function __construct()
    {
        parent::__construct();

        //get all fields to array
        $fields = $this->db->getFieldNames('proyek');

        //build the fields to array
        foreach ($fields as $field) {
            if ($field != 'id') {
                $this->allowedFields = $field;
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
        $builder->select('proyek.*, proyek.id as proyek_id, m.nama as nama_mandor, p.nama as nama_pelaksana, t.nama as nama_tukang ,kegiatan.*')
            ->join('users as m', 'm.id = proyek.mandor_id')
            ->join('users as p', 'p.id = proyek.pelaksana_id')
            ->join('users as t', 't.id = proyek.tukang_id')
            ->join('kegiatan', 'kegiatan.id = proyek.kegiatan_id')
            ->where('proyek.deleted_at', null)
            ->where('p.nik', session('nik'));

        $query = $builder->get();
        return $query->getResult();
    }
}
