<?php

namespace App\Controllers\Dashboard;

use Ramsey\Uuid\Uuid;
use Cocur\Slugify\Slugify;
use App\Models\AgendaRapatModel;
use App\Controllers\BaseController;


class AgendaRapat extends BaseController
{
    protected $helpers = ['form'];
    protected $agendaRapat;
    public function __construct()
    {
        $this->agendaRapat = new AgendaRapatModel();
        helper('my_helper');
    }


    public function tambahAgenda()
    {
        $data = [
            'title' => 'Tambah Agenda Rapat',
            'validation' => \Config\Services::validation()
        ];

        return view('dashboard/tambah_agenda', $data);
    }

    public function view($slug)
    {
        $linkRapat = $this->agendaRapat->where('slug', $slug)->first()['link_rapat'];
        $data = [
            'title' => 'View Agenda Rapat',
            'qrCode' => generateQrCode($linkRapat),
            'data' => $this->agendaRapat->where('slug', $slug)->first(),
        ];

        return view('dashboard/view_agenda', $data);
    }

    public function informasiRapat($kodeRapat)
    {
        $agendaRapat  = $this->agendaRapat->getAgendaRapatByKode($kodeRapat);
        // dd($agendaRapat);
        $data = [
            'title' => 'Informasi Rapat',
            'qrCode' => generateQrCode($agendaRapat['link_rapat']),
            'agendaRapat' => $agendaRapat,
        ];

        $this->session->set('id_agenda', $agendaRapat['id_agenda']);
        return view('informasi_rapat', $data);
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
        $currentDate = date('Y-m-d');
        $selectedDate = $this->request->getVar('tanggal');
        if ($selectedDate == $currentDate) {
            var_dump('Waktu rapat harus aman ' . $currentTime . '.');
            if ($selectedTime < $roundedCurrentTime) {
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
            'tempat' => $this->request->getVar('tempat'),
            'tanggal' => $this->request->getVar('tanggal'),
            'jam' => $this->request->getVar('jam'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'link_rapat' => base_url() . 'rapat/daftar-hadir/' . $kodeRapat,
            'created_at' => date('Y-m-d H:i:s'),
            // 'status' => 'tersedia'
        ]);

        return redirect('dashboard/agenda-rapat')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Edit Agenda Rapat',
            'data' => $this->agendaRapat->where('slug', $slug)->first(),
            'validation' => \Config\Services::validation(),
        ];

        return view('dashboard/edit_agenda', $data);
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
        $selectedTime = $this->request->getVar('jam_default');

        // Compare the selected date with the current date
        $currentDate = date('Y-m-d');
        $selectedDate = $this->request->getVar('tanggal');
        if ($selectedDate == $currentDate) {
            if ($selectedTime < $roundedCurrentTime) {
                return redirect()->back()->withInput()->with('error', 'Waktu rapat harus diatas jam ' . $currentTime . '.');
            }
        }

        if ($selectedDate < $currentDate) {
            return redirect()->back()->withInput()->with('error', 'Tanggal rapat harus diatas tanggal ' . $currentDate . '.');
        }

        // Determine the name of the "jam" field to use based on the date condition
        if ($selectedDate < $currentDate || ($selectedDate == $currentDate && $this->request->getVar('jam_default'))) {
            // Use the "jam_default" field when the date is today and "jam_default" is selected
            $jamValue = $this->request->getVar('jam_default');
        } else {
            // Use the "jam" field for other dates
            $jamValue = $this->request->getVar('jam');
        }

        $data = [
            'agenda_rapat' => $this->request->getVar('agenda_rapat'),
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
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Agenda Rapat harus diisi.'
                    ]
                ],
                'tempat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempat Rapat harus diisi.'
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
                'deskripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Deskripsi Rapat harus diisi.'
                    ]
                ],
            ];
        return $this->validate($rules);
    }
}
