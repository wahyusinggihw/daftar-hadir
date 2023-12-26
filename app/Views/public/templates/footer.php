<script>
    // Script Untuk Masukan ID Ruang Rapat

    const inputs = document.querySelectorAll(".otp-field > input");
    const button = document.querySelector(".btn");

    window.addEventListener("load", () => inputs[0].focus());
    button.setAttribute("disabled", "disabled");

    inputs[0].addEventListener("paste", function(event) {
        event.preventDefault();

        const pastedValue = (event.clipboardData || window.clipboardData).getData(
            "text"
        );
        const otpLength = inputs.length;

        for (let i = 0; i < otpLength; i++) {
            if (i < pastedValue.length) {
                inputs[i].value = pastedValue[i];
                inputs[i].removeAttribute("disabled");
                inputs[i].focus;
            } else {
                inputs[i].value = ""; // Clear any remaining inputs
                inputs[i].focus;
            }
        }
    });

    inputs.forEach((input, index1) => {
        // Tambahkan variabel untuk menyimpan status penambahan "-"
        let isHyphenAdded = false;

        input.addEventListener("keyup", (e) => {
            const currentInput = input;
            const nextInput = input.nextElementSibling;
            const prevInput = input.previousElementSibling;

            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }

            if (
                nextInput &&
                nextInput.hasAttribute("disabled") &&
                currentInput.value !== ""
            ) {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }

            button.classList.remove("active");
            button.setAttribute("disabled", "disabled");

            const inputsNo = inputs.length;
            if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
                button.classList.add("active");
                button.removeAttribute("disabled");

                // Mendapatkan nilai dari setiap input OTP secara manual
                var inputOtp1 = document.getElementById('otpInput1').value;
                var inputOtp2 = document.getElementById('otpInput2').value;
                var inputOtp3 = document.getElementById('otpInput3').value;
                var inputOtp4 = document.getElementById('otpInput4').value;
                var inputOtp5 = document.getElementById('otpInput5').value;
                var inputOtp6 = document.getElementById('otpInput6').value;

                // Mengkombinasikan nilai-nilai input OTP menjadi satu string secara manual
                var combinedOtp = inputOtp1 + inputOtp2 + inputOtp3 + '-' + inputOtp4 + inputOtp5 + inputOtp6;

                // Menetapkan nilai kombinasi pada input tipe hidden
                document.getElementById('id_rapat').value = combinedOtp;

                // Menampilkan hasil kombinasi (opsional)
                console.log("Kombinasi OTP: " + combinedOtp);

                return;
            }
        });
    });
</script>
<script>
    /* script.js */
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- </body> -->
<section class="section-footer">
    <div class="title-footer">
        Diskominfosanti Kabupaten Buleleng 2023
    </div>
</section>
<!-- </body> -->

</html>