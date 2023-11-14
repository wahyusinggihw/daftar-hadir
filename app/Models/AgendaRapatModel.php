<?php

namespace App\Models;

use DateTime;
use CodeIgniter\Model;
use App\Models\AdminModel;

class AgendaRapatModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'agendarapats';
    protected $primaryKey       = 'id_agenda';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_agenda',
        'slug',
        'id_admin',
        'role',
        'id_instansi',
        'nama_instansi',
        'id_bidang',
        'nama_bidang',
        'agenda_rapat',
        'kode_rapat',
        'tempat',
        'tanggal',
        'deskripsi',
        'jam',
        'link_rapat',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    function getAllAgenda()
    {
        $query = $this->findAll();
        return $query;
    }

    public function updateAgenda($idAgenda, $data)
    {
        // Filter by id_agenda
        $this->where('id_agenda', $idAgenda);
        $this->set($data);
        $this->update();
    }

    // refactor 
    // QUERY UNTUK DASHBOARD AGENDA RAPAT SEMUA ROLE
    public function getAgendas()
    {
        $role = session()->get('role');

        if ($role == 'superadmin') {
            return $this->getAllAgendas();
        } elseif ($role == 'admin') {
            return $this->getAdminAgendas();
        } elseif ($role == 'operator') {
            return $this->getOperatorAgendas();
        }
    }

    private function getAllAgendas()
    {
        $agendas = $this->findAll();
        $agendas = $this->getAgendasWithEditability($agendas);
        return $this->addStatusToAgendas($agendas);
    }

    private function getAdminAgendas()
    {
        $builder = $this->table('agendarapats');
        $builder->select('agendarapats.*, admins.slug as admin_slug, admins.id_bidang as admin_id_bidang, admins.nama_bidang as admin_nama_bidang');
        $builder->join('admins', 'admins.id_admin = agendarapats.id_admin');
        $builder->where('admins.id_instansi', session()->get('id_instansi'));
        $agendas = $builder->get()->getResultArray();
        $agendas = $this->getAgendasWithEditability($agendas);
        return $this->addStatusToAgendas($agendas);
    }

    private function getOperatorAgendas()
    {
        $builder = $this->table('agendarapats');
        $builder->select('agendarapats.*, admins.slug as admin_slug, admins.id_bidang as admin_id_bidang, admins.nama_bidang as admin_nama_bidang');
        $builder->join('admins', 'admins.id_admin = agendarapats.id_admin');
        $builder->where('admins.id_instansi', session()->get('id_instansi'));
        $builder->where('admins.id_bidang', session()->get('id_bidang'));
        $builder->orWhere('admins.id_bidang IS NULL OR admins.id_bidang = ""'); //show the admins instansi agenda 
        $agendas = $builder->get()->getResultArray();
        $agendas = $this->getAgendasWithEditability($agendas);
        return $this->addStatusToAgendas($agendas);
        // return $this->addStatusToAgendas($agendas);
    }

    private function addStatusToAgendas($agendas)
    {
        foreach ($agendas as &$item) {
            $item['status'] = statusRapat($item['tanggal'], $item['jam']);
        }
        return $agendas;
    }

    public function getAgendasWithEditability($agendas)
    {
        foreach ($agendas as &$agenda) {
            $agenda['editable'] = $this->isAgendaEditable($agenda['id_agenda']);
        }
        return $agendas;
    }

    private function isAgendaEditable($agendaId)
    {
        $agenda = $this->find($agendaId);

        $agendaDateTime = new DateTime($agenda['tanggal'] . ' ' . $agenda['jam']);
        $currentDateTime = new DateTime();
        // dd($agendaDateTime, $currentDateTime);

        if ($currentDateTime > $agendaDateTime) {
            // The agenda is not editable if its time has passed
            return true;
        }
        return false;
    }

    // QUERY UNTUK DASHBOARD AGENDA RAPAT SEMUA ROLE
    // function getAgendaByBidang()
    // {
    //     if (session()->get('role') != 'superadmin') {
    //         $builder = $this->table('agendarapats');
    //         $builder->select('agendarapats.*, admins.slug as admin_slug, admins.id_bidang as admin_id_bidang, admins.nama_bidang as admin_nama_bidang');
    //         $builder->join('admins', 'admins.id_admin = agendarapats.id_admin');
    //         if (session()->get('role') == 'admin') {
    //             $builder->where('admins.id_instansi', session()->get('id_instansi'));
    //             $query = $builder->get()->getResultArray();
    //             foreach ($query as &$item) {
    //                 $item['status'] = statusRapat($item['tanggal'], $item['jam']);
    //             }
    //             return $query;
    //         }
    //         $builder->where('admins.id_bidang', session()->get('id_bidang'));
    //         $builder->orWhere('admins.id_bidang IS NULL OR admins.id_bidang = ""');
    //         $query = $builder->get()->getResultArray();
    //         foreach ($query as &$item) {
    //             $item['status'] = statusRapat($item['tanggal'], $item['jam']);
    //         }
    //         return $query;
    //         # code...
    //     } else {
    //         $query = $this->findAll();

    //         // Update the 'status' for each item in the result
    //         foreach ($query as &$item) {
    //             $item['status'] = statusRapat($item['tanggal'], $item['jam']);
    //         }
    //         return $query;
    //     }
    // }

    function getAgendaRapatByIDAdmin()
    {
        $id_admin = session()->get('id_admin');
        $builder = $this->table('agendarapats');
        $builder->select('*');
        $builder->where('id_admin', $id_admin);
        $query = $builder->get()->getResultArray();

        return $query;
    }

    // get agenda rapat by kode_rapat
    function getAgendaRapatByKode($kodeRapat)
    {
        $query = $this->where('kode_rapat', $kodeRapat)->first();
        // dd($query);
        if ($query != null) {
            return $query;
        } else {
            return false;
        }

        return $query;
    }

    // get id agenda sementara
    function getAgendaRapatByIdAgenda($idAgenda)
    {
        $query = $this->where('id_agenda', $idAgenda)->first();
        // dd($query);
        if ($query != null) {
            return $query;
        } else {
            return false;
        }

        return $query;
    }

    // SUPERADMIN 
    // membuat view untuk mengelompokkan id instansi dan nama instansi (SUPER ADMIN)
    function viewAgendaRapatByInstansi()
    {
        $viewName = 'agendarapatbyinstansi';
        $viewExists = $this->db->query("SHOW TABLES LIKE '$viewName'")->getRow();

        if (!$viewExists) {
            $createViewCommand = "CREATE VIEW agendaRapatByInstansi
            AS SELECT id_instansi, nama_instansi
            FROM agendarapats";

            $this->db->query($createViewCommand);
        }

        $builder = $this->table($viewName);
        $builder->groupBy('id_instansi');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // membuat detail view dari fungsi view agenda (mysql view) (SUPER ADMIN)
    function viewDetailAgendaRapatByInstansi($id_instansi)
    {
        $builder = $this->table('agendarapats');
        $builder->select('agendarapats.*, admins.slug as admin_slug, admins.id_bidang as admin_id_bidang, admins.nama_bidang as admin_nama_bidang');
        $builder->join('admins', 'admins.id_admin = agendarapats.id_admin');
        $builder->where('admins.id_instansi', $id_instansi);
        $builder->where("admins.id_bidang IS NOT NULL AND admins.id_bidang != ''"); //exclude the agendas made by admins instansi
        $query = $builder->get()->getResultArray();
        return $this->addStatusToAgendas($query);
    }
    // SUPERADMIN END;

    // get semua angea berdasarkan id_instansi
    function getAllAgendaByInstansi($id_instansi)
    {
        $builder = $this->where('id_instansi', $id_instansi);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // get semua agenda berdasarkan status
    public function getStatusAgenda()
    {
        $agendaItems = $this->findAll(); // Retrieve all agenda items

        $tersediaAgenda = [];
        $selesaiAgenda = [];

        foreach ($agendaItems as $item) {
            $status = statusRapat($item['tanggal'], $item['jam']);

            if ($status === 'tersedia') {
                $tersediaAgenda[] = $item;
            } elseif ($status === 'selesai') {
                $selesaiAgenda[] = $item;
            }
        }

        // Return arrays of filtered agenda items
        return [
            'tersedia' => $tersediaAgenda,
            'selesai' => $selesaiAgenda,
        ];
    }

    // get agenda dengan status tersedia dan selesai berdasarkan id_instansi
    public function getStatusAgendaInstansi($id_instansi)
    {
        $agendaItems = $this->findAll(); // Retrieve all agenda items

        $tersediaAgenda = [];
        $selesaiAgenda = [];

        foreach ($agendaItems as $item) {
            $status = statusRapat($item['tanggal'], $item['jam']);

            if ($status === 'tersedia' && $item['id_instansi'] == $id_instansi) {
                $tersediaAgenda[] = $item;
            } elseif ($status === 'selesai' && $item['id_instansi'] == $id_instansi) {
                $selesaiAgenda[] = $item;
            }
        }

        // Return arrays of filtered agenda items
        return [
            'tersedia' => $tersediaAgenda,
            'selesai' => $selesaiAgenda,
        ];
    }

    // get agendainstansi API untuk mobile app
    public function getAgendaAPI($id_instansi)
    {
        $builder = $this->table('agendarapats');
        $builder->select('agendarapats.*');
        $builder->join('admins', 'admins.id_admin = agendarapats.id_admin');
        $builder->where('admins.id_instansi', $id_instansi);
        $agendas = $builder->get()->getResultArray();
        // $agendas = $this->getAgendasWithEditability($agendas);
        $agendas = $this->addStatusToAgendas($agendas);
        // get the agenda where status avalilable
        $agendas = array_filter($agendas, function ($agenda) {
            return $agenda['status'] == 'tersedia';
        });
        if (empty($agendas)) {
            return null;
            # code...
        } else {
            return $agendas;
        }
    }
}
