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
        'alamat',
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

    // validation rules
    protected $validationRules = [
        'nik' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'NIK harus diisi',
                'numeric' => 'NIK harus berupa angka'
            ]
        ],
        'nama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama harus diisi'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat harus diisi'
            ]
        ],
        'no_hp' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'No HP harus diisi',
                'numeric' => 'No HP harus berupa angka'
            ]
        ],
        'asal_instansi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Asal Instansi harus diisi'
            ]
        ],

    ];

    public function cekIfExist($nik)
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
