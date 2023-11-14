<?= $this->extend('dashboard/layout/dashboard_layout') ?>

<?= $this->section('content') ?>

<body>

    <div class="col-8 my-2">
        <div class="card card-warning">
            <div class="card-body">
                <form action="<?= base_url('/dashboard/profile/edit-profile/' . $data['id_admin']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <input type="hidden" id="text" name="id" value="<?= $data['id_admin'] ?>">

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
                    </div>
                    <div class="form-group">
                        <label for="avatar" class="form-label">Foto Profil</label>
                        <input class="form-control <?= validation_show_error('avatar') ? 'is-invalid' : '' ?>" value="<?= $data['avatar'] ?>" type="file" id="avatar" name="avatar">
                        <div class="invalid-feedback">
                            <?= validation_show_error('avatar') ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

</body>

<?= $this->endSection(); ?>