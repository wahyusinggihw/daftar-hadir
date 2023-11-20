<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <div class="">
        <div class="card card-warning">
            <div class="card-body">
                <form action="<?= base_url('/dashboard/kelola-admin/edit-admin/' . $data['id_admin'] . '/update') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- <input type="hidden" id="text" name="id" value="<?= $data['id_admin'] ?>">

                    <div class="form-group">
                        <label for="nama">Nama Lengkap:</label>
                        <input class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" value="<?= $data['nama'] ?>" type="text" id="nama" name="nama" placeholder="Masukkan nama" autofocus>
                        <div class="invalid-feedback">
                            <?= validation_show_error('nama') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control <?= validation_show_error('username') ? 'is-invalid' : '' ?>" value="<?= $data['username'] ?>" type="text" id="username" name="username" placeholder="Username">
                        <div class="invalid-feedback">
                            <?= validation_show_error('username') ?>
                        </div>
                    </div> -->
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="new-password">Password Baru:</label>
                                <div class="password-input-container">
                                    <input class="form-control <?= validation_show_error('new-password') ? 'is-invalid' : '' ?>" type="password" value="<?= old('new-password') ?>" id="new-password" name="new-password" placeholder="Password baru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password baru harus terdiri dari huruf besar, huruf kecil, dan angka.">
                                    <span class="toggle-new" onclick="togglePasswordVisibility()">
                                        <i id="new-toggle-icon" class="fa fa-eye"></i>
                                    </span>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('new-password') ?>
                                    </div>
                                </div>
                                <div id="requirements-list">
                                    <ul id="requirements-1">
                                        <li><i id="capital" class="far fa-times-circle"></i>Huruf Kapital</li>
                                        <li><i id="number" class="far fa-times-circle"></i>Angka</li>
                                    </ul>
                                    <ul id="requirements-2">
                                        <li><i id="letter" class="far fa-times-circle"></i>Huruf kecil</li>
                                        <li><i id="length" class="far fa-times-circle"></i>Berisi 8 karakter</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="confirm-password">Konfirmasi Password:</label>
                                <input class="form-control <?= validation_show_error('confirm-password') ? 'is-invalid' : '' ?>" type="password" id="confirm-password" name="confirm-password" placeholder="Konfirmasi password">
                                <span class="toggle-confirm" onclick="togglePasswordVisibilityConfirm()">
                                    <i id="confirm-toggle-icon" class="fa fa-eye"></i>
                                </span>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('confirm-password') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/mata.js'); ?>"></script>
</body>

<?= $this->endSection() ?>