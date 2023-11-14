document.addEventListener('DOMContentLoaded', function () {
    // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
    var icons = ['capital', 'number', 'letter', 'length'];
    icons.forEach(function (icon) {
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
        icons.forEach(function (icon) {
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

document.addEventListener('DOMContentLoaded', function () {
    // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
    var icons = ['capital', 'number', 'letter', 'length'];
    icons.forEach(function (icon) {
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
        icons.forEach(function (icon) {
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

document.addEventListener('DOMContentLoaded', function () {
    // Semua ikon diatur ke mode sembunyi dan dengan ikon silang pada awalnya
    var icons = ['capital', 'number', 'letter', 'length'];
    icons.forEach(function (icon) {
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
        icons.forEach(function (icon) {
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
