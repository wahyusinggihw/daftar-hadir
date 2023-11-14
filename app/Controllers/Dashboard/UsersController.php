<?php

namespace App\Controllers\Dashboard;

use Ramsey\Uuid\Uuid;
use App\Models\AdminModel;
use Cocur\Slugify\Slugify;
use App\Controllers\BaseController;

class UsersController extends BaseController
{
    protected $helpers = ['form'];
    protected $slugify;
    protected $users;
    public function __construct()
    {
        $this->users = new AdminModel();
        $this->slugify = new Slugify();
    }

    public function index()
    {
        $profile = $this->users->getAdminByID();
        $data = [
            'title' => 'Profile',
            'active' => 'profile',
            'profile' => $profile
        ];
        return view('dashboard/profile', $data);
    }

    public function edit($slug)
    {
        $profile = $this->users->where('slug', $slug)->first();
        $data = [
            'title' => 'Edit Profil',
            'data' => $profile,
            // 'validation' => \Config\Services::validation(),
            // 'password' => $password2
        ];


        return view('dashboard/edit_profile', $data);
    }

    public function editPassword($slug)
    {
        $profile = $this->users->where('slug', $slug)->first();
        // dd($profile['id_admin']);
        $data = [
            'title' => 'Edit Password',
            'data' => $profile,
            // 'validation' => \Config\Services::validation(),
            // 'password' => $password2
        ];

        return view('dashboard/edit_profilepassword', $data);
    }



    public function updatePassword($id)
    {
        $profile = $this->users->where('id_admin', $id)->first();
        // dd($this->request->getPost());
        $validate = $this->validate([

            'old-password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    // 'matches' => 'Password lama tidak cocok dengan password sebelumnya',
                    'required' => 'Password lama harus diisi'
                ]
            ],
            'new-password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password baru harus terdiri dari minimal 8 karakter',
                    'regex_match' => 'Password baru harus terdiri dari huruf besar, huruf kecil, angka, dan karakter khusus'
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

        if (!password_verify($this->request->getVar('old-password'), $profile['password'])) {
            // Old password doesn't match, return an error
            return redirect()->back()->withInput()->with('error', 'Password lama tidak cocok');
        }

        if (!$validate) {
            return redirect()->back()->withInput();
        }
        // die;
        // $slug = $this->slugify->slugify($this->request->getVar('nama'));
        $this->users->update($id, [
            'id_admin' => $id,
            'updated_at' => date('Y-m-d H:i:s'),
            'password' => password_hash($this->request->getVar('new-password'), PASSWORD_DEFAULT)
        ]);
        session()->setFlashdata('success', 'Data berhasil diubah.');
        return redirect()->to('/dashboard/profile')->with('success', 'Data berhasil diubah');
    }

    //update profile
    public function update($id)
    {
        // dd($this->request->getPost(), $avatar);
        $validate = $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'username' => [
                'rules' => 'required|alpha_dash',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username tidak boleh sama dengan sebelumnya'
                ]
            ],
            'avatar' => [
                'rules' => 'max_size[avatar,1024]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'File yang anda pilih bukan gambar',
                    'mime_in' => 'File yang anda pilih bukan gambar'
                ]
            ],
        ]);

        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $avatar = $this->request->getFile('avatar');
        if ($avatar->getError() == 4) {
            $imageName = 'default.jpg';
        } else {
            $imageName = $id . '.' . $avatar->getExtension();
            $avatar->move('uploads/avatars', $imageName);
        }

        $slug = $this->slugify->slugify($this->request->getVar('nama'));
        $this->users->save([
            'id_admin' => $id,
            'slug' => $slug,
            'nama' => $this->request->getVar('nama'),
            'avatar' => $imageName,
            'username' => $this->request->getVar('username'),
            'updated_at' => date('Y-m-d H:i:s')
            // 'password' => password_hash($this->request->getVar('new-password'), PASSWORD_DEFAULT)
        ]);
        session()->remove('avatar');
        session()->set('avatar', $imageName);

        return redirect()->to('/dashboard/profile')->with('success', 'Data berhasil diubah');
    }
}
