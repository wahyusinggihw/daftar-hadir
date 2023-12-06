<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DaftarHadirModel;
use App\Models\AgendaRapatModel;
use App\Models\BidangInstansiModel;
use TCPDF;

class DaftarHadirController extends BaseController
{
    protected $daftarhadir;
    protected $agendaRapat;
    protected $BidangInstansi;
    public function __construct()
    {
        $this->daftarhadir = new DaftarHadirModel();
        $this->agendaRapat = new AgendaRapatModel();
        $this->BidangInstansi = new BidangInstansiModel();
        helper('my_helper');
    }
    public function index()
    {

        $data = [
            'title' => 'Agenda Rapat',
            'subtitle' => 'Daftar Hadir',
            'data' => $this->daftarhadir->getDaftarHadir()

        ];
        return view('dashboard/daftar_hadir', $data);
    }

    public function cariDaftarHadir($slug)
    {
        $agendaRapat = $this->agendaRapat->where('slug', $slug)->first();
        $daftarHadir = $this->daftarhadir->getDaftarHadirByID($agendaRapat['id_agenda']);

        // dd($daftarHadir);

        $data = [
            'title' => 'Agenda Rapat',
            'title1' => 'Daftar Hadir',
            'subtitle' => elipsis($agendaRapat['agenda_rapat'], 20),
            'id_agenda' => $agendaRapat['id_agenda'],
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
        $bidangInstansi = $this->BidangInstansi->getBidangById($agendaRapat['id_bidang']);
        $judul = $agendaRapat['agenda_rapat'];
        $author = $this->session->get('nama');
        // $ttd = $daftarHadir[0]['ttd'];

        $rawData = [
            'agendaRapat' => $agendaRapat,
            'daftarHadir' => $daftarHadir,
            'bidangInstansi' => $bidangInstansi
        ];

        $pdf = new TCPDF('P', PDF_UNIT, 'F4', true, 'UTF-8', false);

        $pdf->SetCreator('DaftarHadir');
        $pdf->SetAuthor($author);
        $pdf->SetTitle('Daftar Hadir ' . $judul);
        $pdf->SetSubject($judul);

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 011', PDF_HEADER_STRING);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // Load the view file and assign data to it
        $html = view('dashboard/pdf_template', $rawData);

        //     $html = '
        //     <!DOCTYPE html>
        //     <html lang="en">
        //     <head>
        //         <meta charset="UTF-8">
        //         <meta name="viewport" content="width=device-width, initial-scale=1.0">
        //         <title>Document</title>
        //     </head>
        //     <body>
        //     <p class="header"><strong>DAFTAR HADIR RAPAT</strong><br> <span class="judul">' . $agendaRapat['agenda_rapat'] . '</span></p>
        //     <table border="1" cellpadding="4" class="tabeldaftarhadir">
        //     <tr>
        //         <th class="no-column" width="5%"><strong>No</strong></th>
        //         <th width="25%"><strong>Nama</strong></th>
        //         <th width="40%"><strong>Instansi</strong></th>
        //         <th width="15%"><strong>No HP</strong></th>
        //         <th width="14%"><strong>Tanda Tangan</strong></th>
        //     </tr>';

        //     $i = 1;
        //     foreach ($daftarHadir as $row) {
        //         $html .= '<tr><
        //         <td>' . $i++ . '</td>            
        //         <td>' . $i++ . '</td>            
        //         <td>' . $i++ . '</td>            
        //         <td>' . $i++ . '</td>            
        //         <td><img src="' . $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace(base_url(), '', $row['ttd']) . '" alt=""></td>            
        //         /tr>';
        //     }

        //     $html .= '
        //    </table>
        //     </body>
        //     </html>
        //     ';

        // dd($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace(base_url(), '', $row['ttd']));
        // $mpdf = new \Mpdf\Mpdf();
        // $mpdf->WriteHTML($html);
        // $this->response->setContentType('application/pdf');
        // $mpdf->Output();

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setContentType('application/pdf');
        $pdf->Output('Daftar Hadir' . $judul . '.pdf', 'I');
        exit(0);
    }
}
