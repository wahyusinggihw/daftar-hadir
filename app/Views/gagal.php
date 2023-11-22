<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<body>
    <div class="container my-5">
        <div class="row justify-content-center align-items-center text-center">
            <div class="animate__animated animate__tada animate__repeat-2">
                <div class="d-flex align-items-center justify-content-center flex-column mt-4">
                    <i class="fa-regular fa-circle-xmark fa-4x text-danger"></i>
                    <h1 class="h5 mb-3 fw-normal">
                        <div class="fs-4">Gagal</div>
                    </h1>
                </div>
            </div>
            <div class="mb-3 fs-5"><?= session()->getFlashdata('error') ?></div>
            <!-- <div class="mb-3 fs-6">Anda akan diarahkan ke halaman utama dalam <span id="countdown"></span> detik</div> -->
            <div><small id="countdown" class="mb-3 fs-6"></small></div>
        </div>
        <a href="<?= base_url() ?>" class="btn btn-secondary my-2">Lanjutkan</a>
    </div>

    <script>
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
    </script>
</body>

<?= $this->endSection() ?>