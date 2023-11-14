<?php

namespace App\Models;

use CodeIgniter\Model;

class DaftarHadirModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'daftarhadirs';
    protected $primaryKey       = 'id_daftar_hadir';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_daftar_hadir',
        'slug',
        'id_agenda_rapat',
        'NIK',
        'nama',
        'asal_instansi',
        'ttd',
        'created_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'NIK' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'NIP/NIK harus diisi',
                'numeric' => 'NIP/NIK harus berupa angka'
            ]
        ],
        'nama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama harus diisi'
            ]
        ],
        'asal_instansi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Asal Instansi harus diisi'
            ]
        ],
        'ttd' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tanda Tangan harus diisi'
            ]
        ]


    ];
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

    function getDaftarHadir()
    {
        $id_admin = session()->get('id_admin');
        $builder = $this->table('daftarhadirs');
        $builder->select('*');
        $builder->join('agendarapats', 'agendarapats.id_agenda = daftarhadirs.id_agenda_rapat',);
        $builder->where('id_admin', $id_admin);
        $query = $builder->get()->getResultArray();

        return $query;
    }

    function getDaftarHadirByID($id_agenda)
    {
        $id_admin = session()->get('id_admin');
        $builder = $this->table('daftarhadirs');
        $builder->select('daftarhadirs.*, daftarhadirs.created_at AS daftarhadirs_created_at, agendarapats.created_at AS agendarapats_created_at');
        $builder->join('agendarapats', 'agendarapats.id_agenda = daftarhadirs.id_agenda_rapat',);
        // $builder->where('id_admin', $id_admin);
        $builder->where('id_agenda_rapat', $id_agenda);
        $query = $builder->get()->getResultArray();
        return $query;
    }

    function sudahAbsen($nik)
    {
        $data = $this->where('NIK', $nik)->first();
        $id_agenda = session()->get('id_agenda');
        if ($data != null) {
            if ($data['id_agenda_rapat'] == $id_agenda) {
                return true;
            } else {
                return false;
            }
        }
        // return false;
    }

    function sudahAbsenAPI($nik, $id_agenda)
    {
        $data = $this->where('NIK', $nik)->first();
        if ($data != null) {
            if ($data['id_agenda_rapat'] == $id_agenda) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function insertDaftarHadir($data)
    {
        return $this->insert($data);
    }
}
