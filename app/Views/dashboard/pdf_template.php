
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .tabeldaftarhadir {
            font-size: 10px;
        }

        p {
            font-size: 10px;
            text-align: center;
        }

        td,
        th {
            border: 1px solid #000000;
            text-align: center;
            height: 20px;
            padding: 8px;
        }

        h1 {
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            float: right;
        }

        /* Style for header */
        .table-row {
            font-size: 12px;
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
    <!-- <div class="logo">
        <img width="100" src="assets/img/logo.png" alt="Logo">
    </div> -->
    <!-- <p>
        <i>DaftarHadir</i><br>
        Jl. Pahlawan, Paket Agung, Kec. Buleleng, Kabupaten Buleleng, Bali 81117
    </p>
    <hr> -->
    <h1>DAFTAR HADIR RAPAT<br> <?= strtoupper($agendaRapat['agenda_rapat']) ?></h1>
    <br>
    <table class="table-row">
        <tr>
            <td class="column-label">Program</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['program'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Kegiatan</td>
            <td class="column-divider">:</td>
            <td><?= $agendaRapat['agenda_rapat'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Tanggal</td>
            <td class="column-divider">:</td>
            <td><?= date('d F Y', strtotime($agendaRapat['created_at'])) ?></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellpadding="4" class="tabeldaftarhadir">
        <tr>
            <th class="no-column" width="5%"><strong>No</strong></th>
            <th width="25%"><strong>Nama</strong></th>
            <th width="40%"><strong>Instansi</strong></th>
            <th width="15%"><strong>No HP</strong></th>
            <th width="14%"><strong>Tanda Tangan</strong></th>
        </tr>
        <?php $no = 1; ?>
        <?php foreach ($daftarHadir as $item) : ?>
            <tr>
                <td class="no-column"><?= $no++ ?></td>
                <td><?= $item['nama'] ?></td>
                <td><?= $item['asal_instansi'] ?></td>
                <td><?= $item['no_hp'] ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>




