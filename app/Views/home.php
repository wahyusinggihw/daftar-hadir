<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
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

  <div class="row ">
    <div class="content-wrapper">
      <ul class="timeline">
        <li>
          <div class="item">
            <span>1</span>
            <div class="content">
              <h3>Masukkan Kode Rapat</h3>
              <p>Silahkan masukkan kode rapat yang sudah diberikan di kolom diatas, lalu tekan "Masuk". Atau</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item">
            <span>2</span>
            <div class="content">
              <h3>Masuk Dengan Qr Code</h3>
              <p>Cara lain untuk memasuki rapat adalah dengan memindai kode QR yang sudah diberikan oleh admin rapat.</p>
            </div>
          </div>
        </li>
        <li>
          <div class="item">
            <span>3</span>
            <div class="content">
              <h3>Memilih Status</h3>
              <p>Jika sudah berhasil maka silahkan anda memilih sebagai tamu atau pegawai. Jika sebagai pegawai silahkan di pilih apakah anda "ASN" atau "non-ASN", Namun jika sebagai tamu silahkan di pilih "tamu".</p>
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
              <h3>Mengisi Formulir</h3>
              <p>
                Jika sebagai pegawai cukup isikan NIP atau NIPT, lalu tekan "Cari" dan tanda tangan. Sedangkan untuk tamu jika baru pertama anda bisa isi semua biodata anda pada formulir yang sudah di sediakan, jika NIK kalian sudah terdaftar
                silahkan tekan "Cari" lalu lanjutkan mengisi tanda tangan.
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
        <div class="formid">
          <div class="form-p">
            <p>Silahkan Masukan Kode Rapat</p>
          </div>

          <div class="form-input">
            <input type="text" class="form-control <?= (validation_show_error('id_rapat')) ? 'is-invalid' : '' ?>" id="id_rapat" name="id_rapat" placeholder="XXX-XXX">
            <button>Masuk</button>
            <div class="invalid-feedback">
              <?= validation_show_error('id_rapat') ?>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

</body>

<?= $this->endSection() ?>