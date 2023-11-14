<?php

namespace App\Models;

use CodeIgniter\Model;

class BidangInstansiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'bidanginstansis';
    protected $primaryKey       = 'id_bidang';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_bidang',
        'slug',
        'nama_bidang',
        'id_instansi',
    ];

    // Dates
    protected $useTimestamps = false;
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

    function getALlBidang()
    {
        return $this->findAll();
    }

    function getAllBidangByInstansi($idInstansi)
    {
        return $this->where('id_instansi', $idInstansi)->findAll();
    }

    public function updateBidang($idBidang, $data)
    {
        // Filter by id_agenda
        $this->where('id_bidang', $idBidang);
        $this->set($data);
        $this->update();
    }
}
