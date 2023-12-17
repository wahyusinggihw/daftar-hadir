<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use App\Models\AgendaRapatModel;
use App\Models\DaftarHadirModel;
use App\Models\PesertaUmumModel;
use App\Models\PesertaRapatModel;

class RapatController extends BaseController
{
    protected $helpers = ['form'];
    protected $pesertaRapat;
    protected $pesertaUmum;
    protected $daftarHadir;
    protected $agendaRapat;
    public function __construct()
    {
        $this->pesertaRapat = new PesertaRapatModel();
        $this->pesertaUmum = new PesertaUmumModel();
        $this->daftarHadir = new DaftarHadirModel();
        $this->agendaRapat = new AgendaRapatModel();
    }


    public function berhasilPage()
    {
        $idAgenda = $this->session->get('id_agenda');
        // dd($idAgenda);
        $agendaRapat = $this->agendaRapat->getAgendaRapatByIdAgenda($idAgenda);
        $daftarHadir = $this->daftarHadir->getDaftarHadirByID($agendaRapat['id_agenda']);
        // dd($daftarHadir);
        $data = [
            'title' => 'Behasil',
            'agendaRapat' => $agendaRapat,
            'daftarHadir' => $daftarHadir[0],
        ];
        return view('berhasil', $data);
    }

    public function gagalPage()
    {
        $idAgenda = $this->session->get('id_agenda');
        // dd($idAgenda);
        $agendaRapat = $this->agendaRapat->getAgendaRapatByIdAgenda($idAgenda);
        $daftarHadir = $this->daftarHadir->getDaftarHadirByID($agendaRapat['id_agenda']);
        $data = [
            'title' => 'Gagal',
            'agendaRapat' => $agendaRapat,
            'daftarHadir' => $daftarHadir,
        ];
        return view('gagal', $data);
    }

    public function formAbsensi($kodeRapat)
    {
        helper('my_helper');
        $instansi = $this->pesertaRapat->getInstansi();
        $instansiDecode = json_decode($instansi);

        $kodeRapat = $this->session->get('id_agenda');

        $url = current_url();
        // cek apakah form diakses dari landing page atau dari scan qr code
        if (str_starts_with($url, site_url('/rapat/daftar-hadir/'))) {
            $kodeRapat = $this->request->getUri()->getSegment(3);
            $rapat = $this->agendaRapat->getAgendaRapatByKode(trim($kodeRapat));
            if ($rapat == null) {
                return redirect()->to('/')->with('error', 'Kode Rapat Tidak Ditemukan. Pastikan Kode yang Anda Masukkan Sudah Benar.');
            }
            $expiredTime = expiredTime($rapat['tanggal'], $rapat['jam'], $rapat['kadaluwarsa']);
            // dd($expiredTime);
            if ($expiredTime) {
                return redirect()->to('/')->with('error', 'Rapat Sudah Berakhir');
            }
        } else {
            // Handle the case where the URL doesn't match either pattern
            return redirect()->to('/');
        }

        // $rapat = $this->agendaRapat->getAgendaRapatByKode($kodeRapat);/
        // session()->setFlashdata('kode_valid', $rapat['kode_rapat']);
        // $this->session->set('id_agenda', $rapat['id_agenda']);
        $data = [
            'title' => 'Form Absensi',
            'instansi' => $instansiDecode,
            'rapat' => $rapat,
        ];

        return view('form_absensi', $data);
    }

    public function saveSignature($idAgenda, $nip)
    {
        helper('filesystem');

        $signatureData = $this->request->getPost('signatureData');

        // Get the writable path from the configuration
        $writablePath = WRITEPATH . 'uploads/signatures/';

        // Create a unique file name, e.g., using a timestamp
        $fileName = $idAgenda . '_' . $nip . '_' . '.png';

        if (!is_dir($writablePath)) {
            mkdir($writablePath, 0777);
        }

        $publicPath = FCPATH . 'uploads/signatures/';
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        // Save the file to the writable directory
        if (write_file($writablePath . $fileName, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData)))) {

            // Move the file to the public folder
            rename($writablePath . $fileName, $publicPath . $fileName);

            // Respond with a success message or other data
            $response = [
                'status' => 'success',
                'message' => 'Tanda tangan berhasil disimpan.',
                'publicPath' => base_url('uploads/signatures/' . $fileName)
            ];

            return $this->response->setJSON($response);
        } else {
            // Handle the error if the file couldn't be saved
            return $this->response->setJSON(['message' => 'Failed to save the signature.']);
        }
    }


    protected function handleAbsen($idAgenda, $nip, $statusUser)
    {
        $uuid = Uuid::uuid4()->toString();
        $uuid2 = Uuid::uuid4()->toString();
        $kodeRapat = $this->request->getVar('kode_rapat');
        $slugify = new Slugify();
        $slug = $slugify->slugify($kodeRapat);

        $saveTandaTangan = $this->saveSignature($idAgenda, $nip)->getBody();
        $tandaTanganDecode = json_decode($saveTandaTangan, true);
        $tandaTangan = $tandaTanganDecode['publicPath'];
        $status = $this->request->getPost('statusRadio');
        $instansiPegawai = $this->request->getPost('asal_instansi_option');
        $instansiTamu = $this->request->getPost('asal_instansi_tamu');

        $dataDaftarHadir = [
            'id_daftar_hadir' => $uuid2,
            'slug' => $slug,
            'id_agenda_rapat' => $idAgenda,
            'NIK' => $this->request->getVar('nip'),
            'nama' => $this->request->getVar('nama'),
            'no_hp' => $this->request->getVar('no_hp'),
            'status' => $status,
            'asal_instansi' => $status == 'pegawai' ? $instansiPegawai : $instansiTamu,
            'ttd' => $tandaTangan,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle the absen logic here
        $userExist = $this->pesertaUmum->checkIfExist($nip);
        if ($userExist != null && $statusUser == 'tamu') {
            $dataPesertaUmum = [
                'id_peserta_umum' => $userExist['id_peserta_umum'],
                'slug' => $slugify->slugify($this->request->getVar('nama')),
                // 'nik' => $this->request->getVar('nip'),
                'nama' => $this->request->getVar('nama'),
                'alamat' => $this->request->getVar('alamat'),
                'no_hp' => $this->request->getVar('no_hp'),
                'asal_instansi' => $instansiTamu,
            ];

            $dataPesertaRapat = [
                'id_peserta_rapat' => $userExist['id_peserta_umum'],
                'slug' => $slugify->slugify($this->request->getVar('nama')),
                'NIK' => $this->request->getVar('nip'),
            ];
            $this->pesertaUmum->insertOrUpdatePesertaUmum($dataPesertaUmum);
            $this->pesertaRapat->insertOrUpdatePesertaRapat($dataPesertaRapat);
            $this->daftarHadir->insertDaftarHadir($dataDaftarHadir);
        }

        if ($userExist == null && $statusUser == 'tamu') {
            $dataPesertaUmum = [
                'id_peserta_umum' => $uuid,
                'slug' => $slugify->slugify($this->request->getVar('nama')),
                'nik' => $this->request->getVar('nip'),
                'nama' => $this->request->getVar('nama'),
                // 'alamat' => $this->request->getVar('alamat'),
                'no_hp' => $this->request->getVar('no_hp'),
                'asal_instansi' => $instansiTamu,
            ];

            $dataPesertaRapat = [
                'id_peserta_rapat' => $uuid,
                'slug' => $slugify->slugify($this->request->getVar('nama')),
                'id_agenda_rapat' => $idAgenda,
                'NIK' => $this->request->getVar('nip'),
            ];

            $this->pesertaUmum->insertPesertaUmum($dataPesertaUmum);
            $this->pesertaRapat->insertPesertaRapat($dataPesertaRapat);
            $this->daftarHadir->insertDaftarHadir($dataDaftarHadir);

            session()->setFlashdata('berhasil', true);
            // session()->destroy('kode_valid');
            return redirect('berhasil')->with('kode_valid', true);
        } elseif ($statusUser == 'pegawai') {
            // insert ke daftar hadir jika peserta sudah ada di database / peserta adalah pegawai
            $this->daftarHadir->insertDaftarHadir($dataDaftarHadir);
        }
    }


    public function absenStore()
    {
        // dd($this->request->getPost());
        helper('my_helper');

        $validate = $this->validateForm();
        // $idAgenda = $this->session->get('id_agenda');
        $statusUser = $this->request->getVar('statusRadio');

        if (!$validate) {
            return redirect()->back()->withInput()->with('kode_valid', true);
        }

        $token = $this->request->getVar('g-recaptcha-response');
        $validateCaptcha  = verifyCaptcha($token);
        // dd($validateCaptcha);
        if (!$validateCaptcha->success) {
            $this->session->setFlashdata('error', 'Terdapat aktifitas tidak wajar, mohon coba lagi.');
            return redirect()->back()->withInput()->with('kode_valid', true);
        }

        $idAgenda = $this->request->getVar('id_agenda');
        $nip = $this->request->getVar('nip');
        $riwayatKehadiran = $this->daftarHadir->sudahAbsen($nip, $idAgenda);

        if (!$riwayatKehadiran) {
            $statusUser = $this->request->getVar('statusRadio');

            $this->handleAbsen($idAgenda, $nip, $statusUser);

            // $this->session->remove('id_agenda');
            session()->setFlashdata('kode_valid', true);
            session()->setFlashdata('id_agenda', $idAgenda);
            return redirect('berhasil')->with('success', 'Terimakasih telah mengisi daftar hadir!');
        } else {
            session()->setFlashdata('id_agenda', $idAgenda);
            session()->setFlashdata('kode_valid', true);
            return redirect('gagal')->with('error', 'Anda sudah melakukan absensi!');
        }
    }

    protected function validateForm()
    {
        $rules = [
            'nip' => [
                'rules' => 'required|numeric|min_length[15]|max_length[18]',
                'errors' => [
                    'required' => 'Data harus diisi',
                    'numeric' => 'Data harus berupa angka'
                ]
            ],
            'no_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No HP harus diisi',
                    'numeric' => 'No HP harus berupa angka'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            // 'alamat' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'Alamat harus diisi'
            //     ]
            // ],
            'signatureData' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanda tangan harus diisi'
                ]
            ],
            // recaptcha
            'g-recaptcha-response' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'centang reCAPTCHA terlebih dahulu.'
                ]
            ],
        ];
        $validation = \Config\Services::validation();
        $validationResult = $this->validate($rules);

        $status = $this->request->getVar('statusRadio');

        if (!$this->request->getVar('statusRadio')) {
            $validation->setError('statusRadio', 'Wajib dipilih');
            $rules['asal_instansi_option'] = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih instansi terlebih dahulu',
                ],
            ];
            $validationResult = false;
        }


        if ($status == 'pegawai') {
            if (!$this->request->getVar('asnNonAsnRadio')) {
                $validation->setError('asnNonAsnRadio', 'Wajib dipilih');
                $validationResult = false;
            }
            $rules['asal_instansi_option'] = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih instansi terlebih dahulu',
                ],
            ];
            // Apply additional rules for "pegawai" status
            $rules['nip'] = [
                'rules' => 'required|numeric|min_length[15]|max_length[18]',
                'errors' => [
                    'required' => 'Data harus diisi',
                    'numeric' => 'Data harus berupa angka'
                ]
            ];
            // Add any other rules specific to "pegawai" status
        }

        if ($status == 'tamu') {
            unset($rules['asal_instansi_option']);
            // Apply additional rules for "tamu" status
            $rules['asal_instansi_tamu'] = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Instansi harus diisi',
                ],
            ];
            // Add any other rules specific to "tamu" status
        }

        $validationResult = $validation->setRules($rules)->run();

        return $validationResult;
    }
}
