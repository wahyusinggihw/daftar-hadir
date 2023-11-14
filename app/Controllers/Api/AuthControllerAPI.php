<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PesertaRapatModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
// use \Firebase\JWT\JWT;

class AuthControllerAPI extends BaseController
{
    use ResponseTrait;

    protected $userController;
    protected $userAPI;
    public function __construct()
    {
        $this->userController = new UsersControllerAPI();
        $this->userAPI = new PesertaRapatModel();;
    }

    // public function login()
    // {
    //     $username = $this->request->getVar('username');
    //     $pegawaiData = $userController->getPegawai($username);

    //     // You can now check the "pegawai" data for login purposes
    //     if (!empty($pegawaiData['pegawai']['asn']) || !empty($pegawaiData['pegawai']['non_asn'])) {
    //         // User is authenticated, you can proceed with the login
    //         return $this->respond(['message' => 'Login successful']);
    //     } else {
    //         // User is not authenticated
    //         return $this->respond(['message' => 'Login failed']);
    //     }
    // }

    private function getPegawai($nip)
    {
        $pegawaiAsn = $this->userAPI->getAsnByNip($nip);
        $pegawaiNonAsn = $this->userAPI->getNonAsnByNip($nip);

        $pegawaiAsnJSON = json_decode($pegawaiAsn);
        $pegawaiNonAsnJSON = json_decode($pegawaiNonAsn);

        $pegawaiData = [
            'asn' => isset($pegawaiAsnJSON->data) ? $pegawaiAsnJSON->data : null,
            'non_asn' => isset($pegawaiNonAsnJSON->data) ? $pegawaiNonAsnJSON->data : null
        ];

        return $pegawaiData;
    }

    public function login()
    {
        // $userAPI = new PesertaRapatModel();
        // $userAPI = $this->userController;
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->getPegawai($username);

        if (!$user['asn']) {
            if (!$user['non_asn']) {
                $response = [
                    'status' => 200,
                    'error' => true,
                    'message' => 'Username atau password salah.',
                    // 'message' => 'User tidak ada',

                ];
                return $this->respond($response, 200);
            }
        }

        $hash = password_hash($username, PASSWORD_DEFAULT);
        $pwd_verify = password_verify($password, $hash);

        if (!$pwd_verify) {
            $response = [
                'status' => 200,
                'error' => true,
                'message' => 'Username atau password salah.',

            ];
            return $this->respond($response, 200);
        }
        $response = service('response');

        // Set the content type
        $response->setContentType('application/json');

        if ($user['non_asn']) {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Login berhasil',
                'data' => json_decode(json_encode($user['non_asn']), true),
                // 'token' => 
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Login berhasil',
                'data' => json_decode(json_encode($user['asn']), true),
                // 'token' => 
            ];

            return $this->respond($response, 200);
        }
    }

    protected function cariUser($json, $key)
    {
        foreach ($json->data as $item) {
            if ($item->kode_instansi === $key) {
                $result = $item;
                break;
            } else {
                $result = null;
            }
        }
        return $result;
    }

    public function gantiPassword()
    {
    }
}
