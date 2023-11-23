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
                    'g-recaptcha-response' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'centang reCAPTCHA terlebih dahulu.',
                        ]
                    ],
                ];

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput();
            }

            $token = $this->request->getVar('g-recaptcha-response');
            $validateCaptcha  = verifyCaptcha($token);
            if (!$validateCaptcha->success) {
                $this->session->setFlashdata('error', 'Terdapat aktifitas tidak wajar, mohon coba lagi.');
                return redirect()->back()->withInput()->with('kode_valid', true);
            }

            $admin = $this->adminModel->where('username', $username)->first();
            // dd($user);
            if (!$admin) {
                $this->incrementLoginAttempts();
                return redirect()->to('/auth/login')->with('error', 'Username atau Password Salah');
            }
            if (password_verify($password, $admin['password'])) {
                $data = [
                    'id_admin' => $admin['id_admin'],
                    'username' => $admin['username'],
                    'nama' => $admin['nama'],
                    'slug' => $admin['slug'],
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
                $this->incrementLoginAttempts();
                return redirect()->to('/auth/login')->with('error', 'Username atau Password Salah');
            }
        } else {
            $data = [
                'title' => 'Log In',
            ];
            return view('auth/login_view', $data);
        }
    }

    protected function incrementLoginAttempts()
    {
        $loginAttempts = session()->get('loginAttempts') ?? 3;
        $loginAttempts--;
        session()->set('loginAttempts', $loginAttempts);

        if ($loginAttempts <= 0) {
            session()->setTempdata('failedLogin', 'Anda salah memasukkan username atau password sebanyak 3 kali. Coba lagi beberapat saat lagi.', 60);
            session()->remove('loginAttempts');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
