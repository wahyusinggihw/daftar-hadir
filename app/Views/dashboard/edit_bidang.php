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
        <div class="card card-warning">
            <div class="card-body">
                <form action="<?= base_url('dashboard/kelola-bidang/edit-bidang/' . $data['id_bidang']) . '/update' ?>" method="post">
                    <?= csrf_field() ?>
                    <?= validation_list_errors() ?>
                    <input type="hidden" value="<?= $data['id_bidang'] ?>" name="id_bidang" id="id_bidang">

                    <!-- <div class="form-group mb-3" id="instansiOption">
                        <label for="asal_instansi" class="form-label">Asal Instansi</label>
                        <select name="asal_instansi" id="asal_instansi" class="form-select <?= validation_show_error('asal_instansi') ? 'is-invalid' : '' ?>" id="asal_instansi" name="asal_instansi" autofocus>
                            <option value="">Pilih instansi</option>
                            <?php foreach ($instansi->data as $i) : ?>
                                <option value="<?= $i->kode_ukerja ?>" <?= ($selectedValue == $i->kode_ukerja) ? 'selected' : '' ?>><?= $i->ket_ukerja ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback text-start">
                            <?= validation_show_error('asal_instansi') ?>
                        </div>
                    </div> -->


                    <label for="nama_bidang">Nama Bidang:</label>
                    <input class="form-control <?= validation_show_error('nama_bidang') ? 'is-invalid' : '' ?>" value="<?= old('nama_bidang', $data['nama_bidang']) ?>" type="text" id="nama_bidang" name="nama_bidang" placeholder="contoh. Persandian dan Statistik">
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

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // ajax
    </script>
</body>

<?= $this->endSection() ?>