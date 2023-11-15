<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/informasi.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<body style="background-image:url(<?= base_url('assets/img/kota.png') ?>);">
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
        <div class="content-timeline">
            <ul class="timeline">
                <li>
                    <div class="item">
                        <span>1</span>
                        <div class="content">
                            <h3>Masukkan Kode Rapat</h3>
                            <p>Silahkan masukkan kode rapat yang sudah diberikan di kolom diatas, lalu tekan "Masuk". Atau</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <span>2</span>
                        <div class="content">
                            <h3>Masuk Dengan Qr Code</h3>
                            <p>Cara lain untuk memasuki rapat adalah dengan memindai kode QR yang sudah diberikan oleh admin rapat.</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <span>3</span>
                        <div class="content">
                            <h3>Memilih Status</h3>
                            <p>Jika sudah berhasil maka silahkan anda memilih sebagai tamu atau pegawai. Jika sebagai pegawai silahkan di pilih apakah anda "ASN" atau "non-ASN", Namun jika sebagai tamu silahkan di pilih "tamu".</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <span>4</span>
                        <div class="content">
                            <h3>Mengisi Formulir</h3>
                            <p>
                                Jika sebagai pegawai cukup isikan NIP atau NIPT, lalu tekan "Cari" dan tanda tangan. Sedangkan untuk tamu jika baru pertama anda bisa isi semua biodata anda pada formulir yang sudah di sediakan, jika NIK kalian sudah terdaftar
                                silahkan tekan "Cari" lalu lanjutkan mengisi tanda tangan.
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item">
                        <span>5</span>
                        <div class="content">
                            <h3>Mengisi Formulir</h3>
                            <p>
                                Jika sebagai pegawai cukup isikan NIP atau NIPT, lalu tekan "Cari" dan tanda tangan. Sedangkan untuk tamu jika baru pertama anda bisa isi semua biodata anda pada formulir yang sudah di sediakan, jika NIK kalian sudah terdaftar
                                silahkan tekan "Cari" lalu lanjutkan mengisi tanda tangan.
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-wrapper">
            <div class="card-text">
                <h1><?= $agendaRapat['agenda_rapat'] ?>s</h1>
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