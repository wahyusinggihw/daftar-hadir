<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <!-- <div class="card card-info">
        <div class="card-body">
            <form action="#" method="#">
                <?= csrf_field() ?>
                <input type="hidden" id="text" name="id_agenda" value="<?= $data['id_agenda'] ?>">
                <div class="row">
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Agenda Rapat</label>
                            <input disabled type="text" class="form-control <?= validation_show_error('agenda_rapat') ? 'is-invalid' : '' ?>" value="<?= old('agenda_rapat', $data['agenda_rapat']) ?>" id="agenda_rapat" name="agenda_rapat">
                            <div class="invalid-feedback">
                                <?= validation_show_error('agenda_rapat') ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Tempat Rapat</label>
                            <input disabled type="text" class="form-control <?= validation_show_error('tempat') ? 'is-invalid' : '' ?>" value="<?= old('tempat', $data['tempat']) ?>" id="tempat" name="tempat">
                            <div class="invalid-feedback">
                                <?= validation_show_error('tempat') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Tanggal</label>
                            <input disabled type="date" class="form-control <?= validation_show_error('tanggal') ? 'is-invalid' : '' ?>" value="<?= old('tanggal', $data['tanggal']) ?>" id="tanggal" name="tanggal">
                            <div class="invalid-feedback">
                                <?= validation_show_error('tanggal') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Jam</label>
                            <input disabled class="timepicker form-control <?= validation_show_error('jam') ? 'is-invalid' : '' ?>" value="<?= old('jam', $data['jam']) ?>" id="jam" name="jam">
                            <div class="invalid-feedback">
                                <?= validation_show_error('jam') ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Agenda Rapat</label>
                        <textarea disabled class="form-control <?= validation_show_error('deskripsi') ? 'is-invalid' : '' ?>" rows="3" id="deskripsi" name="deskripsi"><?= old('deskripsi', $data['deskripsi']) ?></textarea>
                        <div class="invalid-feedback">
                            <?= validation_show_error('deskripsi') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qr">Link Rapat:</label>
                        <div class="container mb-3">
                            <div class="row">
                                <div class="col">

                                    <img id="qr" width="100px" src="<?= $qrCode ?>" alt="" class="">
                                </div>

                                <div class="col">
                                    <div class="row mb-4">
                                        <a href="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" class="btn btn-primary" target="_blank">Informasi rapat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div> -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa-solid fa-circle-info" style="color: #000000;"></i>
                Informasi Agenda
            </h3>
        </div>
        <div class="d-flex">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Agenda Rapat</dt>
                    <dd class="col-sm-8"><?= old('agenda_rapat', $data['agenda_rapat']) ?></dd>
                    <dt class="col-sm-4">Tempat</dt>
                    <dd class="col-sm-8"><?= old('tempat', $data['tempat']) ?></dd>
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8"><?= old('tanggal', $data['tanggal']) ?></dd>
                    <dt class="col-sm-4">Jam</dt>
                    <dd class="col-sm-8"><?= old('jam', $data['jam']) ?></dd>
                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8"><?= old('deskripsi', $data['deskripsi']) ?></dd>
                </dl>
            </div>
            <div class="card-body">
                <div class="col">
                    <div class="col">

                        <img id="qr" width="300px" src="<?= $qrCode ?>" alt="" class="">
                    </div>

                    <div class="col">
                        <div class="row mb-2">
                            <a href="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" class="btn   btn-primary" target="_blank">Tampilkan Informasi rapat</a>
                        </div>
                        <div class="row mb-2">
                            <a href="<?= base_url('rapat/informasi/' . $data['kode_rapat']) ?>" class="btn btn-primary" target="_blank">Salin link Rapat</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
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