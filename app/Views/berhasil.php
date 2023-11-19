<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center align-items-center text-center">
            <div class="animate__animated animate__tada animate__repeat-2">
                <div class="d-flex align-items-center justify-content-center flex-column mt-4">
                    <i class="fa-regular fa-circle-check fa-4x text-success"></i>
                    <h1 class="h5 mb-3 fw-normal">
                        <div class="fs-4">Berhasil</div>
                    </h1>
                </div>
            </div>
            <div class="mb-3 fs-5"><?= session()->getFlashdata('success') ?></div>
            <div class="mb-3 fs-6">Anda akan diarahkan ke halaman utama dalam <span id="countdown"></span> detik</div>
        </div>
        <a href="<?= base_url() ?>" class="btn btn-secondary my-2">Lanjutkan</a>
    </div>

    <script>
        var count = 5;
        var countdownElement = document.getElementById("countdown");
        var countdownInterval = setInterval(function() {
            countdownElement.innerHTML = count;
            count--;
            if (count < 0) {
                // clearInterval(countdownInterval);
                // window.location.href = "<?= base_url() ?>";
                // countdownElement.innerHTML = "";
            }
        }, 1000);
    </script>
</body>

<?= $this->endSection() ?>