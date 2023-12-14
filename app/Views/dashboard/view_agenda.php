<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('head') ?>
<meta charset="UTF-8">
<meta name="description" content="Informasi Rapat">
<meta property="og:title" content="<?= $data['agenda_rapat'] ?>">
<meta property="og:description" content="<?= $data['deskripsi'] ?>">
<meta property="og:image" content="<?= $qrCode ?>">
<meta property="og:url" content="<?= $data['link_rapat'] ?>">
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<body>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa-solid fa-circle-info" style="color: #000000;"></i>
                Informasi Agenda
            </h3>
        </div>
        <div class="row g-0">
            <div class="col-md-7 col-md-7">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Judul</dt>
                        <dd class="col-sm-8"><?= $data['agenda_rapat'] ?></dd>
                        <dt class="col-sm-4">Program</dt>
                        <dd class="col-sm-8"><?= $data['program'] ?></dd>
                        <dt class="col-sm-4">Kegiatan</dt>
                        <dd class="col-sm-8"><?= $data['deskripsi'] ?></dd>
                        <dt class="col-sm-4">Tanggal/Jam</dt>
                        <dd class="col-sm-8"><?= $data['jam'] ?></dd>
                        <dt class="col-sm-4">Jumlah Kehadiran</dt>
                        <dd class="col-sm-8"><?= $jumlahKehadiran ?></dd>
                        <?php if ($status == 'tersedia') : ?>
                            <dt class="col-sm-4"></dt>
                            <dd class="col-sm-8 text-justify">
                                <div class="col d-flex justify-content-right">
                                    <div class="row mb-2">
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode('Informasi Rapat: ' . base_url('rapat/informasi/' . $data['kode_rapat'])) ?>" role="bt" class="btn btn-outline-info" target="_blank"><i class="fa-brands fa-whatsapp fa-xl"></i></a>
                                    </div>
                                    <div class="row mb-2 ms-4">
                                        <button data-kode="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" id="salin-kode" class="btn btn-outline-info"><i class="fa-solid fa-copy"></i></button>
                                    </div>
                                    <div class="row mb-2 ms-4">
                                        <a href="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" class="btn btn-outline-info" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                    </div>
                                </div>
                            </dd>
                        <?php endif; ?>
                    </dl>
                </div>

            </div>
            <div class="col-md-5 col-sm-4 d-flex align-items-center justify-content-center mx-auto">
                <div class="card-body">
                    <?php if ($status == 'tersedia') : ?>
                        <div class="col">
                            <div class="col mb-2">
                                <img id="qr" class="img-fluid" src="<?= $qrCode ?>" alt="<?= $data['kode_rapat'] ?>">
                            </div>
                            <div class="col code-rapat">
                                <p id="teksToSalin" onclick="copyText()"><?= $data['kode_rapat'] ?></p>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>


    <script>
        salinKode = document.getElementById('salin-kode');
        const kodeRapat = salinKode.getAttribute('data-kode');
        salinKode.addEventListener('click', function() {
            navigator.clipboard.writeText(kodeRapat);
            $('#salin-kode').removeClass('focus-ring');
            $('#salin-kode').text('Berhasil disalin');
            showSuccessNotification('Informasi rapat berhasil disalin');
        });

        function showSuccessNotification(title) {
            let timerInterval
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: title,
                toast: true,
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }), then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        }
        // Function to customize print settings
        document.getElementById("printButton").addEventListener("click", function() {
            // Set a custom document title for printing
            const printCSS = document.createElement('link');
            const judul = this.getAttribute("data-judul");
            document.title = judul;
            window.print();
        });

        $('.timepicker').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            // defaultTime: '6',
            dynamic: true,
            dropdown: true,
        });
    </script>
</body>

<?= $this->endSection() ?>