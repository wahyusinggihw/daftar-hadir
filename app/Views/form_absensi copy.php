<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<body>
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error') ?>',
            })
        </script>
    <?php endif; ?>

    <div class="konten">
        <div class="judul-form">
            <h1>Form Daftar Hadir</h1>
            <h2>Lengkapi data berikut</h2>
        </div>
        <div class="wrapper">
            <div class="text-center">
                <h3><?= isset($rapat['agenda_rapat']) ? $rapat['agenda_rapat'] : 'Rapat'  ?></h3>
                <h4>Isi sesuai dengan data diri anda</h4>
            </div>
            <form action="<?= base_url('/submit-kode/form-absensi/store') ?>" method="post" id="form-absensi" name="form-absensi" enctype="multipart/form-data" onsubmit="return validateRecaptcha()">
                <?= csrf_field() ?>

                <?php
                // Capture the old value of the status radio input
                $oldStatusValue = old('statusRadio');
                $oldAsnNonAsnValue = old('asnNonAsnRadio');
                ?>

                <div class="form-input">
                    <div class="form-group mb-2 mt-4">
                        <label class="form-label">Pilih Status</label>
                        <div class="radio">
                            <div id="radio-op" class="form-check form-check-inline">
                                <input class="form-check-input statusRadio" type="radio" name="statusRadio" id="statusRadio1" value="pegawai" <?php if ($oldStatusValue === 'pegawai') echo 'checked'; ?>>
                                <label class="form-check-label" for="statusRadio1">Pegawai</label>
                            </div>
                            <div id="radio-op" class="form-check form-check-inline">
                                <input class="form-check-input statusRadio" type="radio" name="statusRadio" id="statusRadio2" value="tamu" <?php if ($oldStatusValue === 'tamu') echo 'checked'; ?>>
                                <label class="form-check-label" for="statusRadio2">Tamu</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-input">
                    <div class="form-group mb-2 mt-2" id="asnNonAsnContainer" style="display: none;">
                        <label class="form-label">Pilih status pegawai</label>
                        <div class="radio">
                            <div id="radio-op" class="form-check form-check-inline">
                                <input class="form-check-input asnNonAsnRadio" type="radio" name="asnNonAsnRadio" id="asnRadio" value="asn" <?php if ($oldAsnNonAsnValue === 'asn') echo 'checked'; ?>>
                                <label class="form-check-label" for="asnRadio">ASN</label>
                            </div>
                            <div id="radio-op" class="form-check form-check-inline">
                                <input class="form-check-input asnNonAsnRadio" type="radio" name="asnNonAsnRadio" id="nonAsnRadio" value="nonasn" <?php if ($oldAsnNonAsnValue === 'nonasn') echo 'checked'; ?>>
                                <label class="form-check-label" for="nonAsnRadio">Non-ASN</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-input">
                    <div class="form-group mb-2">
                        <div class="row">
                            <label style="display: none;" for="nip" class="form-label" id="label-nik">NIK</label>
                            <label style="display: none;" for="nip" class="form-label" id="label-default">NIP</label>
                            <div class="col">
                                <input type="text" class="form-control <?= validation_show_error('nip') ? 'is-invalid' : '' ?>" value="<?= old('nip') ?>" id="nip" name="nip">
                                <div id="notif" class="invalid-feedback text-start">
                                    <?= validation_show_error('nip') ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex align-items-center">
                                    <div style="display: none; width:30px; height:30px;" class="spinner-border" role="status" id="loadingIndicator">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <!-- <div style="display: none;" id="loadingIndicator" class="col"><img width="25" src="<?= base_url('assets/img/loading.gif') ?>" alt="Loading..."></div> -->
                                    <a style="display: none;" id="cariNikButton" class="cari btn btn-primary col">Cari</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-form">
                    <div class="form-input">
                        <div class="form-group-1 mb-2">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control  <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>" id="nama" name="nama" placeholder=" ">
                            <div class="invalid-feedback text-start">
                                <?= validation_show_error('nama') ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-input">
                        <div class="form-group-1 mb-2">
                            <label for="no_hp" class="form-label">No. Handphone</label>
                            <input type="tel" class="form-control  <?= validation_show_error('no_hp') ? 'is-invalid' : '' ?>" value="<?= old('no_hp') ?>" id="no_hp" name="no_hp" placeholder=" ">
                            <div class="invalid-feedback text-start">
                                <?= validation_show_error('no_hp') ?>
                            </div>
                        </div>
                    </div>


                    <div class="form-input">
                        <div class="form-group-1 mb-2">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control  <?= validation_show_error('alamat') ? 'is-invalid' : '' ?>" value="<?= old('alamat') ?>" id="alamat" name="alamat" placeholder=" ">
                            <div class="invalid-feedback text-start">
                                <?= validation_show_error('alamat') ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-input">
                        <div class="form-group-1 mb-2" id="instansiText" style="display: none;">
                            <label for="asal_instansi_tamu" class="form-label">Asal Instansi</label>
                            <input type="text" class="form-control  <?= validation_show_error('asal_instansi_tamu') ? 'is-invalid' : '' ?>" value="<?= old('asal_instansi_tamu') ?>" id="asal_instansi_tamu" name="asal_instansi_tamu" placeholder=" ">
                            <div class="invalid-feedback">
                                <?= validation_show_error('asal_instansi_tamu') ?>
                            </div>
                        </div>


                        <!-- <div class="form-input"> -->
                        <!-- radio select peran -->
                        <div class="form-group-1 mb-2" id="instansiOption">
                            <label for="asal_instansi_option" class="form-label">Asal Instansi</label>
                            <!-- <input type="text" class="form-control" id=" " placeholder=" "> -->
                            <select name="asal_instansi_option" id="asal_instansi_option" class="form-select <?= validation_show_error('asal_instansi_option') ? 'is-invalid' : '' ?>">
                                <option value="">Pilih instansi</option>
                                <?php foreach ($instansi->data as $i) : ?>
                                    <?php $selected = old('asal_instansi_option') == $i->ket_ukerja ? 'selected' : ''; ?>
                                    <option value="<?= $i->ket_ukerja ?>" <?= $selected ?>><?= $i->ket_ukerja ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback text-start">
                                <?= validation_show_error('asal_instansi_option') ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-input-sg">
                        <div class="signature-pad <?= validation_show_error('signatureData') ? 'is-invalid' : '' ?>">
                            <h1>Tempat Tanda Tangan</h1>
                            <canvas id="signatureCanvas" class="signature-canvas" width="600" height="400"></canvas>
                            <input type="hidden" id="signatureData" name="signatureData" value="">
                            <div class="button-container mb-2">
                                <a type="button" onclick="clearSignature()" class="signature-button btn btn-sm btn-danger">Ulangi Tanda Tangan</a>
                            </div>
                        </div>
                        <div class="invalid-feedback text-start">
                            <?= validation_show_error('signatureData') ?>
                        </div>

                        <div class="button-function">
                            <input type="hidden" name="kode_rapat" value="<?= session()->get('kode_valid') ?>">

                            <div class="form-group text-end">
                                <div class="g-recaptcha" data-sitekey="<?= env('RECAPTCHA_SITE_KEY_V2') ?>"></div>
                                <button onclick="saveSignature()" type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function validateRecaptcha() {
            // Use the grecaptcha object to check if the user has checked the reCAPTCHA.
            var recaptchaResponse = grecaptcha.getResponse();
            var recaptchaErrorElement = document.getElementById("recaptcha-error");

            if (recaptchaResponse.length === 0) {
                // User hasn't checked the reCAPTCHA, display an error message.
                recaptchaErrorElement.textContent = "Mohon centang reCAPTCHA.";
                return false;
            }

            // User has checked the reCAPTCHA, clear the error message and continue with form submission.
            recaptchaErrorElement.textContent = "";
            return true;
        }
    </script>

    <script>
        // if on error
        /**
         * This code block checks the value of the 'asnNonAsnRadio' input field and shows/hides the appropriate container based on the value.
         * If the value is 'asn' or 'nonasn', the '#asnNonAsnContainer' is shown.
         * If the value is anything else, the '#instansiText' is shown and the '#instansiOption' is hidden.
         */
        var oldAsnNonAsnValue = '<?= old('asnNonAsnRadio') ?>';
        if (oldAsnNonAsnValue === 'asn' || oldAsnNonAsnValue === 'nonasn') {
            $('#asnNonAsnContainer').show();
        } else {
            $('#instansiText').show();
            $('#instansiOption').hide();
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/signature.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/form-absensi.js') ?>"></script>

    <style>
        .disabled-button {
            pointer-events: none;
            /* Prevents the anchor from being clickable */
            opacity: 0.6;
            /* Reduces the opacity to visually indicate it's disabled */
        }

        .greyed-out-form {
            background-color: #f0f0f0;
            /* Change the background color to grey */
            pointer-events: none;
            /* Prevents interactions with the form */
        }
    </style>

</body>



<?= $this->endSection() ?>