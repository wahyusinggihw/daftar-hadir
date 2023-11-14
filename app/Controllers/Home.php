<?php

namespace App\Controllers;

use App\Models\AgendaRapatModel;
use App\Models\PesertaRapatModel;

class Home extends BaseController
{
    protected $pesertaRapat;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->pesertaRapat = new PesertaRapatModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Home',
            'validation' => \Config\Services::validation()
        ];

        return view('home', $data);
    }

    public function submitKode()
    {
        helper('my_helper');

        $agendaRapat = new AgendaRapatModel();
        $kode = $this->request->getVar('id_rapat');
        $instansi = $this->pesertaRapat->getInstansi();
        $instansiDecode = json_decode($instansi);
        $rule = [
            'id_rapat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode Rapat Harus Diisi',
                ]
            ]
        ];

        if (!$this->validate($rule)) {
            return redirect()->to('/')->withInput();
        }

        $rapat = $agendaRapat->getAgendaRapatByKode(trim($kode));
        if ($rapat == null) {
            return redirect()->to('/')->with('error', 'Kode Rapat Tidak Ditemukan');
        } else {

            $expiredTime = expiredTime($rapat['tanggal'], $rapat['jam']);
            // dd($expiredTime);
            if ($expiredTime) {
                return redirect()->to('/')->with('error', 'Rapat Sudah Berakhir');
            }

            $data = [
                'title' => 'Submit Kode',
                'rapat' => $rapat,
                'kode_rapat' => $kode,
                'instansi' => $instansiDecode,
                'id_agenda' => $rapat['id_agenda'],

            ];

            session()->setFlashdata('kode_valid', $kode);
            $this->session->set('id_agenda', $rapat['id_agenda']);
            return redirect()->to('/rapat/daftar-hadir/' . $kode)->with('data', $data);
        }
    }
}
