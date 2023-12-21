<?= $this->include('public/templates/header') ?>

<body>
    <div class="section-content">
        <div class="container-lg container-form">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8 col-xxl-8 shadow-lg p-3">
                    <div class="title-judul-form">
                        <?= $agendaRapat['agenda_rapat'] ?>
                    </div>
                    <div class="mb-4">Terimakasih sudah melakukan presensi pada aplikasi yang kami sediakan, selamat mengikuti
                        kegiatan Rapat
                        <?= $agendaRapat['agenda_rapat'] ?>
                    </div>
                    <dl class="row">
                        <dt class="col-md-3">Status</dt>
                        <dd class="col-md-9"><?= $daftarHadir['status'] ?></dd>

                        <dt class="col-md-3">Status Pegawai</dt>
                        <dd class="col-md-9">ASN</dd>

                        <dt class="col-md-3">Nama Lengkap</dt>
                        <dd class="col-md-9"><?= $daftarHadir['nama'] ?></dd>

                        <dt class="col-md-3">Nomor HP</dt>
                        <dd class="col-md-9"><?= $daftarHadir['no_hp'] ?></dd>

                        <dt class="col-md-3">Asal Instansi</dt>
                        <dd class="col-md-9"><?= $daftarHadir['asal_instansi'] ?></dd>

                        <dt class="col-md-3">Tanda Tangan</dt>
                        <dd class="col-md-9"><img src="<?= $daftarHadir['ttd'] ?>" alt="ttd <?= $daftarHadir['nama'] ?>" width="350px"></dd>
                    </dl>
                    <div class="mb-3">
                        <div class="bs-callout bs-callout-success">
                            Data presensi anda berhasil disimpan.
                        </div>
                    </div>
                    <div class="mt-5 mb-3 text-center">
                        <a href="<?= base_url() ?>" class="btn btn-secondary my-2">Lanjutkan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
        var count = 5;
        var countdownElement = document.getElementById("countdown");
        var countdownInterval = setInterval(function() {
            countdownElement.innerHTML = "Anda akan diarahkan ke halaman utama dalam " + count + " detik";
            count--;
            if (count < 0) {
                clearInterval(countdownInterval);
                countdownElement.innerHTML = "Memuat...";
                window.location.href = "<?= base_url() ?>";
                // countdownElement.innerHTML = "";
            }
        }, 1000);
    </script> -->
</body>

<?= $this->include('public/templates/footer') ?>