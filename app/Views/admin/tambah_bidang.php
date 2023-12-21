<?= $this->include('admin/templates/header'); ?>

<!-- <body> -->
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>',
        })
    </script>
<?php endif; ?>
<div class="col-md-8 my-2">
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
                <label for="nama_kepala_bidang">Nama Kepala Bidang:</label>
                <input class="form-control <?= validation_show_error('nama_kepala_bidang') ? 'is-invalid' : '' ?>" type="text" id="nama_kepala_bidang" name="nama_kepala_bidang" placeholder="">
                <div class="invalid-feedback">
                    <?= validation_show_error('nama_kepala_bidang') ?>
                </div>
                <br>
                <label for="nip_kepala_bidang">NIP Kepala Bidang:</label>
                <input class="form-control <?= validation_show_error('nip_kepala_bidang') ? 'is-invalid' : '' ?>" type="text" id="nip_kepala_bidang" name="nip_kepala_bidang" placeholder="" inputmode="numeric" maxlength="18">
                <div class="invalid-feedback">
                    <?= validation_show_error('nip_kepala_bidang') ?>
                </div>
                <br>

                <a href="<?= base_url('dashboard/kelola-bidang') ?>" type="submit" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // ajax
        function setInputFilter(textboxes, errMsg) {
            if (textboxes && Array.isArray(textboxes)) {
                textboxes.forEach(function(textbox) {
                    textbox.addEventListener("input", function() {
                        const numericValue = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters

                        if (this.value !== numericValue) {
                            // Non-numeric characters were entered - block and show error
                            this.value = numericValue;
                            this.classList.add("input-error");
                            this.setCustomValidity(errMsg);
                            this.reportValidity();
                        } else {
                            // Numeric input - remove error
                            this.classList.remove("input-error");
                            this.setCustomValidity("");
                            this.reportValidity();
                        }
                    });
                });
            }
        }

        setInputFilter([document.getElementById("nip_kepala_bidang")], "NIP Harus berupa angka");
    });
</script>
<!-- </body> -->
<?= $this->include('admin/templates/footer'); ?>