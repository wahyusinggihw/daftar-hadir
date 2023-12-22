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
    <div class="card card-warning">
        <div class="card-body">
            <form action="<?= base_url('admin/kelola-bidang/edit-bidang/' . $data['id_bidang']) . '/update' ?>" method="post">
                <?= csrf_field() ?>
                <?= validation_list_errors() ?>
                <input type="hidden" value="<?= $data['id_bidang'] ?>" name="id_bidang" id="id_bidang">

                <label for="nama_bidang">Nama Bidang:</label>
                <input class="form-control <?= validation_show_error('nama_bidang') ? 'is-invalid' : '' ?>" value="<?= old('nama_bidang', $data['nama_bidang']) ?>" type="text" id="nama_bidang" name="nama_bidang" placeholder="contoh. Persandian dan Statistik">
                <div class="invalid-feedback">
                    <?= validation_show_error('nama_bidang') ?>
                </div>
                <br>

                <label for="nama_kepala_bidang">Nama Kepala Bidang:</label>
                <input class="form-control <?= validation_show_error('nama_kepala_bidang') ? 'is-invalid' : '' ?>" value="<?= old('nama_kepala_bidang', $data['nama_kepala_bidang']) ?>" type="text" id="nama_kepala_bidang" name="nama_kepala_bidang" placeholder="">
                <div class="invalid-feedback">
                    <?= validation_show_error('nama_kepala_bidang') ?>
                </div>
                <br>

                <label for="nip_kepala_bidang">NIP Kepala Bidang:</label>
                <input class="form-control <?= validation_show_error('nip_kepala_bidang') ? 'is-invalid' : '' ?>" value="<?= old('nip_kepala_bidang', $data['nip_kepala_bidang']) ?>" type="text" id="nip_kepala_bidang" name="nip_kepala_bidang" placeholder="" maxlength="18">
                <div class="invalid-feedback">
                    <?= validation_show_error('nip_kepala_bidang') ?>
                </div>
                <br>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
</script>
<!-- </body> -->
<?= $this->include('admin/templates/footer'); ?>