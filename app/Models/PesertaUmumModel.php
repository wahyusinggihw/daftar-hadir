<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaUmumModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pesertaumums';
    protected $primaryKey       = 'id_peserta_umum';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_peserta_umum',
        'slug',
        'nik',
        'nama',
        // 'alamat',
        'no_hp',
        'asal_instansi',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
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

    /**
     * Check if a record with the given NIK exists in the database.
     * 
     * @param string $nik The NIK to check.
     * @return mixed The first record with the given NIK, or null if not found.
     */
    public function checkIfExist($nik)
    {
        $cek = $this->where('nik', $nik)->first();
        return $cek;
    }

    function cariUser($key)
    {
        $data = $this->where('NIK', $key)->first();
        if ($data != null) {
            return $data;
        } else {
            return null;
        }
        return false;
    }

    public function insertPesertaUmum($data)
    {
        $this->insert($data);
    }

    public function insertOrUpdatePesertaUmum($data)
    {
        $this->save($data);
    }
}
