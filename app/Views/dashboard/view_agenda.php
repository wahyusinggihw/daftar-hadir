<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

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
                        <dt class="col-sm-4">Agenda Rapat</dt>
                        <dd class="col-sm-8"><?= $data['agenda_rapat'] ?></dd>
                        <dt class="col-sm-4">Tempat</dt>
                        <dd class="col-sm-8"><?= $data['tempat'] ?></dd>
                        <dt class="col-sm-4">Tanggal</dt>
                        <dd class="col-sm-8"><?= $data['tanggal'] ?></dd>
                        <dt class="col-sm-4">Jam</dt>
                        <dd class="col-sm-8"><?= $data['jam'] ?></dd>
                        <dt class="col-sm-4">Deskripsi</dt>
                        <dd class="col-sm-8 text-justify"><?= $data['deskripsi'] ?></dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-5 col-sm-4 d-flex align-items-center justify-content-center mx-auto">
                <div class="card-body">
                    <div class="col">
                        <div class="col mb-2">
                            <img id="qr" class="img-fluid" src="<?= $qrCode ?>" alt="<?= $data['kode_rapat'] ?>">
                        </div>
                        <div class="col">
                            <div class="row mb-2">
                                <a href="#" data-kode="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" id="salin-kode" class="text-center focus-ring py-1 px-2 text-decoration-none border rounded-2">
                                    Salin informasi rapat
                                </a>
                            </div>
                            <div class="row mb-2">
                                <a href="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" class="btn btn-primary" target="_blank">Tampilkan Informasi rapat</a>
                            </div>
                        </div>
                    </div>
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