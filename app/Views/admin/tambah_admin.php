<?= $this->extend('/dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>
    <div class="">
        <div class="card card-primary">
            <div class="card-body">
                <form action="<?= base_url('dashboard/kelola-admin/tambah-admin') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nama">Nama <?= session()->get('role') == 'superadmin' ? 'Admin' : 'Operator' ?></label>
                                <input class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama') ?>" type="text" id="nama" name="nama" placeholder="Masukkan nama" autofocus>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php if (session()->get('role') != 'superadmin') : ?>
                                    <div class="form-group mb-3" id="instansiOption">
                                        <label for="asal_instansi" class="form-label">Bidang</label>
                                        <select name="asal_instansi" id="asal_instansi" class="form-select <?= validation_show_error('asal_instansi') ? 'is-invalid' : '' ?>" id="asal_instansi" name="asal_instansi">
                                            <option value="">Pilih Bidang</option>
                                            <?php foreach ($bidang as $item) : ?>
                                                <?php
                                                $optionValue = $item['id_bidang'] . '-' . $item['nama_bidang'];
                                                $selected = old('asal_instansi') === $optionValue ? 'selected' : '';
                                                ?>
                                                <option value="<?= $optionValue ?>" <?= $selected ?>><?= $item['nama_bidang'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback text-start">
                                            <?= validation_show_error('asal_instansi') ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="form-group mb-3" id="instansiOption">
                                        <label for="asal_instansi" class="form-label">Asal Instansi</label>
                                        <!-- <input type="text" class="form-control" id=" " placeholder=" "> -->
                                        <select name="asal_instansi" id="asal_instansi" class="form-select <?= validation_show_error('asal_instansi') ? 'is-invalid' : '' ?>" id="asal_instansi" name="asal_instansi">
                                            <!-- foreach -->
                                            <option value="">Pilih instansi</option>
                                            <?php foreach ($instansi->data as $i) : ?>
                                                <?php
                                                $optionValue = $i->kode_ukerja . '-' . $i->ket_ukerja;
                                                $selected = old('asal_instansi') === $optionValue ? 'selected' : '';
                                                ?>
                                                <option value="<?= $optionValue ?>" <?= $selected ?>><?= $i->ket_ukerja ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback text-start">
                                            <?= validation_show_error('asal_instansi') ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input class="form-control <?= validation_show_error('username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" type="text" id="username" name="username" placeholder="Username">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('username') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">password:</label>
                                <div class="password-input-container">
                                    <input class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" type="password" id="password" name="password" placeholder="password" style="background-image: none;">
                                    <span class="toggle-new" onclick="togglePassword('password')">
                                        <i id="toggle-password" class="fa fa-eye"></i>
                                    </span>
                                    <div class="invalid-feedback-custom">
                                        <?= validation_show_error('password') ?>
                                    </div>
                                </div>
                                <label class="label-req" for="label-validasi">Password harus berisi sebagai berikut: :</label>
                                <div id="requirements-list-custom">
                                    <ul id="requirements-1">
                                        <li><i id="capital" class="far fa-times-circle"></i>Huruf Kapital</li>
                                        <li><i id="number" class="far fa-times-circle"></i>Angka</li>
                                    </ul>
                                    <ul id="requirements-2">
                                        <li><i id="letter" class="far fa-times-circle"></i>Huruf kecil</li>
                                        <li><i id="length" class="far fa-times-circle"></i>Minimal 8 karakter</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('dashboard/kelola-admin') ?>" type="submit" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/mata.js'); ?>"></script>
</body>

<?= $this->endSection() ?>