<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Meeting Check <?php isset($title) ? print('- ' . $title) : '' ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/informasi.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="informasi">
        <header>
            <div class="container">
                <div class="logo">
                    <a href="/">
                        <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Logo" width="100">
                    </a>
                </div>
            </div>
        </header>
        <div class="container-info">
            <div class="card-info">
                <div class="card-qr">
                    <img src="<?= $qrCode ?>" alt="Logo">
                </div>

                <div class="card-text">
                    <h1>INFORMASI RAPAT</h1>
                    <ul>
                        <li><?= $agendaRapat['agenda_rapat'] ?></li>
                        <li><?= $agendaRapat['nama_instansi'] ?></li>
                    </ul>
                    <div class="code-rapat">
                        KODE RAPAT : <p id="teksToSalin" onclick="copyText()"><?= $agendaRapat['kode_rapat'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-footer">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">© 2023 Dinas Kominfosanti</span>
            </div>

            <ul class="nav me-md-5 col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fa-brands fa-twitter"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fa-brands fa-square-instagram"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><i class="fa-brands fa-facebook"></i></a></li>
            </ul>
        </footer>
    </div>
</body>

<script src="<?php echo base_url('assets/js/info.js'); ?>"></script>

</html>