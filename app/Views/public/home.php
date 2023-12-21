<?= $this->include('public/templates/header') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
<?= $this->endSection(); ?>


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

  <form action="<?= base_url('/rapat/submit-kode') ?>" method="post">
    <?= csrf_field() ?>
    <?php
    $invalid_input = validation_show_error('id_rapat') ? 'invalid-input' : '';
    ?>
    <div class="section-content d-flex align-items-center">
      <div class="container-lg container-qrcode">
        <div class="row">
          <div class="col-12 col-lg-6 d-flex align-items-lg-center order-2 order-lg-1 ">
            <div>
              <img src="<?= base_url('assets/img/landing_ilustration.png'); ?>" width="100%" class="d-none d-lg-block">
              <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-9 mt-5 mt-md-4 mt-lg-0">
                  <div class="title-deskripsi-aplikasi">
                    Khusus untuk Pegawai Pemerintah Kabupaten Buleleng, Aplikasi dapat diunduh di Google PlayStore untuk
                    mempermudah presensi
                  </div>
                </div>
                <div class="col-12 col-md-8 col-lg-3 mt-3 mt-sm-0 mt-md-1 mt-lg-0">
                  <a href=""><img src="<?= base_url('assets/img/logo_googleplay.png'); ?>" class="img-googleplay"></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6 d-flex align-items-center order-1 order-lg-2">
            <div class="w-100">
              <div class="row justify-content-center">
                <div class="col-md-8">
                  <div class="title-kode-rapat">Kode Rapat</div>
                  <div class="description-form-rapat">Untuk dapat melakukan presensi pada Aplikasi Daftar Hadir, masukkan
                    kode yang telah dibagikan oleh
                    petugas</div>
                  <div class="mb-3">
                    <div class="otp-field mb-4" id="otp">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput1" name="otpInput1" maxlength="1" pattern="[0-9]" inputmode="numeric" autocomplete="off">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput2" name="otpInput2" maxlength="1" pattern="[0-9]" disabled inputmode="numeric" autocomplete="off">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput3" name="otpInput3" maxlength="1" pattern="[0-9]" disabled inputmode="numeric" autocomplete="off">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput4" name="otpInput4" maxlength="1" pattern="[0-9]" disabled inputmode="numeric" autocomplete="off">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput5" name="otpInput5" maxlength="1" pattern="[0-9]" disabled inputmode="numeric" autocomplete="off">
                      <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput6" name="otpInput6" maxlength="1" pattern="[0-9]" disabled inputmode="numeric" autocomplete="off">
                    </div>
                    <div class="form-input">
                      <input type="hidden" class="form-control <?= (validation_show_error('id_rapat')) ? 'is-invalid' : '' ?>" id="id_rapat" name="id_rapat" placeholder="XXX-XXX" autocomplete="off">
                      <div class="invalid-feedback">
                        <?= validation_show_error('id_rapat') ?>
                      </div>
                    </div>
                  </div>
                  <div class="d-grid gap-2">
                    <button id="submitBtn" class="btn btn-rapat" type="submit">Cari Ruang Rapat</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <?= $this->include('public/templates/footer') ?>