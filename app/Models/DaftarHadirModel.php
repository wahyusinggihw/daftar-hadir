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
        'no_hp',
        'status',
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

    public function getDaftarHadirByID($id_agenda, $nik = null)
    {
        $id_admin = session()->get('id_admin');
        $builder = $this->table('daftarhadirs');
        $builder->select('daftarhadirs.*, daftarhadirs.created_at AS daftarhadirs_created_at, agendarapats.created_at AS agendarapats_created_at');
        $builder->join('agendarapats', 'agendarapats.id_agenda = daftarhadirs.id_agenda_rapat',);
        // $builder->where('id_admin', $id_admin);
        $builder->where('id_agenda_rapat', $id_agenda);
        if ($nik != null) {
            $builder->where('NIK', $nik);
        }
        $builder->orderBy('daftarhadirs.created_at', 'ASC');
        $query = $builder->get()->getResultArray();
        return $query;
    }

    /**
     * Check if a user has already marked attendance for a specific meeting.
     *
     * @param string $nik The NIK of the user.
     * @param int $id_agenda The ID of the meeting agenda.
     * @return bool Returns true if the user has marked attendance, false otherwise.
     */
    public function sudahAbsen($nik, $id_agenda)
    {
        $data = $this->where('NIK', $nik)->where('id_agenda_rapat', $id_agenda)->first();
        if ($data != null) {
            return true;
        } else {
            return false;
        }

        // return false;
    }

    public function insertDaftarHadir($data)
    {
        return $this->insert($data);
    }
}
