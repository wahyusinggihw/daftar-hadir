<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'admins';
    protected $primaryKey       = 'id_admin';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_admin',
        'slug',
        'role',
        'id_instansi',
        'nama_instansi',
        'id_bidang',
        'nama_bidang',
        'nama',
        'username',
        'password',
        'avatar',
        'created_at',
        'updated_at',
        'deleted_at',
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

    function getAdminByID()
    {
        return $this->where('id_admin', session()->get('id_admin'))->first();
    }
    function getAdminByRole()
    {
        if (session()->get('role') != 'superadmin') {

            return $this->where('id_instansi', session()->get('id_instansi'))->where('role', 'operator')->findAll();
        } else {
            return $this->findAll();
        }
    }
}
