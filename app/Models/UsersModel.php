<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user',
        'slug',
        'nip',
        'kode_ukerja',
        'instansi',
        'no_hp',
        'nama',
        'alamat',
        'username',
        'password',
        'avatar',
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function getPegawaiByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function createOrUpdateUser($data)
    {
        $user = $this->getPegawaiByUsername($data['username']);
        if ($user) {
            $this->save($user['id_user'], $data);
        } else {
            $this->insert($data);
        }
    }

    public function updatePegawai($id_user, $data)
    {
        return $this->update($id_user, $data);
    }
}
