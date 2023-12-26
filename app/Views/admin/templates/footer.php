</div>
</section>
<!-- /.content -->
</div>
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- ChartJS -->
<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<!-- Sparkline -->
<script src="<?= base_url('assets/plugins/sparklines/sparkline.js') ?>"></script>
<!-- JQVMap -->
<script src="<?= base_url('assets/plugins/jqvmap/jquery.vmap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/dist/js/demo.js') ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('assets/dist/js/pages/dashboard.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    // script JS Check Requirement Password

    document.addEventListener('DOMContentLoaded', function() {
        // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
        var icons = ['capital', 'number', 'letter', 'length'];
        icons.forEach(function(icon) {
            var element = document.getElementById(icon);
            element.classList.add('fa-times-circle'); // Menambahkan ikon silang secara default
        });

        function checkPasswordRequirements() {
            var password = document.getElementById('password').value;

            var uppercaseRegex = /[A-Z]/;
            var numberRegex = /[0-9]/;
            var lowercaseRegex = /[a-z]/;
            var lengthRegex = /.{8,}/;

            var capitalCheck = uppercaseRegex.test(password);
            var numberCheck = numberRegex.test(password);
            var letterCheck = lowercaseRegex.test(password);
            var lengthCheck = lengthRegex.test(password);

            // Update ikon ke ikon centang jika persyaratan terpenuhi
            icons.forEach(function(icon) {
                var element = document.getElementById(icon);
                if (eval(icon + 'Check')) {
                    element.classList.remove('fa-times-circle');
                    element.classList.add('fa-check-circle');
                } else {
                    element.classList.add('fa-times-circle');
                    element.classList.remove('fa-check-circle');
                }
            });
        }

        document.getElementById('password').addEventListener('input', checkPasswordRequirements);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
        var icons = ['capital', 'number', 'letter', 'length'];
        icons.forEach(function(icon) {
            var element = document.getElementById(icon);
            element.classList.add('fa-times-circle'); // Menambahkan ikon silang secara default
        });

        function checkPasswordRequirements() {
            var password = document.getElementById('new-password').value;

            var uppercaseRegex = /[A-Z]/;
            var numberRegex = /[0-9]/;
            var lowercaseRegex = /[a-z]/;
            var lengthRegex = /.{8,}/;

            var capitalCheck = uppercaseRegex.test(password);
            var numberCheck = numberRegex.test(password);
            var letterCheck = lowercaseRegex.test(password);
            var lengthCheck = lengthRegex.test(password);

            // Update ikon ke ikon centang jika persyaratan terpenuhi
            icons.forEach(function(icon) {
                var element = document.getElementById(icon);
                if (eval(icon + 'Check')) {
                    element.classList.remove('fa-times-circle');
                    element.classList.add('fa-check-circle');
                } else {
                    element.classList.add('fa-times-circle');
                    element.classList.remove('fa-check-circle');
                }
            });
        }

        document.getElementById('new-password').addEventListener('input', checkPasswordRequirements);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
        var icons = ['capital', 'number', 'letter', 'length'];
        icons.forEach(function(icon) {
            var element = document.getElementById(icon);
            element.classList.add('fa-times-circle'); // Menambahkan ikon silang secara default
        });

        function checkPasswordRequirements() {
            var password = document.getElementById('password').value;

            var uppercaseRegex = /[A-Z]/;
            var numberRegex = /[0-9]/;
            var lowercaseRegex = /[a-z]/;
            var lengthRegex = /.{8,}/;

            var capitalCheck = uppercaseRegex.test(password);
            var numberCheck = numberRegex.test(password);
            var letterCheck = lowercaseRegex.test(password);
            var lengthCheck = lengthRegex.test(password);

            // Update ikon ke ikon centang jika persyaratan terpenuhi
            icons.forEach(function(icon) {
                var element = document.getElementById(icon);
                if (eval(icon + 'Check')) {
                    element.classList.remove('fa-times-circle');
                    element.classList.add('fa-check-circle');
                } else {
                    element.classList.add('fa-times-circle');
                    element.classList.remove('fa-check-circle');
                }
            });
        }

        document.getElementById('password').addEventListener('input', checkPasswordRequirements);
    });

    /* script.js Copy Text */
    function copyText() {
        var teksElement = document.getElementById("teksToSalin");
        var textarea = document.createElement("textarea");

        // Menggunakan textContent untuk mendapatkan teks tanpa format atau tata letak
        var teksTanpaSymbol = teksElement.textContent.replace(/[^\d]/g, ''); // Hanya menyertakan karakter angka

        textarea.value = teksTanpaSymbol;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showSuccessNotification();
    }

    function showSuccessNotification() {
        let timerInterval
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Teks telah berhasil disalin',
            toast: true,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
                clearInterval(timerInterval)
            }
        }), then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
            }
        })
    }

    // Script JS Show Password

    function togglePassword(inputId) {
        const passwordField = document.getElementById(inputId);
        const toggleButton = document.querySelector(`[onclick="togglePassword('${inputId}')"]`);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordField.type = 'password';
            toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
</body>

</html>