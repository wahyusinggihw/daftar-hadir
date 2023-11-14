<?= $this->extend('layout/page_layout') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<body>
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

  <section class="section-1" style="background-image:url(<?= base_url('assets/img/bg_home.png') ?>);">
    <div class="container-info">
      <div class="info">
        <h1>Daftar Hadir Rapat</h1>
        <h2>Pemkab Buleleng</h2>
      </div>
      <div class="logo justify-content-center d-none d-lg-block"><img src="<?= base_url('assets/img/human-image.png') ?>" class="prod-human-img" alt="prod" /></div>
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
  </section>

  <section class="section-2">
    <div class="container-timeline">
      <h2 class="pb-5 pt-5 text-center mb-5 display-5">Cara <br> Penggunaan</h2>


      <!-- First Content Section-->
      <div class="row align-items-center connecting-lines d-flex">
        <div class="col-2 text-center bottom d-inline-flex justify-content-center align-items-center">
          <div class="circle font-weight-bold">1</div>
        </div>
        <div class="col-6">
          <!-- <img src="<?= base_url('assets/img/carousel-1.png') ?>" alt=""> -->
          <div>

            <h4>Masukkan Kode Rapat</h4>
            <p>Silahkan masukkan kode rapat yang sudah diberikan di kolom diatas, lalu tekan "Masuk". Atau</p>
          </div>
        </div>
      </div>
      <!-- Path Line -->
      <div class="row timeline">
        <div class="col-2">
          <div class="corner top-right"></div>
        </div>
        <div class="col-8">
          <hr />
        </div>
        <div class="col-2">
          <div class="corner left-bottom"></div>
        </div>
      </div>


      <!-- Second Content Section-->
      <div class="row align-items-center justify-content-end connecting-lines d-flex">
        <div class="col-6 text-right">
          <!-- <img src="<?= base_url('assets/img/carousel-1.png') ?>" alt=""> -->
          <h4>Masuk Dengan Qr Code</h4>
          <p>
            Cara lain untuk memasuki rapat adalah dengan memindai kode QR yang sudah diberikan oleh admin rapat.
          </p>
        </div>
        <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
          <div class="circle font-weight-bold">2</div>
        </div>
      </div>
      <!-- Path Line -->
      <div class="row timeline">
        <div class="col-2">
          <div class="corner right-bottom"></div>
        </div>
        <div class="col-8">
          <hr />
        </div>
        <div class="col-2">
          <div class="corner top-left"></div>
        </div>
      </div>


      <!-- Third Content Section -->
      <div class="row align-items-center connecting-lines d-flex">
        <div class="col-2 text-center full left d-inline-flex justify-content-center align-items-center">
          <div class="circle font-weight-bold">3</i></div>
        </div>
        <div class="col-6">
          <h4>Memilih Status</h4>
          <p>
            Jika sudah berhasil maka silahkan anda memilih sebagai tamu atau pegawai. Jika sebagai pegawai silahkan di pilih apakah anda "ASN" atau "non-ASN", Namun jika sebagai tamu silahkan di pilih "tamu".
          </p>
        </div>
      </div>
      <!-- Path Line -->
      <div class="row timeline">
        <div class="col-2">
          <div class="corner top-right"></div>
        </div>
        <div class="col-8">
          <hr />
        </div>
        <div class="col-2">
          <div class="corner left-bottom"></div>
        </div>
      </div>
      <!-- Second Content Section-->
      <div class="row align-items-center justify-content-end connecting-lines d-flex">
        <div class="col-6 text-right">
          <!-- <img src="<?= base_url('assets/img/carousel-1.png') ?>" alt=""> -->
          <h4>Mengisi Formulir</h4>
          <p>
            Jika sebagai pegawai cukup isikan NIP atau NIPT, lalu tekan "Cari" dan tanda tangan. Sedangkan untuk tamu jika baru pertama anda bisa isi semua biodata anda pada formulir yang sudah di sediakan, jika NIK kalian sudah terdaftar silahkan tekan "Cari" lalu lanjutkan mengisi tanda tangan.
          </p>
        </div>
        <div class="col-2 text-center full d-inline-flex justify-content-center align-items-center">
          <div class="circle font-weight-bold">4</div>
        </div>
      </div>
      <!-- Path Line -->
      <div class="row timeline">
        <div class="col-2">
          <div class="corner right-bottom"></div>
        </div>
        <div class="col-8">
          <hr />
        </div>
        <div class="col-2">
          <div class="corner top-left"></div>
        </div>
      </div>


      <!-- Third Content Section -->
      <div class="row align-items-center connecting-lines d-flex">
        <div class="col-2 text-center top d-inline-flex justify-content-center align-items-center">
          <div class="circle font-weight-bold">5</i></div>
        </div>
        <div class="col-6">
          <h4>Selesai</h4>
          <p>
            Pastikan semua data yang anda masukkan sudah benar, kemudian anda dapat mengirim formulir dengan menekan tombol "Kirim".
          </p>
        </div>
      </div>
    </div>
  </section>

</body>

<?= $this->endSection() ?>