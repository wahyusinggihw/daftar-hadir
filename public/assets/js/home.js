// document.addEventListener("DOMContentLoaded", function(event) {

//     function OTPInput() {
//         const editor = document.getElementById('otpInput1');
//         editor.onpaste = pasteOTP;

//         const inputs = document.querySelectorAll('#otp > *[id]');
//         for (let i = 0; i < inputs.length; i++) { 
//             inputs[i].addEventListener('input', function(event) { 
//                 if(!event.target.value || event.target.value == '' ){
//                     if(event.target.previousSibling.previousSibling){
//                         event.target.previousSibling.previousSibling.focus();    
//                     }
                
//                 }else{ 
//                     if(event.target.nextSibling.nextSibling){
//                         event.target.nextSibling.nextSibling.focus();
//                     }
//                 }
//                 combineOtpValues();  
                
//                 button.classList.remove("active");
//                 button.setAttribute("disabled", "disabled");

//                 const inputsNo = inputs.length;
//                 if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
//                 button.classList.add("active");
//                 button.removeAttribute("disabled");
//         }
//             });             
//         } 
//     } 
//     OTPInput(); 
// });

// function pasteOTP(event){
//     event.preventDefault();
//     let elm = event.target;
//     let pasteVal = event.clipboardData.getData('text').split("");
//     if(pasteVal.length > 0){
//         while(elm){
//             elm.value = pasteVal.shift();
//             elm = elm.nextSibling.nextSibling;
//         }
//     }
// }


// function combineOtpValues() {
//     var combinedOtp = '';
//     combinedOtp += document.getElementById('otpInput1').value;
//     combinedOtp += document.getElementById('otpInput2').value;

//     var otpInput3Value = document.getElementById('otpInput3').value;
//     if (otpInput3Value.trim() !== '') {
//         combinedOtp += otpInput3Value;
//         combinedOtp += '-';
//     }

//     combinedOtp += document.getElementById('otpInput4').value;
//     combinedOtp += document.getElementById('otpInput5').value;
//     combinedOtp += document.getElementById('otpInput6').value;

//     document.getElementById('id_rapat').value = combinedOtp;
// }

// var otpInputs = document.querySelectorAll('.otp-input');
//         otpInputs.forEach(function(input) {
//             input.addEventListener('input', combineOtpValues);
//             input.addEventListener('paste', function() {
//                 setTimeout(combineOtpValues, 0);
//             });
//         });

// function setInputFilter(textboxes, errMsg) {
//             if (textboxes && Array.isArray(textboxes)) {
//                 textboxes.forEach(function(textbox) {
//                     textbox.addEventListener("input", function() {
//                         const numericValue = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters

//                         if (this.value !== numericValue) {
//                             // Non-numeric characters were entered - block and show error
//                             this.value = numericValue;
//                             this.classList.add("input-error");
//                             this.setCustomValidity(errMsg);
//                             this.reportValidity();
//                         } else {
//                             // Numeric input - remove error
//                             this.classList.remove("input-error");
//                             this.setCustomValidity("");
//                             this.reportValidity();
//                         }
//                     });
//                 });
//             }
//         }

//         setInputFilter([document.getElementById("kadaluwarsa")], "Harus berupa angka");

const inputs = document.querySelectorAll(".otp-field > input");
const button = document.querySelector(".btn");

window.addEventListener("load", () => inputs[0].focus());
button.setAttribute("disabled", "disabled");

inputs[0].addEventListener("paste", function (event) {
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
      var combinedOtp = inputOtp1 + inputOtp2 + inputOtp3 + - + inputOtp4 + inputOtp5 + inputOtp6;

      // Menetapkan nilai kombinasi pada input tipe hidden
      document.getElementById('id_rapat').value = combinedOtp;

      // Menampilkan hasil kombinasi (opsional)
      console.log("Kombinasi OTP: " + combinedOtp);

      return;
    }
  });
});

function checkSubmit(event) {
        // Lakukan pengecekan atau aksi lainnya di sini
        alert("Tombol Submit Ditekan!");

        // Untuk menghindari pengiriman formulir (pengiriman POST atau GET)
        event.preventDefault();
}


