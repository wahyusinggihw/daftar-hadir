const wrapper = document.getElementById("signature-pad");
const canvas = wrapper.querySelector("canvas");
const signaturePad = new SignaturePad(canvas, {
});

function resizeCanvas() {
  
  const ratio = Math.max(window.devicePixelRatio || 1, 1);

  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
  signaturePad.fromData(signaturePad.toData());
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad.addEventListener(
  "endStroke",
  () => {
    saveSignatureData();
    console.log(document.getElementById("signatureData").value);
  },
  {
    once: false,
  }
);

const clearButton = wrapper.querySelector("[data-action=clear]");
clearButton.addEventListener("click", () => {
  // console.log("clear");
  signaturePad.clear();
  document.getElementById("signatureData").value = "";
});

// Add touch events for mobile devices
canvas.addEventListener("touchstart", (e) => {
  e.preventDefault();
  const touch = e.touches[0];
  const mouseEvent = new MouseEvent("mousedown", {
    clientX: touch.clientX,
    clientY: touch.clientY,
  });
  canvas.dispatchEvent(mouseEvent);
});

canvas.addEventListener("touchend", (e) => {
  e.preventDefault();
  const mouseEvent = new MouseEvent("mouseup", {});
  canvas.dispatchEvent(mouseEvent);
});

function clearSignature() {
  signaturePad.clear();
  document.getElementById("signatureData").value = "";
}

function saveSignatureData() {
  const signatureData = signaturePad.toDataURL(); // Mendapatkan data tanda tangan dalam format base64
  document.getElementById("signatureData").value = signatureData;
}