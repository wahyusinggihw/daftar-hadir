<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
// use CodeIgniter\RESTful\ResourceController;
use App\Models\PesertaRapatModel;
use App\Models\DaftarHadirModel;
use App\Models\AgendaRapatModel;
use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use DateTime;



class RapatControllerAPI extends BaseController
{
    use ResponseTrait;
    protected $helpers = ['form'];
    protected $daftarHadir;
    protected $instansiAPI; // Akan diganti dengan api pegawai
    protected $agendaRapat;
    public function __construct()
    {
        $this->instansiAPI = new PesertaRapatModel();
        $this->daftarHadir = new DaftarHadirModel();
        $this->agendaRapat = new AgendaRapatModel();
    }

    public function saveSignature($idAgenda, $nip)
    {
        helper('filesystem');

        $signatureData = $this->request->getVar('signatureData');

        // Get the writable path from the configuration
        $writablePath = WRITEPATH . 'uploads/signatures/';

        // Create a unique file name, e.g., using a timestamp
        $fileName = $idAgenda . '_' . $nip . '_' . '.png';

        // Create the writable directory if it doesn't exist
        if (!is_dir($writablePath)) {
            mkdir($writablePath, 0777);
        }

        // Save the file to the writable directory
        if (write_file($writablePath . $fileName, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData)))) {
            // Move the file to the public folder
            $publicPath = FCPATH . 'uploads/signatures/';
            // Create the public directory if it doesn't exist
            if (!is_dir($publicPath)) {
                mkdir($publicPath, 0777, true);
            }

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

    public function absenStore()
    {
        helper('my_helper');

        $kodeRapat = $this->request->getVar('kode_rapat');
        $idRapat = $this->agendaRapat->getAgendaRapatByKode($kodeRapat);
        $idAgenda = $idRapat['id_agenda'];
        $nip = $this->request->getVar('nip');

        $validate = $this->validateForm();

        if (!$validate) {
            return $this->errorResponse(500, $this->validator->getErrors());
        }

        $slug = (new Slugify())->slugify($kodeRapat);

        $detailRapat = $this->agendaRapat->select()->where('kode_rapat', $kodeRapat)->first();

        if ($detailRapat == null) {
            return $this->errorResponse(500, 'Kode rapat tidak ditemukan');
        }


        // $expirationTime = expiredTime($detailRapat['jam']);
        $expiredTime = expiredTime($idRapat['tanggal'], $idRapat['jam']);
        if ($expiredTime) {
            return $this->errorResponse(500, 'Rapat sudah berakhir');
        }

        $riwayatKehadiran = $this->daftarHadir->sudahAbsenAPI($this->request->getVar('nip'), $idRapat['id_agenda']);
        // Get the base64-encoded signature data from the mobile app
        $signatureData = $this->request->getVar('signatureData');

        // Decode the base64 data to binary
        $saveTandaTangan = $this->saveSignature($idAgenda, $nip)->getBody();
        $tandaTanganDecode = json_decode($saveTandaTangan, true);
        $tandaTangan = $tandaTanganDecode['publicPath'];


        if (!$riwayatKehadiran) {
            $dataDaftarHadir = [
                'id_daftar_hadir' => Uuid::uuid4()->toString(),
                'slug' => $slug,
                'id_agenda_rapat' => $idRapat['id_agenda'],
                'NIK' => $this->request->getVar('nip'),
                'nama' => $this->request->getVar('nama'),
                'asal_instansi' => $this->request->getVar('asal_instansi'),
                'ttd' => $tandaTangan,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->daftarHadir->insertDaftarHadir($dataDaftarHadir);
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'Berhasil melakukan absen.',
            ];
            return $this->respond($response, 200);
        } else {
            return $this->errorResponse(500, 'Anda sudah melakukan absen.');
        }
    }

    protected function response($status, $data)
    {
        $response = [
            'status' => $status,
            'error' => false,
            'data' => $data
        ];

        return $this->respond($response, 200);
    }

    protected function errorResponse($status, $message)
    {
        $response = [
            'status' => $status,
            'error' => true,
            'message' => $message
        ];

        return $this->respond($response, 200);
    }

    protected function  validateForm()
    {
        $rules = [
            'kode_rapat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode rapat harus diisi',
                ]
            ],
            'nip' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'NIK harus diisi',
                    'numeric' => 'NIK harus berupa angka'
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
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi'
                ]
            ],
            'asal_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih instansi terlebih dahulu'
                ]
            ],
            'signatureData' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanda tangan harus diisi'
                ]
            ]
        ];

        return $this->validate($rules);
    }
}
