<?= $this->include('public/templates/header') ?>

<body>
    <div class="section-content">
        <div class="container-lg container-notif">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-9 col-xl-8 col-xxl-8 shadow-lg p-3">
                    <div class="title-judul-form">
                        <?= $agendaRapat['agenda_rapat'] ?>
                    </div>
                    <div class="text-center">
                        <i style="color: #dc3545;" class="fa-regular fa-circle-xmark icon-selesai"></i>
                    </div>
                    <div class="mt-4 mb-4 text-center">
                        Anda sudah mengisi presensi untuk kegiatan ini
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
            // countdownElement.innerHTML = count;
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