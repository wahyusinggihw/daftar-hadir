<?= $this->include('public/templates/header'); ?>

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

    <div class="section-content d-flex align-items-center">
        <div class="container-lg container-qrcode">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 d-flex align-items-lg-center order-2 order-md-1">
                    <div>
                        <div class="title-rapat"><?= $agendaRapat['agenda_rapat'] ?>
                        </div>
                        <dl class="row description-list">
                            <dt class="col-xl-3">Program</dt>
                            <dd class="col-xl-9"><?= $agendaRapat['program'] ?>
                            </dd>
                            <dt class="col-xl-3">Kegiatan</dt>
                            <dd class="col-xl-9"><?= $agendaRapat['deskripsi'] ?>
                            </dd>
                            <dt class="col-xl-3">Tanggal</dt>
                            <dd class="col-xl-9"><?= format_indo(date($agendaRapat['tanggal'])) ?></dd>
                            <dt class="col-xl-3">Kode Rapat</dt>
                            <dd class="col-xl-9 kode-rapat">
                                <p id="teksToSalin" onclick="copyText()"><?= $agendaRapat['kode_rapat'] ?></p>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 text-center order-1 order-md-2">
                    <div class="title-scan">Pindai Saya</div>
                    <div>
                        <img src="<?= $qrCode ?>" alt="Logo" width="350px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?= $this->include('public/templates/footer'); ?>