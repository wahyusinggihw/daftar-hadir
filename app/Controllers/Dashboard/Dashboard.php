<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AgendaRapatModel;
use App\Models\DaftarHadirModel;

class Dashboard extends BaseController
{
    protected $agendaRapat;
    protected $daftarhadir;
    public function __construct()
    {
        $this->agendaRapat = new AgendaRapatModel();
        $this->daftarhadir = new DaftarHadirModel();
        helper('my_helper');
    }

    public function index()
    {
        $id_instansi = session()->get('id_instansi');
        $role = session()->get('role');

        if ($role == 'superadmin') {
            $agendaRapat = $this->agendaRapat->viewAgendaRapatByInstansi();
        } else {
            $agendaRapat = $this->agendaRapat->getAllAgendaByInstansi($id_instansi);
        }

        $status = $this->agendaRapat->getStatusAgendaInstansi($id_instansi);
        $data = [
            'title' => 'Home',
            'active' => 'home',
            'agenda' => $agendaRapat,
            'totalagenda' => count($agendaRapat),
            'totalAgendaTersedia' => count($status['tersedia']),
            'totalAgendaSelesai' =>  count($status['selesai']),
        ];

        return view('dashboard/home_dashboard', $data);
    }

    public function viewDetailAgendaRapatByInstansi($id_instansi)
    {
        $agendaRapat = $this->agendaRapat->viewDetailAgendaRapatByInstansi($id_instansi);
        $status = $this->agendaRapat->getStatusAgendaInstansi($id_instansi);

        $data = [
            'title' => 'Agenda Rapat',
            'subtitle' => $agendaRapat[0]['nama_instansi'],
            'active' => 'home',
            'agenda' => $agendaRapat,
            'totalagenda' => count($agendaRapat),
            'totalAgendaTersedia' => count($status['tersedia']),
            'totalAgendaSelesai' =>  count($status['selesai']),
        ];
        return view('dashboard/home_dashboard_detail', $data);
    }

    public function agenda()
    {
        $agendaRapat = $this->agendaRapat->getAgendas();
        // dd($agendaRapat);
        $data = [
            'title' => 'Agenda Rapat',
            'active' => 'agenda',
            'agenda' => $agendaRapat,
        ];

        return view('dashboard/agenda_rapat', $data);
    }

    public function daftarHadir()
    {
        $id_agenda = $this->request->getVar('daftar_agenda');

        $data = [
            'title' => 'Daftar Peserta Rapat',
            'active' => 'daftar_hadir',
            'agenda_rapat' => $this->agendaRapat->getAgendaRapatByID(),
            'daftar_hadir' => $this->daftarhadir->getDaftarHadirByID($id_agenda)
        ];
        // dd($data['daftar_hadir']);

        return view('dashboard/daftar_hadir', $data);
    }
}
