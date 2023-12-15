<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/informasi.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<body style="background-image:url(<?= base_url('assets/img/bg_home.png') ?>);">
    <!-- Modal -->
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>',
            })
        </script>

    <?php endif; ?>

    <div class="card-info">
        <div class="content-wrapper">
            <div class="card-text">
                <h1><?= $agendaRapat['agenda_rapat'] ?></h1>
                <ul>
                    <li><?= $agendaRapat['nama_instansi'] ?></li>
                    <!-- <li><?= $agendaRapat['nama_bidang'] ?></li> -->
                </ul>
                <div class="card-qr">
                    <img src="<?= $qrCode ?>" alt="Logo">
                </div>
                <div class="code-rapat">
                    <p id="teksToSalin" onclick="copyText()"><?= $agendaRapat['kode_rapat'] ?></p>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="<?php echo base_url('assets/js/info.js'); ?>"></script>

<?= $this->endSection() ?>