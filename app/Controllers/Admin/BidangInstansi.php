<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BidangInstansiModel;
use App\Models\PesertaRapatModel;
use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;


class BidangInstansi extends BaseController
{
    protected $helpers = ['form'];
    protected $bidangModel;
    protected $slugify;
    protected $pesertaRapat;
    public function __construct()
    {
        $this->bidangModel = new BidangInstansiModel();
        $this->pesertaRapat = new PesertaRapatModel();
        $this->slugify = new Slugify();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Bidang',
            'bidang' => $this->bidangModel->getAllBidangByInstansi(session()->get('id_instansi')),
        ];

        return view('admin/bidanginstansi_view', $data);
    }

    public function tambahBidang()
    {
        $instansi = $this->pesertaRapat->getInstansi();
        $instansiDecode = json_decode($instansi);
        $data = [
            'title' => 'Tambah Bidang',
            'instansi' => $instansiDecode,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/bidanginstansi_tambah', $data);
    }

    public function store()
    {
        $validate = $this->validateForm();

        if (!$validate) {
            return redirect()->back()->withInput();
        }

        $uuid = Uuid::uuid4()->toString();
        $slug = $this->slugify->slugify($this->request->getVar('nama_bidang'));
        $data = [
            'id_bidang' => $uuid,
            'slug' => $slug,
            'nama_bidang' => $this->request->getVar('nama_bidang'),
            'nama_kepala_bidang' => $this->request->getVar('nama_kepala_bidang'),
            'nip_kepala_bidang' => $this->request->getVar('nip_kepala_bidang'),
            'id_instansi' => $this->session->get('id_instansi'),
            // 'created_at' => date('Y-m-d H:i:s'),
        ];

        // dd($data);
        $this->bidangModel->insert($data);
        return redirect()->to('/dashboard/kelola-bidang')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($slug)
    {
        $instansi = $this->pesertaRapat->getInstansi();
        $instansiDecode = json_decode($instansi);
        $data = [
            'title' => 'Edit Bidang',
            'data' => $this->bidangModel->where('slug', $slug)->first(),
            'instansi' => $instansiDecode,
            'selectedValue' => $this->bidangModel->where('slug', $slug)->first()['id_instansi'],
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/bidanginstansi_edit', $data);
    }

    public function update()
    {
        $slugify = new Slugify();

        $validate = $this->validateForm();
        $idBidang = $this->request->getVar('id_bidang');

        if (!$validate) {
            return redirect()->back()->withInput();
        }
        $data = [
            'slug' => $slugify->slugify($this->request->getVar('nama_bidang')),
            'nama_bidang' => $this->request->getVar('nama_bidang'),
            'nama_kepala_bidang' => $this->request->getVar('nama_kepala_bidang'),
            'nip_kepala_bidang' => $this->request->getVar('nip_kepala_bidang'),
            'id_instansi' => $this->session->get('id_instansi'),
        ];

        $this->bidangModel->updateBidang($idBidang, $data);

        session()->setFlashdata('success', 'Data berhasil diubah.');
        return redirect('dashboard/kelola-bidang');
    }

    public function delete($id)
    {
        $query = $this->bidangModel->find($id);
        if ($query) {
            $this->bidangModel->delete($id);
            return redirect()->to('/dashboard/kelola-bidang')->with('success', 'Data berhasil dihapus');
        }
    }

    protected function validateForm()
    {
        $rules =
            [
                'nama_bidang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama bidang harus diisi'
                    ]
                ],
                'nama_kepala_bidang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama kepala bidang harus diisi'
                    ]
                ],
                'nip_kepala_bidang' => [
                    'rules' => 'required|numeric|min_length[18]|max_length[18]',
                    'errors' => [
                        'required' => 'NIP kepala bidang harus diisi',
                        'numeric' => 'NIP kepala bidang harus berupa angka',
                        'min_length' => 'NIP kepala bidang harus 18 digit',
                        'max_length' => 'NIP kepala bidang harus 18 digit'
                    ]
                ],
            ];
        return $this->validate($rules);
    }
}
