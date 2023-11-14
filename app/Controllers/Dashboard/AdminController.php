<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\PesertaRapatModel;
use App\Models\PesertaUmumModel;
use App\Models\BidangInstansiModel;
use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;

class AdminController extends BaseController
{
    protected $helpers = ['form'];
    protected $adminModel;
    protected $pesertaUmum;
    protected $slugify;
    protected $bidangModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->pesertaUmum = new PesertaUmumModel();
        $this->bidangModel = new BidangInstansiModel();
        $this->slugify = new Slugify();
    }

    public function index()
    {
        $currentRole = session()->get('role');
        if ($currentRole != 'superadmin') {
            $data = [
                'title' => 'Kelola Operator',
                'active' => 'kelola_operator',
                'role' => $currentRole,
                'admins' => $this->adminModel->getAdminByRole(),
            ];

            return view('dashboard/kelola_admin', $data);
        } else {
            $data = [
                'title' => 'Kelola Admin',
                'active' => 'kelola_peserta',
                'role' => $currentRole,
                'admins' => $this->adminModel->where('role', 'admin')->findAll(),
            ];
            return view('dashboard/kelola_admin', $data);
        }


        // dd($data);
    }

    public function tambahAdmin()
    {
        $role = session()->get('role');
        $pesertaRapat = new PesertaRapatModel();
        $instansi = $pesertaRapat->getInstansi();
        $instansiDecode = json_decode($instansi);
        $data = [
            'title' => $role == 'admin' ? 'Tambah Operator' : 'Tambah Admin',
            'validation' => \Config\Services::validation(),
            'instansi' => $instansiDecode,
            'bidang' => $this->bidangModel->getAllBidangByInstansi($this->session->get('id_instansi'))
        ];
        return view('dashboard/tambah_admin', $data);
    }

    public function store()
    {
        // dd($this->request->getPost());
        // $validateAdmin = $this->formValidateAdmin();
        // $validateOperator = $this->formValidateOperator();

        $instansi = $this->request->getVar('asal_instansi');
        $sections = explode('-', $instansi);

        $role = session()->get('role');

        $validate = $this->formValidate();
        if (!$validate) {
            return redirect()->back()->withInput();
        }
        // dd($this->request->getPost());
        $uuid = Uuid::uuid4()->toString();
        $slug = $this->slugify->slugify($this->request->getVar('nama'));
        if ($role == 'superadmin') {
            /* 
            Sample post
            asal_instansi = "75010306-Kominfosanti"
            */
            $id_instansi = $sections[0];
            $nama_instansi = $sections[1];

            $data = [
                'id_admin' => $uuid,
                'slug' => $slug,
                'role' =>  $role == 'admin' ? 'operator' : 'admin',
                'id_instansi' => $id_instansi,
                'nama_instansi' => $nama_instansi,
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('username'),
                'avatar' => 'default.png',
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        } else {
            /* 
            Sample post
            asal_instansi = "7cf5f4d6-c531-4dc6-982a-5bdbaab6cab5-Persandian dan Statistik"
            id_bidang = "7cf5f4d6-c531-4dc6-982a-5bdbaab6cab5"
            nama_bidang = "Persandian dan Statistik"
            */
            $id_bidang = implode('-', array_slice($sections, 0, 5));
            $nama_bidang = $sections[5];
            $data = [
                'id_admin' => $uuid,
                'slug' => $slug,
                'role' =>  $role == 'admin' ? 'operator' : 'admin',
                'id_instansi' => session()->get('id_instansi'),
                'nama_instansi' => session()->get('nama_instansi'),
                'id_bidang' => $id_bidang,
                'nama_bidang' => $nama_bidang,
                'nama' => $this->request->getVar('nama'),
                'username' => $this->request->getVar('username'),
                'avatar' => 'default.png',
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->adminModel->insert($data);
        return redirect()->to('/dashboard/kelola-admin')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($slug)
    {
        $currentRole = session()->get('role');
        $title = $currentRole == 'superadmin' ? 'Edit Password Admin' : 'Edit Password Operator';
        $data = [
            'title' => $title,
            'active' => 'kelola_admin',
            'role' => $currentRole,
            'data' => $this->adminModel->where('slug', $slug)->first(),
        ];

        return view('dashboard/edit_admin', $data);
    }

    public function update($id)
    {
        // dd($this->request->getPost());
        $validate = $this->validate([
            'new-password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password harus terdiri dari minimal 8 karakter',
                    'regex_match' => 'Password harus terdiri dari huruf besar, huruf kecil dan angka'
                ]
            ],
            'confirm-password' => [
                'rules' => 'required|matches[new-password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak sesuai'
                ]
            ]
        ]);

        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $this->adminModel->update($id, [
            'id_admin' => $id,
            'password' => password_hash($this->request->getVar('new-password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/dashboard/kelola-admin')->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $admin = $this->adminModel->find($id);
        session()->remove('logged_in');
        if ($admin) {
            $this->deleteAvatar($admin['id_admin']);
            $this->adminModel->delete($id);
            return redirect()->to('/dashboard/kelola-admin')->with('success', 'Data berhasil dihapus');
        }
    }

    private function deleteAvatar($id)
    {
        helper('filesystem');
        $avatarPath = FCPATH . 'uploads/avatars/';
        $files = glob($avatarPath . $id . '.*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }
    }

    protected function formValidate()
    {
        $validate = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'asal_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus dipilih'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[admins.username]|alpha_dash',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
                'errors' => [
                    'required' => 'Password harus diisi',
                    'min_length' => 'Password harus terdiri dari minimal 8 karakter',
                    'regex_match' => 'Password harus terdiri dari huruf besar, huruf kecil dan angka'
                ]
            ],
        ];

        return $this->validate($validate);
    }

    // protected function formValidateAdmin()
    // {
    //     $validate = [
    //         'nama' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Nama harus diisi'
    //             ]
    //         ],
    //         'asal_instansi' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Harus dipilih'
    //             ]
    //         ],
    //         'username' => [
    //             'rules' => 'required|is_unique[admins.username]|alpha_dash',
    //             'errors' => [
    //                 'required' => 'Username harus diisi',
    //                 'is_unique' => 'Username sudah terdaftar'
    //             ]
    //         ],
    //         'password' => [
    //             'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
    //             'errors' => [
    //                 'required' => 'Password harus diisi',
    //                 'min_length' => 'Password harus terdiri dari minimal 8 karakter',
    //                 'regex_match' => 'Password harus terdiri dari huruf besar, huruf kecil dan angka'
    //             ]
    //         ],
    //     ];

    //     return $this->validate($validate);
    // }
}
