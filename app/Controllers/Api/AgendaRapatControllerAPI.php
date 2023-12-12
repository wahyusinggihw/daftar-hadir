<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AgendaRapatModel;
use CodeIgniter\API\ResponseTrait;

class AgendaRapatControllerAPI extends BaseController
{
    use ResponseTrait;
    protected $agendaRapat;
    public function __construct()
    {
        $this->agendaRapat = new AgendaRapatModel();
        helper('my_helper');
    }

    public function getByInstansi($idInstansi)
    {
        $agendaRapat = $this->agendaRapat->getAgendaAPI($idInstansi);

        if (empty($agendaRapat)) {
            return $this->errorResponse(200, 'Agenda rapat tidak ditemukan.');
        }

        return $this->response(200, $agendaRapat);
    }

    public function getByInstansiSelesai($idInstansi)
    {
        $agendaRapat = $this->agendaRapat->getAgendaAPISelesai($idInstansi);

        if (empty($agendaRapat)) {
            return $this->errorResponse(200, 'Agenda rapat tidak ditemukan.');
        }

        return $this->response(200, $agendaRapat);
    }

    public function getAgendaRapat($kodeRapat)
    {
        $agendaRapat = $this->agendaRapat->getAgendaRapatByKode($kodeRapat);

        if (!$agendaRapat) {
            return $this->errorResponse(500, 'Rapat tidak ditemukan');
        }

        // $expiredTime = expiredTime($agendaRapat['tanggal'], $agendaRapat['jam']);

        // if ($expiredTime) {
        //     return $this->errorResponse(500, 'Rapat sudah berakhir');
        // }
        return $this->response(200, $agendaRapat);
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
}
