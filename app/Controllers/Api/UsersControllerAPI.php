<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PesertaRapatModel;
use App\Models\PesertaUmumModel;
use CodeIgniter\API\ResponseTrait;

class UsersControllerAPI extends BaseController
{
    use ResponseTrait;
    protected $pesertaUmum;
    protected $instansiAPI;
    public function __construct()
    {
        $this->pesertaUmum = new PesertaUmumModel();
        $this->instansiAPI = new PesertaRapatModel();
    }

    /**
     * Get peserta umum by their NIK.
     *
     * @param string $nik The NIK of the user to retrieve.
     *
     * @return \CodeIgniter\HTTP\Response The response containing the user data or an error message.
     */
    public function getPeserta($nik)
    {
        // $nik = $this->request->getVar('nip');
        $data = $this->pesertaUmum->cariUser($nik);
        // check if not null
        if (isset($data)) {
            $response = [
                'status' => true,
                'error' => false,
                'data' => $data
            ];
            // return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'error' => false,
                'messages' => 'User not found'
            ];
        }
        return $this->respond($response);
    }

    // JQUERY
    public function getInstansi($nip)
    {
        $instansi = $this->instansiAPI->getInstansi();
        $instansiJSON = json_decode($instansi);
        foreach ($instansiJSON->data as $item) {
            if ($item->kode_instansi == $nip) {
                $result = [
                    'status' => true,
                    'error' => false,
                    'data' => $item
                ];
                break;
            } else {
                $result = [
                    'status' => false,
                    'error' => false,
                    'data' => null
                ];
            }
        }
        return $this->respond($result);
    }

    public function getPegawaiAsn($nip)
    {
        $pegawai = $this->instansiAPI->getAsnByNip($nip);
        $pegawaiJSON = json_decode($pegawai);

        if (isset($pegawaiJSON->data)) {
            $result = [
                'status' => true,
                'error' => false,
                'data' => $pegawaiJSON->data
            ];
            // break;
        } else {
            $result = [
                'status' => false,
                'error' => false,
                'data' => null
            ];
        }

        return $this->respond($result);
    }

    public function getPegawaiNonAsn($nip)
    {
        $pegawai = $this->instansiAPI->getNonAsnByNip($nip);
        $pegawaiJSON = json_decode($pegawai);

        if (isset($pegawaiJSON->data)) {
            $result = [
                'status' => true,
                'error' => false,
                'data' => $pegawaiJSON->data
            ];
            // break;
        } else {
            $result = [
                'status' => false,
                'error' => false,
                'data' => null
            ];
        }

        return $this->respond($result);
    }

    /**
     * Get pegawai Asn and NonAsn by NIP
     * 
     * @param string $nip NIP of the pegawai
     * @return mixed Response containing JSON data of the pegawai
     *
     * @throws \CodeIgniter\HTTP\Exceptions\HTTPException
     */
    public function getPegawai($nip)
    {
        $pegawaiAsn = $this->instansiAPI->getAsnByNip($nip);
        $pegawaiNonAsn = $this->instansiAPI->getNonAsnByNip($nip);

        $pegawaiAsnJSON = json_decode($pegawaiAsn);
        $pegawaiNonAsnJSON = json_decode($pegawaiNonAsn);

        $result = [
            'pegawai' => [
                'asn' => isset($pegawaiAsnJSON->data) ? $pegawaiAsnJSON->data : null,
                'non_asn' => isset($pegawaiNonAsnJSON->data) ? $pegawaiNonAsnJSON->data : null
            ]
        ];

        return $this->respond($result);
    }
}
