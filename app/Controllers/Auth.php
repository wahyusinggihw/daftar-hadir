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
        helper('my_helper');
    }

    public function berhasil()
    {
        $data = [
            'title' => 'Berhasil',
        ];
        return view('auth/berhasil', $data);
    }

    public function login()
    {
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
                    // 'logged_in' => TRUE
                ];
                session()->set($data);
                if ($password === 'Admin123') {
                    session()->set('password_default', TRUE);
                    return redirect()->to('/auth/change-password')->with('error', 'Silahkan mengganti password terlebih dahulu');
                }

                session()->set('logged_in', TRUE);
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

    public function changePassword()
    {
        if ($this->request->is('post')) {
            $rules =
                [
                    'password' => [
                        'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                        'errors' => [
                            'required' => 'Password baru harus diisi',
                            'min_length' => 'Password baru harus terdiri dari minimal 8 karakter',
                            'regex_match' => 'Password baru harus terdiri dari huruf besar, huruf kecil dan angka.'
                        ]
                    ],
                    'confirm-password' => [
                        'rules' => 'required|matches[password]',
                        'errors' => [
                            'required' => 'Konfirmasi password harus diisi',
                            'matches' => 'Konfirmasi password tidak sesuai'
                        ]
                    ]
                    // 'g-recaptcha-response' => [
                    //     'rules' => 'required',
                    //     'errors' => [
                    //         'required' => 'centang reCAPTCHA terlebih dahulu.',
                    //     ]
                    // ],
                ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput();
            }

            // $token = $this->request->getVar('g-recaptcha-response');
            // $validateCaptcha  = verifyCaptcha($token);
            // if (!$validateCaptcha->success) {
            //     $this->session->setFlashdata('error', 'Terdapat aktifitas tidak wajar, mohon coba lagi.');
            //     return redirect()->back()->withInput();
            // }

            $id_admin = session()->get('id_admin');
            $password = $this->request->getVar('password');
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->adminModel->update($id_admin, ['password' => $password_hash]);
            session()->remove('password_default');
            session()->set('logged_in', TRUE);
            session()->setFlashdata('kode_valid', true);
            return redirect()->to('/auth/berhasil')->with('success', 'Password berhasil diubah');
        } else {
            $data = [
                'title' => 'Ganti Password',
            ];
            return view('auth/change_password', $data);
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
