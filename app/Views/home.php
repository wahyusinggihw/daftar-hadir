<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<!-- <link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>"> -->
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

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
          </li>
          <li>
            <div class="item">
              <span>4</span>
              <div class="content">
                <h3>Mengisi Formulir</h3>
                <p>
                  Jika sebagai pegawai cukup isikan NIP atau NIPT, lalu tekan "Cari" dan tanda tangan. Sedangkan untuk tamu jika baru pertama anda bisa isi semua biodata anda pada formulir yang sudah di sediakan, jika NIK kalian sudah terdaftar
                  silahkan tekan "Cari" lalu lanjutkan mengisi tanda tangan.
                </p>
              </div>
            </div>
          </li>
          <li>
            <div class="item">
              <span>5</span>
              <div class="content">
                <h3>Selesai</h3>
                <p>
                  Pastikan semua data yang anda masukkan sudah benar, kemudian anda dapat mengirim formulir dengan menekan tombol "Kirim".
                </p>
              </div>
            </div>
          </li>
          </ul>
        </div>
        <div class="content-wrapper">
          <div class="container-info">
            <div class="info">
              <h1>Daftar Hadir Rapat</h1>
              <h2>Pemkab Buleleng</h2>
            </div>
          </div>
          <form action="<?= base_url('/rapat/submit-kode') ?>" method="post">
            <?= csrf_field() ?>
            <div class="formid">
              <div class="form-p">
                <p>Silahkan Masukan Kode Rapat</p>
              </div>
              <?php
              $invalid_input = validation_show_error('id_rapat') ? 'invalid-input' : '';
              ?>

              <div class="input-kode" id="otp">
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput1" name="otpInput1" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput2" name="otpInput2" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput3" name="otpInput3" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
                -
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput4" name="otpInput4" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput5" name="otpInput5" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
                <input type="text" class="otp-input <?= $invalid_input ?>" id="otpInput6" name="otpInput6" maxlength="1" pattern="[0-9]" oninput="moveToNext(this)" inputmode="numeric" autocomplete="off" placeholder="X">
              </div>

              <div class="form-input">
                <input type="hidden" class="form-control <?= (validation_show_error('id_rapat')) ? 'is-invalid' : '' ?>" id="id_rapat" name="id_rapat" placeholder="XXX-XXX" autocomplete="off">
                <div class="invalid-feedback">
                  <?= validation_show_error('id_rapat') ?>
                </div>
              </div>
              <button id="submitButton" onclick="combineOtpValues()">Masuk</button>
            </div>
        </div>
      </div>
  </form>
</body>

<?= $this->endSection() ?>