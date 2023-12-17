<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PesertaRapatModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use PHPUnit\Util\Xml\Validator;

// use \Firebase\JWT\JWT;

class AuthControllerAPI extends BaseController
{
    use ResponseTrait;

    protected $userController;
    protected $userAPI;
    protected $users;
    protected $slugify;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->userController = new UsersControllerAPI();
        $this->userAPI = new PesertaRapatModel();
        $this->users = new UsersModel();
        $this->slugify = new Slugify();
    }

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

    // public function login()
    // {
    //     $username = $this->request->getVar('username');
    //     $password = $this->request->getVar('password');

    //     $user = $this->getPegawai($username);

    //     if (!$user['asn']) {
    //         if (!$user['non_asn']) {
    //             $response = [
    //                 'status' => 200,
    //                 'error' => true,
    //                 'message' => 'Username atau password salah.',
    //                 // 'message' => 'User tidak ada',

    //             ];
    //             return $this->respond($response, 200);
    //         }
    //     }

    //     $hash = password_hash($username, PASSWORD_DEFAULT);
    //     $pwd_verify = password_verify($password, $hash);

    //     if (!$pwd_verify) {
    //         $response = [
    //             'status' => 200,
    //             'error' => true,
    //             'message' => 'Username atau password salah.',

    //         ];
    //         return $this->respond($response, 200);
    //     }
    //     $response = service('response');

    //     // Set the content type
    //     $response->setContentType('application/json');

    //     if ($user['non_asn']) {
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'message' => 'Login berhasil',
    //             'data' => json_decode(json_encode($user['non_asn']), true),
    //             // 'token' => 
    //         ];
    //         return $this->respond($response, 200);
    //     } else {
    //         $response = [
    //             'status' => 200,
    //             'error' => false,
    //             'message' => 'Login berhasil',
    //             'data' => json_decode(json_encode($user['asn']), true),
    //             // 'token' => 
    //         ];
    //         return $this->respond($response, 200);
    //     }
    // }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Check if the user exists in the local database
        $savedUser = $this->users->getPegawaiByUsername($username);

        if (!$savedUser) {
            // User not found in the local database, fetch from API
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

            $userData = [];

            if ($user['asn']) {
                $slug = $this->slugify->slugify($user['asn']->nama_lengkap);
                $userData = [
                    'slug' => $slug,
                    'nama' => $user['asn']->nama_lengkap,
                    'nip' => $user['asn']->nip,
                    'kode_ukerja' => $user['asn']->kode_ukerja,
                    'instansi' => $user['asn']->ket_ukerja,
                    'alamat' => $user['asn']->alamat == null ? '-' : $user['asn']->alamat,
                    'no_hp' => $user['asn']->no_hp == null ? '-' : $user['asn']->no_hp,
                    'email' => $user['asn']->email == null ? '-' : $user['asn']->email,
                ];
            } elseif ($user['non_asn']) {
                $slug = $this->slugify->slugify($user['non_asn']->nama_lengkap);
                $userData = [
                    'slug' => $slug,
                    'nama' => $user['non_asn']->nama_lengkap,
                    'nip' => $user['non_asn']->nip,
                    'kode_ukerja' => $user['non_asn']->kode_ukerja,
                    'instansi' => $user['non_asn']->ket_ukerja,
                    'alamat' => $user['non_asn']->alamat == null ? '-' : $user['non_asn']->alamat,
                    'no_hp' => $user['non_asn']->no_hp == null ? '-' : $user['non_asn']->no_hp,
                    'email' => $user['non_asn']->email == null ? '-' : $user['non_asn']->email,
                ];
            }

            $uuid = Uuid::uuid4()->toString();
            // Create or update user data in the database
            $authData = [
                'id_user' => $uuid,
                'username' => $username,
                'password' => password_hash($username, PASSWORD_DEFAULT),
                'avatar' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                // Include other common fields as needed
            ];

            // Merge additional data with the user data
            $data = array_merge($authData, $userData);

            $this->users->createOrUpdateUser($data);

            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Login berhasil',
                'data' => $data,
                // 'token' => 
            ];
            return $this->respond($response, 200);
        } else {
            // User found in the local database, compare passwords
            $dbPassword = $savedUser['password'];
            $pwd_verify = password_verify($password, $dbPassword);
            // var_dump('simpan');
            if (!$pwd_verify) {
                // Password mismatch, return error response
                $response = [
                    'status' => 200,
                    'error' => true,
                    'message' => 'Username atau password salah.',
                ];
                return $this->respond($response, 200);
            }

            // User authenticated, return success response
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Login berhasil',
                'data' => $savedUser,
                // 'token' => 
            ];
            return $this->respond($response, 200);
        }
    }

    public function changePassword()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $newPassword = $this->request->getVar('new_password');

        $user = $this->users->getPegawaiByUsername($username);
        $pwd_verify = password_verify($password, $user['password']);

        if (!$pwd_verify) {
            $response = [
                'status' => 200,
                'error' => true,
                'message' => 'Password lama tidak valid.',

            ];
            return $this->respond($response, 200);
        }

        $validate =  $this->validate([
            'new_password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru harus terdiri dari minimal 8 karakter',
                    'regex_match' => 'Password baru harus terdiri dari huruf besar, huruf kecil dan angka.'
                ]
            ],
            // 'confirm_password' => [
            //     'rules' => 'required|matches[new_password]',
            //     'errors' => [
            //         'required' => 'Konfirmasi password harus diisi',
            //         'matches' => 'Konfirmasi password tidak sesuai'
            //     ]
            // ]
        ]);

        if (!$validate) {
            $response = [
                'status' => 200,
                'error' => true,
                // 'message' => $this->validator->getErrors(),
                'message' => 'Password baru harus diisi',
            ];
            return $this->respond($response, 200);
        }

        $this->users->update($user['id_user'], [
            'id_user' => $user['id_user'],
            'updated_at' => date('Y-m-d H:i:s'),
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
        // dd($user['username']);
        // $this->users->updatePegawai($user['username'], $data);

        $response = [
            'status' => 200,
            'error' => false,
            'message' => 'Password berhasil diubah',
            // 'token' => 
        ];
        return $this->respond($response, 200);
    }
}
