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