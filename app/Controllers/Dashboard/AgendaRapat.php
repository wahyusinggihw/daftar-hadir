<?php

namespace App\Controllers\Dashboard;

use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use App\Models\AgendaRapatModel;
use App\Models\DaftarHadirModel;
use App\Controllers\BaseController;


class AgendaRapat extends BaseController
{
    protected $helpers = ['form'];
    protected $agendaRapat;
    protected $daftarHadir;
    public function __construct()
    {
        $this->agendaRapat = new AgendaRapatModel();
        $this->daftarHadir = new DaftarHadirModel();
        helper('my_helper');
    }


    public function tambahAgenda()
    {
        $data = [
            'title' => 'Agenda Rapat',
            'subtitle' => 'Tambah Agenda Rapat',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tambah_agenda', $data);
    }

    public function view($slug)
    {
        $agendaRapat = $this->agendaRapat->getAgendabySlug($slug);
        // $linkRapat = $this->agendaRapat->where('slug', $slug)->first()['link_rapat'];
        $data = [
            'title' => 'Agenda Rapat',
            'subtitle' => 'Detail Agenda Rapat',
            'qrCode' => generateQrCode($agendaRapat[0]['link_rapat']),
            'data' => $agendaRapat[0],
            'jumlahKehadiran' => count($this->daftarHadir->getDaftarHadirByID($agendaRapat[0]['id_agenda'])),
            'status' => $agendaRapat[0]['status']
        ];

        return view('admin/view_agenda', $data);
    }

    public function store()
    {
        // dd($this->request->getPost());
        $slugify = new Slugify();
        $kodeRapat = kodeRapat();
        $uuid = Uuid::uuid4()->toString();

        $validate = $this->validateForm();
        if (!$validate) {
            return redirect()->back()->withInput();
        }

        // Compare the selected time with the rounded current time
        $currentTime = date('H:i');
        $roundedCurrentTime = getCurrentTimeRounded();
        $selectedTime = $this->request->getVar('jam');
        $currentDate = date('d-m-Y');
        $selectedDate = $this->request->getVar('tanggal');
        if ($selectedDate == $currentDate) {
            var_dump('Waktu rapat harus aman ' . $currentTime . '.');
            if ($selectedTime < $currentTime) {
                var_dump('Waktu rapat harus diatas jam ' . $currentTime . '.');
                return redirect()->back()->withInput()->with('error', 'Waktu rapat harus diatas jam ' . $currentTime . '.');
            }
        }

        // Compare the selected date with the current date
        if ($selectedDate < $currentDate) {
            var_dump('Waktu rapat harus diatas jam tanggal' . $currentDate . '.');
            return redirect()->back()->withInput()->with('error', 'Tanggal rapat harus diatas tanggal ' . $currentDate . '.');
        }
        // dd($uuid);
        $this->agendaRapat->insert([
            'id_agenda' => $uuid,
            'slug' => $slugify->slugify($this->request->getVar('agenda_rapat')),
            'id_admin' => session()->get('id_admin'), // 'id_admin' => '1
            'id_instansi' => session()->get('id_instansi'),
            'nama_instansi' => session()->get('nama_instansi'),
            'id_bidang' => session()->get('id_bidang'),
            'nama_bidang' => session()->get('nama_bidang'),
            'kode_rapat' => $kodeRapat,
            'agenda_rapat' => $this->request->getVar('agenda_rapat'),
            'program' => $this->request->getVar('program'),
            'tempat' => $this->request->getVar('tempat'),
            'tanggal' => $this->request->getVar('tanggal'),
            'jam' => $this->request->getVar('jam'),
            'kadaluwarsa' => $this->request->getVar('kadaluwarsa'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'link_rapat' => base_url() . 'rapat/daftar-hadir/' . $kodeRapat,
            'created_at' => date('Y-m-d H:i:s'),
            // 'status' => 'tersedia'
        ]);

        return redirect('admin/agenda-rapat')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Agenda Rapat',
            'subtitle' => 'Edit',
            'data' => $this->agendaRapat->where('slug', $slug)->first(),
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/edit_agenda', $data);
    }

    public function update()
    {
        // dd($this->request->getPost());
        $slugify = new Slugify();
        $validate = $this->validateForm();
        $idAgenda = $this->request->getVar('id_agenda');

        if (!$validate) {
            return redirect()->back()->withInput();
        }


        // Compare the selected time with the rounded current time
        $currentTime = date('H:i');
        $roundedCurrentTime = getCurrentTimeRounded();
        $selectedTime = $this->request->getVar('jam');

        // Compare the selected date with the current date
        $currentDate = date('d-m-Y');
        $selectedDate = $this->request->getVar('tanggal');
        if ($selectedDate == $currentDate) {
            if ($selectedTime < $currentTime) {
                return redirect()->back()->withInput()->with('error', 'Waktu rapat harus diatas jam ' . $currentTime . '.');
            }
        }

        if ($selectedDate < $currentDate) {
            return redirect()->back()->withInput()->with('error', 'Tanggal rapat harus diatas tanggal ' . $currentDate . '.');
        }

        // Determine the name of the "jam" field to use based on the date condition
        if ($selectedDate < $currentDate || ($selectedDate == $currentDate && $this->request->getVar('jam'))) {
            // Use the "jam" field when the date is today and "jam" is selected
            $jamValue = $this->request->getVar('jam');
        } else {
            // Use the "jam" field for other dates
            $jamValue = $this->request->getVar('jam');
        }

        $data = [
            'agenda_rapat' => $this->request->getVar('agenda_rapat'),
            'program' => $this->request->getVar('program'),
            'slug' => $slugify->slugify($this->request->getVar('agenda_rapat')),
            'tempat' => $this->request->getVar('tempat'),
            'tanggal' => $this->request->getVar('tanggal'),
            'jam' => $jamValue,
            'deskripsi' => $this->request->getVar('deskripsi'),
            // 'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->agendaRapat->updateAgenda($idAgenda, $data);

        return redirect('dashboard/agenda-rapat')->with('success', 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $agenda = $this->agendaRapat->find($id);
        if ($agenda) {
            $this->deleteSignatures($agenda['id_agenda']);
            $this->agendaRapat->delete($id);
            return redirect()->to('/dashboard/agenda-rapat')->with('success', 'Data berhasil dihapus.');
        }
    }

    private function deleteSignatures($idAgenda)
    {
        helper('filesystem');
        $signaturePath = FCPATH . 'uploads/signatures/';

        // Use glob to find files matching the kode_rapat
        $files = glob($signaturePath . $idAgenda . '_*');
        // dd($files);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }
    }

    protected function validateForm()
    {
        $rules =
            [
                'agenda_rapat' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Agenda Rapat harus diisi.',
                        'min_length' => 'Agenda Rapat minimal memiliki 5 karakter.'
                    ]
                ],
                'program' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Program Rapat harus diisi.',
                        'min_length' => 'Program Rapat minimal memiliki 5 karakter.'
                    ]
                ],
                'tempat' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Tempat Rapat harus diisi.',
                        'min_length' => 'Tempat Rapat minimal memiliki 5 karakter.'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal Rapat harus diisi.'
                    ]
                ],
                'jam' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jam Rapat harus diisi.'
                    ]
                ],
                'kadaluwarsa' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Kadaluwarsa Rapat harus diisi.',
                        'numeric' => 'Kadaluwarsa Rapat harus berupa angka.'
                    ]
                ],
                'deskripsi' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Deskripsi Rapat harus diisi.',
                        'min_length' => 'Deskripsi Rapat minimal memiliki 5 karakter.'
                    ]
                ],
            ];
        return $this->validate($rules);
    }
}
