<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaRapatModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pesertarapats';
    protected $primaryKey       = 'id_peserta_rapat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_peserta_rapat',
        'slug',
        'id_agenda_rapat',
        'NIK',
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

    public function getPesertaRapat($kode_rapat)
    {
        return $this->where('kode_rapat', $kode_rapat)->findAll();
    }

    public function getInstansi()
    {
        $apiUrl = 'https://egov.bulelengkab.go.id/api/instansi_utama';
        $username = getenv('API_USERNAME');
        $password = getenv('API_PASSWORD');
        try {
            //code...
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);
            return $result;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAsnByNip($nip)
    {
        $apiUrl = 'https://egov.bulelengkab.go.id/api/getAsnByNip/' . $nip;
        $username = getenv('API_USERNAME');
        $password = getenv('API_PASSWORD');
        try {
            //code...
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);
            return $result;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getNonAsnByNip($nip)
    {
        $apiUrl = 'https://egov.bulelengkab.go.id/api/getNonAsnByNip/' . $nip;
        $username = getenv('API_USERNAME');
        $password = getenv('API_PASSWORD');
        try {
            //code...
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            }
            curl_close($ch);
            return $result;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function insertPesertaRapat($data)
    {
        return $this->insert($data);
    }

    public function insertOrUpdatePesertaRapat($data)
    {
        $this->save($data);
    }
}
