// document.addEventListener("keydown", function(event) {
//     if (event.key === "Backspace") {
//         event.preventDefault(); // Prevent browser navigation when backspace is pressed
//         clearAllInputsAndFocus();
//     }
// });

// function clearAllInputsAndFocus() {
//     document.getElementById('otpInput1').value = '';
//     document.getElementById('otpInput2').value = '';
//     document.getElementById('otpInput3').value = '';
//     document.getElementById('otpInput4').value = '';
//     document.getElementById('otpInput5').value = '';
//     document.getElementById('otpInput6').value = '';
    
//     // Clear the hidden input as well
//     document.getElementById('id_rapat').value = '';

//     // Set focus to otpInput1
//     document.getElementById('otpInput1').focus();
// }

// function moveToNext(input) {
//     const maxLength = parseInt(input.getAttribute("maxlength"));
//     const currentLength = input.value.length;
//     // const editor = document.getElementById('otpInput1');
//     // editor.onpaste = pasteOTP;

//     if (currentLength >= maxLength) {
//     const nextInput = input.nextElementSibling;

//     if (nextInput && nextInput.tagName === "INPUT") {
//         nextInput.focus();
//     } else if (nextInput && nextInput.tagName === "SPAN") {
//         const nextInputAfterSpan = nextInput.nextElementSibling;
//         if (nextInputAfterSpan && nextInputAfterSpan.tagName === "INPUT") {
//         nextInputAfterSpan.focus();
//         }
//     }

//     combineOtpValues();
//     }
// }

document.addEventListener("DOMContentLoaded", function(event) {

    function OTPInput() {
        const editor = document.getElementById('otpInput1');
        editor.onpaste = pasteOTP;

        const inputs = document.querySelectorAll('#otp > *[id]');
        for (let i = 0; i < inputs.length; i++) { 
            inputs[i].addEventListener('input', function(event) { 
                if(!event.target.value || event.target.value == '' ){
                    if(event.target.previousSibling.previousSibling){
                        event.target.previousSibling.previousSibling.focus();    
                    }
                
                }else{ 
                    if(event.target.nextSibling.nextSibling){
                        event.target.nextSibling.nextSibling.focus();
                    }
                }
                combineOtpValues();               
            });             
        } 
    } 
    OTPInput(); 
});

function pasteOTP(event){
    event.preventDefault();
    let elm = event.target;
    let pasteVal = event.clipboardData.getData('text').split("");
    if(pasteVal.length > 0){
        while(elm){
            elm.value = pasteVal.shift();
            elm = elm.nextSibling.nextSibling;
        }
    }
}

function combineOtpValues() {
    var combinedOtp = '';
    combinedOtp += document.getElementById('otpInput1').value;
    combinedOtp += document.getElementById('otpInput2').value;

    var otpInput3Value = document.getElementById('otpInput3').value;
    if (otpInput3Value.trim() !== '') {
        combinedOtp += otpInput3Value;
        combinedOtp += '-';
    }

    combinedOtp += document.getElementById('otpInput4').value;
    combinedOtp += document.getElementById('otpInput5').value;
    combinedOtp += document.getElementById('otpInput6').value;

    document.getElementById('id_rapat').value = combinedOtp;
}
var otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach(function(input) {
            input.addEventListener('input', combineOtpValues);
            input.addEventListener('paste', function() {
                setTimeout(combineOtpValues, 0);
            });
        });