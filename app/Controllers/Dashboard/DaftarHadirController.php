<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DaftarHadirModel;
use App\Models\AgendaRapatModel;
use TCPDF;

class DaftarHadirController extends BaseController
{
    protected $daftarhadir;
    protected $agendaRapat;
    public function __construct()
    {
        $this->daftarhadir = new DaftarHadirModel();
        $this->agendaRapat = new AgendaRapatModel();
    }
    public function index()
    {

        $data = [
            'title' => 'Daftar Hadir',
            'data' => $this->daftarhadir->getDaftarHadir()

        ];
        return view('dashboard/daftar_hadir', $data);
    }

    public function cariDaftarHadir($slug)
    {
        $id_agenda = $this->agendaRapat->where('slug', $slug)->first()['id_agenda'];
        $daftarHadir = $this->daftarhadir->getDaftarHadirByID($id_agenda);

        // dd($daftarHadir);

        $data = [
            'title' => 'Daftar Hadir',
            'id_agenda' => $id_agenda,
            // 'data' => $this->daftarhadir->getDaftarHadirByID($id_agenda)
            'daftar_hadir' => $daftarHadir,

        ];

        return view('dashboard/daftar_hadir', $data);
    }

    public function delete($id)
    {
        $daftarHadir = $this->daftarhadir->find($id);
        $uri = previous_url();
        if ($daftarHadir) {
            $this->deleteSignatures($daftarHadir['id_agenda_rapat'], $daftarHadir['NIK']);
            $this->daftarhadir->delete($id);
            return redirect()->to($uri)->with('success', 'Data berhasil dihapus');
        }
    }

    private function deleteSignatures($idAgenda, $NIK)
    {
        helper('filesystem');
        $signaturePath = FCPATH . 'uploads/signatures/';
        $files = glob($signaturePath . $idAgenda . '_' . $NIK . '_*');
        // dd($files);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete the file
            }
        }
    }

    public function generatePdf($idAgenda)
    {
        $agendaRapat  = $this->agendaRapat->getAgendaRapatByIdAgenda($idAgenda);
        $daftarHadir = $this->daftarhadir->getDaftarHadirByID($idAgenda);
        $judul = $agendaRapat['agenda_rapat'];
        $rawData = [
            'agendaRapat' => $agendaRapat,
            'daftarHadir' => $daftarHadir,
        ];

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('DaftarHadir');
        $pdf->SetTitle('Daftar Hadir ' . $judul);
        $pdf->SetSubject($judul);

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 011', PDF_HEADER_STRING);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // Load the view file and assign data to it
        $html = view('dashboard/pdf_template', $rawData);

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setContentType('application/pdf');
        $pdf->Output($judul . '.pdf', 'I');
        exit(0);
    }
}
