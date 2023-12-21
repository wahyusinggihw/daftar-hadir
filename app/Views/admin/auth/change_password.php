<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/icon.png') ?>" type="image/x-icon">
    <title>Daftar Hadir <?php isset($title) ? print('- ' . $title) : '' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

    <link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/changepass.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body style="background-image:url(<?= base_url('assets/img/bg_home.png') ?>);">
    <!-- modal -->
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Ganti Password',
                text: '<?= session()->getFlashdata('error')  ?>',
            })
        </script>
    <?php endif; ?>

    <style>
        .form-control.is-invalid,
        .was-validated .form-control:invalid {

            background-image: none !important;
        }
    </style>

    <div class="login-form">
        <div class="logo">
            <img src="<?php echo base_url('assets/img/pemkab.png'); ?>" alt="Logo" width="100">
        </div>

        <h2>Ubah Password</h2>
        <form action="<?= base_url('/auth/change-password') ?>" method="post" id="form-login">
            <?= csrf_field() ?>
            <div class="container">
                <div class="input-wrapper">
                    <div class="form-group mb-3">
                        <div class="password-new-input">
                            <label for="password" class="form-label">Password baru:</label>
                            <input type="password" class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Masukkan password" autofocus>
                            <span class="password-toggle-btn-new" onclick="togglePassword('password')">
                                <i id="password-toggle-icon" class="fa fa-eye"></i>
                            </span>
                            <div class="invalid-feedback-change">
                                <?= validation_show_error('password') ?>
                            </div>
                        </div>
                        <div id="requirements-list-change">
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

                <div class="input-wrapper">
                    <div class="form-group mb-3">
                        <label for="confirm-password" class="form-label">Konfirmasi Password:</label>
                        <div class="password-input-container">
                            <input type="password" class="form-control <?= validation_show_error('confirm-password') ? 'is-invalid' : '' ?>" id="confirm-password" name="confirm-password" placeholder="Konfirmasi password">
                            <span class="password-toggle-btn" onclick="togglePassword('confirm-password')">
                                <i id="password-toggle-icon" class="fa fa-eye"></i>
                            </span>
                            <div class="invalid-feedback-change">
                                <?= validation_show_error('confirm-password') ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- <div class="g-recaptcha" data-sitekey="<?= env('RECAPTCHA_SITE_KEY_V2') ?>" id="recaptcha"></div>
                    <div class="invalid-feedback text-start"><?= validation_show_error('g-recaptcha-response') ?></div> -->
                </div>

                <button type="submit" data-action='submit'>Login</button>
            </div>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="<?php echo base_url('assets/js/mata.js'); ?>"></script>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>




</html>