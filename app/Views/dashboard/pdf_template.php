<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: center;
            height: 20px;
            margin: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            float: right;
        }

        /* Style for header */
        .table-row {
            border-collapse: collapse;
            width: 100%;
        }

        .table-row td {
            padding: 5px;
            text-align: left;
            border: none;
        }

        .table-row .column-label {
            width: 100px;
        }

        .table-row .column-divider {
            width: 30px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img width="100" src="assets/img/logo.png" alt="Logo">
    </div>
    <p>
        <i>DaftarHadir</i><br>
        Jl. Pahlawan, Paket Agung, Kec. Buleleng, Kabupaten Buleleng, Bali 81117
    </p>
    <hr>
    <h1>DAFTAR HADIR<br>RAPAT <?= strtoupper($agendaRapat['agenda_rapat']) ?></h1>
    <table class="table-row">
        <tr>
            <td class="column-label">Kode Rapat</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['kode_rapat'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Agenda Rapat</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['agenda_rapat'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Instansi</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['nama_instansi'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Bidang</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['nama_bidang'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Tanggal</td>
            <td class="column-divider">:</td>
            <td><?= date('Y-m-d', strtotime($agendaRapat['created_at'])) ?></td>
        </tr>
        <tr>
            <td class="column-label">Pukul</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['jam'] ?></td>
        </tr>
    </table>
    </p>

    <table cellpadding="6">
        <tr>
            <th><strong>NIP/NIK</strong></th>
            <th><strong>Nama</strong></th>
            <th><strong>Asal Instansi</strong></th>
            <th><strong>Tanggal/Jam Absen</strong></th>
        </tr>
        <?php foreach ($daftarHadir as $item) : ?>
            <tr>
                <td><?= $item['NIK'] ?></td>
                <td><?= $item['nama'] ?></td>
                <td><?= $item['asal_instansi'] ?></td>
                <td><?= date('Y-m-d', strtotime($item['created_at'])) . '/' . date('H:i', strtotime($item['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>