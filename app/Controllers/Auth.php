<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $adminModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login()
    {
        helper('my_helper');
        if ($this->request->is('post')) {
            // dd($this->request->getPost());
            // $nip = $this->request->getVar('username');
            // $password = $this->request->getVar('password');
            // dd($nip, $password);
            $rules =
                [
                    'username' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Username tidak boleh kosong',
                        ]
                    ],
                    'password' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Password tidak boleh kosong',
                        ]
                    ],
                ];

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $token = $this->request->getVar('g-recaptcha-response');
            $validateCaptcha  = verifyCaptcha($token);
            if (!$validateCaptcha->success) {
                $this->session->setFlashdata('error', 'Terdapat aktifitas tidak wajar, mohon coba lagi.');
                return redirect()->back()->withInput()->with('kode_valid', true);
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput();
            }


            $admin = $this->adminModel->where('username', $username)->first();
            // dd($user);
            if (!$admin) {
                return redirect()->to('/auth/login')->with('error', 'Username atau Password Salah');
            }
            if (password_verify($password, $admin['password'])) {
                $data = [
                    'id_admin' => $admin['id_admin'],
                    'username' => $admin['username'],
                    'nama' => $admin['nama'],
                    'avatar' => $admin['avatar'],
                    'role' => $admin['role'],
                    'id_instansi' => $admin['id_instansi'],
                    'nama_instansi' => $admin['nama_instansi'],
                    'id_bidang' => $admin['id_bidang'],
                    'nama_bidang' => $admin['nama_bidang'],
                    'logged_in' => TRUE
                ];
                session()->set($data);
                if ($admin['role'] != 'operator') {
                    return redirect()->to('/dashboard');
                }
                return redirect()->to('/dashboard/agenda-rapat');
            } else {
                // session()->setFlashdata('error', 'Username atau Password Salah');
                return redirect()->to('/auth/login')->with('error', 'Username atau Password Salah');
            }
        } else {
            $data = [
                'title' => 'Log In',
            ];
            return view('auth/login_view', $data);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function tester()
    {
        $data = [
            'title' => 'Tester'
        ];
        return view('auth/tester.php', $data);
    }

    public function informasiRapat()
    {
        $data = [
            'title' => 'Tester'
        ];
        return view('informasi_rapat.php', $data);
    }
}
