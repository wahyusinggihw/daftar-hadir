<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/formabsensi.css') ?>">
<?= $this->endSection(); ?>

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

    <section class="container">
        <header><?= isset($rapat['agenda_rapat']) ? $rapat['agenda_rapat'] : 'Rapat'  ?></header>
        <p>Isi sesuai dengan data diri anda</p>
        <form action="<?= base_url('/rapat/daftar-hadir/store') ?>" method="post" enctype="multipart/form-data" class="form" onsubmit="return validateRecaptcha()">
            <?= csrf_field() ?>
            <?php
            // Capture the old value of the status radio input
            $oldStatusValue = old('statusRadio');
            if ($oldStatusValue != 'tamu') {
                $oldAsnNonAsnValue = '';
            }
            $oldAsnNonAsnValue = old('asnNonAsnRadio');
            // d(validation_list_errors());
            ?>
            <input type="hidden" name="id_agenda" id="id_agenda" value="<?= $rapat['id_agenda'] ?>">
            <input type="hidden" name="kode_rapat" id="kode_rapat" value="<?= $rapat['kode_rapat'] ?>">

            <div class="status-box">
                <h3>Pilih Status</h3>
                <div class="status-option">
                    <div class="status">
                        <input class="statusRadio" name="statusRadio" type="radio" id="statusRadio1" value="pegawai" <?php if ($oldStatusValue === 'pegawai') echo 'checked'; ?> />
                        <label class="statusRadio-label" for="statusRadio1">Pegawai</label>
                    </div>
                    <div class="status">
                        <input class="statusRadio" name="statusRadio" type="radio" id="statusRadio2" value="tamu" <?php if ($oldStatusValue === 'tamu') echo 'checked'; ?> />
                        <label class="statusRadio-label" for="statusRadio2">Tamu</label>
                    </div>
                </div>
                <div class="invalid-response">
                    <?= validation_show_error('statusRadio') ?>
                </div>
            </div>
            <div class="status-box" id="asnNonAsnContainer" style="display: none;">
                <h3>Pilih Status Pegawai</h3>
                <div class="status-option">
                    <div class="status">
                        <input class="asnNonAsnRadio" type="radio" id="asnRadio" name="asnNonAsnRadio" value="asn" <?php if ($oldAsnNonAsnValue === 'asn') echo 'checked'; ?> />
                        <label for="asnRadio">ASN</label>
                    </div>
                    <div class="status">
                        <input class="asnNonAsnRadio" type="radio" id="nonAsnRadio" name="asnNonAsnRadio" value="nonasn" <?php if ($oldAsnNonAsnValue === 'nonasn') echo 'checked'; ?> />
                        <label for="nonAsnRadio">Non-ASN</label>
                    </div>
                </div>
                <div class="invalid-response">
                    <?= validation_show_error('asnNonAsnRadio') ?>
                </div>
            </div>

            <!-- 
                    #loadingIndicator 
                    -pada tamu
                    akan muncul jika user mengetikkan nik

                    -pada pegawai
                    akan muncul jika user klik tombol cari
                 -->
            <div class="inputcontainer">
                <label style="display: none;" for="nip" class="form-label" id="label-nik">NIK</label>
                <label style="display: none;" for="nip" class="form-label" id="label-default">NIP</label>
                <div class="search <?= validation_show_error('nip') ? 'invalid-input' : '' ?>" id="search">
                    <input value="<?= old('nip') ?>" type="text" placeholder="Masukkan NIP" id="nip" name="nip" inputmode="numeric" />
                    <a style="display: none;" class="cari" id="cariNikButton"><i class="fa fa-search"></i></a>
                    <i style="display: none;" id="loadingIndicator" class="fa fa-circle-o-notch fa-spin"></i>
                </div>
                <div class="note">
                    <p><strong>Info!</strong> Tanda tangani formulir ini jika Anda telah mengisi sebelumnya. Jika ini pertama kalinya, lengkapi biodata dengan cermat.</p>
                </div>
                <div class="invalid-response">
                    <?= validation_show_error('nip') ?>
                </div>
                <!-- Tombol cari yang dimodifikasi menggunakan tag a untuk melakukan ajax request(isi data otomatis), karena dalam 1 form hanya bisa 1 tombol yakni tombol kirim (yang dibawah) -->
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="nama">Nama Lengkap</label>
                    <input class="<?= validation_show_error('nama') ? 'invalid-input' : '' ?>" value="<?= old('nama') ?>" type="text" placeholder="Masukkan Nama Lengkap" id="nama" name="nama" />
                    <div class="invalid-response">
                        <?= validation_show_error('nama') ?>
                    </div>
                </div>
                <div class="input-box">
                    <label for="no_hp">No. Handphone</label>
                    <input class="<?= validation_show_error('no_hp') ? 'invalid-input' : '' ?>" value="<?= old('no_hp') ?>" type="text" placeholder="Masukkan No. Handphone" id="no_hp" name="no_hp" />
                    <div class="invalid-response">
                        <?= validation_show_error('no_hp') ?>
                    </div>
                </div>
            </div>

            <div class="column">
                <div class="input-box">
                    <label for="alamat">Alamat</label>
                    <input class="<?= validation_show_error('alamat') ? 'invalid-input' : '' ?>" value="<?= old('alamat') ?>" type="text" placeholder="Masukkan Alamat" id="alamat" name="alamat" />
                    <div class="invalid-response">
                        <?= validation_show_error('alamat') ?>
                    </div>
                </div>
                <div class="input-box" id="instansiText" style="display: none;">
                    <label for=" asal_instansi_tamu">Asal Instansi</label>
                    <input class="<?= validation_show_error('asal_instansi_tamu') ? 'invalid-input' : '' ?>" value="<?= old('asal_instansi_tamu') ?>" type="text" placeholder="Masukkan Asal Instansi" id="asal_instansi_tamu" name="asal_instansi_tamu" />
                    <div class="invalid-response">
                        <?= validation_show_error('asal_instansi_tamu') ?>
                    </div>
                </div>
                <!-- option -->
                <div class="input-box" id="instansiOption">
                    <label for="asal_instansi_option">Asal Instansi</label>
                    <select class="select-box <?= validation_show_error('asal_instansi_option') ? 'invalid-input' : '' ?>" name="asal_instansi_option" id="asal_instansi_option">
                        <option value="">Pilih instansi</option>
                        <?php foreach ($instansi->data as $i) : ?>
                            <?php $selected = old('asal_instansi_option') == $i->ket_ukerja ? 'selected' : ''; ?>
                            <option value="<?= $i->ket_ukerja ?>" <?= $selected ?>><?= $i->ket_ukerja ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-response">
                        <?= validation_show_error('asal_instansi_option') ?>
                    </div>
                </div>
            </div>

            <div class="input-box">
                <div id="signature-pad" class="signature-pad">
                    <label>Tempat Tanda Tangan</label>
                    <canvas id="signatureCanvas" class="signature-canvas <?= validation_show_error('signatureData') ? 'invalid-input' : '' ?>"></canvas>
                    <input type="hidden" id="signatureData" name="signatureData" value="" />
                    <a id="clearButton" data-action="clear" class="signature-button btn btn-sm btn-secondary text-white"><i class="fa fa-repeat"></i> Ulangi</a>
                </div>
                <div class="invalid-response"><?= validation_show_error('signatureData') ?></div>
            </div>

            <div class="button-function">

                <div class="form-group text-end">
                    <div class="g-recaptcha" data-sitekey="<?= env('RECAPTCHA_SITE_KEY_V2') ?>"></div>
                </div>
            </div>
            <div class="invalid-response" id="recaptcha-error"></div>
            <button type="submit">Kirim</button>
        </form>
    </section>
</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/signature.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/form-absensi-2.js') ?>"></script>
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

    const base_url = '<?= base_url() ?>';
</script>

<?= $this->endSection() ?>