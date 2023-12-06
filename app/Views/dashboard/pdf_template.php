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

        /* p {
            font-size: 10px;
            text-align: center;
        } */

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

        .header {
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header .judul {
            font-size: 14px;
        }

        .logo {
            float: right;
        }

        /* Style for header */
        .table-row {
            font-size: 10px;
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


        .tanda-tangan p {
            text-align: center;
            margin: 5px 0;
            font-size: 10px;
            /* Align text within paragraphs to the right */
        }

        .tanda-tangan {
            margin-top: 100px;
            /* Align text to the right within the container */
            display: flex;
            flex-direction: column;
            /* Stack child elements vertically */
            align-items: flex-end;
            /* Align children to the right end */
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
    <p class="header"><strong>DAFTAR HADIR RAPAT</strong><br> <span class="judul"><?= $agendaRapat['agenda_rapat'] ?></span></p>
    <br>
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
            <td><?= $agendaRapat['deskripsi'] ?></td>
        </tr>
        <tr>
            <td class="column-label">Hari/Tanggal</td>
            <td class="column-divider">:</td>
            <?php setlocale(LC_TIME, 'id_ID'); ?>
            <td><?= format_indo(date($agendaRapat['tanggal'])) ?></td>
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
                <td><img src="<?= $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace(base_url(), '', $item['ttd']) ?>" alt="ttd <?= $item['nama'] ?>" srcset=""></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- signature section -->
    <div class="tanda-tangan">
        <p>Mengetahui : <br><span>Pejabat Pelaksana Teknis Kegiatan</span></p>
        <br>
        <br>
        <p><strong style="text-decoration: underline;"><?= $bidangInstansi['nama_kepala_bidang'] ?></strong><br><span>NIP. <?= $bidangInstansi['nip_kepala_bidang'] ?></span></p>
    </div>

</body>

</html>