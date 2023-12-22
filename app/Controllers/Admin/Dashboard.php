<?php

namespace App\Controllers\Admin;

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

        return view('admin/dashboard', $data);
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
        return view('admin/dashboard_detail', $data);
    }
}
