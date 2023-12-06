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
    }),then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
    }
})
}