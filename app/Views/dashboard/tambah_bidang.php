<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <?php if (session()->getFlashdata('success')) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?= session()->getFlashdata('success') ?>',
            })
        </script>
    <?php endif; ?>
    <div class="col-8 my-2">
        <div class="card card-primary">
            <div class="card-body">
                <form action="<?= base_url('dashboard/kelola-bidang/tambah-bidang') ?>" method="post">
                    <?= csrf_field() ?>

                    <label for="nama">Nama Bidang:</label>
                    <input class="form-control <?= validation_show_error('nama_bidang') ? 'is-invalid' : '' ?>" type="text" id="nama_bidang" name="nama_bidang" placeholder="contoh. Persandian dan Statistik">
                    <div class="invalid-feedback">
                        <?= validation_show_error('nama_bidang') ?>
                    </div>
                    <br>

                    <!-- <div class="form-group mb-3" id="instansiOption">
                        <label for="asal_instansi" class="form-label">Bidang</label>
                        <select name="asal_instansi" id="asal_instansi" class="form-select <?= validation_show_error('asal_instansi') ? 'is-invalid' : '' ?>" value="<?= old('asal_instansi') ?>" id="asal_instansi" name="asal_instansi">
                            <option value="">Pilih Bidang</option>
                            <option value="1">Bidang 1</option>
                            <option value="2">Bidang 2</option>
                            <option value="3">Bidang 3</option>
                        </select>
                        <div class="invalid-feedback text-start">
                            <?= validation_show_error('asal_instansi') ?>
                        </div>
                    </div> -->

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // ajax
    </script>
</body>

<?= $this->endSection() ?>