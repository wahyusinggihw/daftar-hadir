function submitForm() {
  const inputId = document.getElementById("inputAlphanumeric").value;
  // Ganti 'halaman_tujuan.php' dengan halaman tujuan yang diinginkan
  window.location.href = "peran.php?id=" + inputId;
}

window.addEventListener("scroll", function () {
    const scrollValue = window.scrollY;
    const parallaxBg = document.querySelector(".parallax-bg");
    parallaxBg.style.transform = `translateY(-${scrollValue * 0.7}px)`; /* Sesuaikan faktor 0.2 sesuai dengan kecepatan yang Anda inginkan */
});
