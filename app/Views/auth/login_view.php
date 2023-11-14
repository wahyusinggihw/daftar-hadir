<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Check <?php isset($title) ? print('- ' . $title) : '' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body style="background-image:url(<?= base_url('assets/img/bg_home.png') ?>);">
    <!-- modal -->
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= session()->getFlashdata('error')  ?>',
            })
        </script>
    <?php endif; ?>


    <div class="login-form">
        <div class="container">
            <img src="<?php echo base_url('assets/img/pemkab.png'); ?>" alt="Logo" width="100">
        </div>

        <h2>Login</h2>
        <form action="<?= base_url('/auth/login') ?>" method="post" id="form-login" onsubmit="return validateRecaptcha()">
            <?= csrf_field() ?>
            <div class="container">
                <div class="input-wrapper">
                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control <?= validation_show_error('username') ? 'is-invalid' : '' ?>" value="<?= old('username') ?>" id="username" name="username" placeholder="Masukkan username" autofocus>
                        <div class="invalid-feedback text-start">
                            <?= validation_show_error('username') ?>
                        </div>
                    </div>
                </div>

                <div class="input-wrapper">
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <div class="password-input-container">
                            <input type="password" class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Masukkan password">
                            <span class="password-toggle-btn" onclick="togglePasswordVisibility()">
                                <i id="password-toggle-icon" class="fa fa-eye"></i>
                            </span>
                            <div class="invalid-feedback text-start">
                                <?= validation_show_error('password') ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="g-recaptcha" data-sitekey="<?= env('RECAPTCHA_SITE_KEY_V2') ?>" id="recaptcha"></div>
                    <div class="invalid-feedback text-start" id="recaptcha-error"></div>
                </div>

                <button type="submit" data-action='submit'>Login</button>
            </div>
        </form>
    </div>




</body>



<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
<script>
    function validateRecaptcha() {
        // Use the grecaptcha object to check if the user has checked the reCAPTCHA.
        var recaptchaResponse = grecaptcha.getResponse();
        var recaptchaErrorElement = document.getElementById("recaptcha-error");

        if (recaptchaResponse.length === 0) {
            // User hasn't checked the reCAPTCHA, display an error message.
            recaptchaErrorElement.textContent = "Mohon centang reCAPTCHA.";
            return false;
        }

        // User has checked the reCAPTCHA, clear the error message and continue with form submission.
        recaptchaErrorElement.textContent = "";
        return true;
    }
</script>

</html>