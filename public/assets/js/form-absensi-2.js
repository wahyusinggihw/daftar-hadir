$(document).ready(function () {
  // check if there is validation error from checking the radio button
  var oldStatus = $('input[name="statusRadio"]:checked').val();
  console.log(oldStatus);
  if (oldStatus === "pegawai") {
    setInputFilter(
      [document.getElementById("nip"), document.getElementById("no_hp")],
      "Harus berupa angka"
    );
    onErrorHandlePegawaiStatus();
  } else if (oldStatus === "tamu") {
    setInputFilter(
      [document.getElementById("nip"), document.getElementById("no_hp")],
      "Harus berupa angka"
    );
    onErrorHandleTamuStatus();
  } else {
    // Initialization
    initializePage();
  }

  // Handle radio button click
  $(".statusRadio").on("click", function () {
    handleStatusRadioButtonClick();
  });

  // Trigger the change event on 'nip' input when a radio button is clicked
  $(".statusRadio").on("click", function () {
    handleNipInputChange();
  });
});

// Function to initialize the page
function initializePage() {
  setInputFilter(
    [document.getElementById("nip"), document.getElementById("no_hp")],
    "Harus berupa angka"
  );
  disableFormFields(
    "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  );
  readonlyFormFields(
    "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  );
  $(".note").hide();
  $("#cariNikButton").addClass("disabled-button");
  $("#label-default").show();
  $("#cariNikButton").show();
  $("#instansiOption").show();
  $("#instansiText").hide();
  signaturePad.off();
  clearValues();
  // disableFormFields();
}

function onErrorHandlePegawaiStatus() {
  signaturePad.on();
  $(".note").hide();
  $("#asnNonAsnContainer").show();
  $("#cariNikButton").addClass("disabled-button");
  $("#cariNikButton").show();
  $("#label-default").show();
  $("#instansiOption").show();
  $("#instansiText").hide();
  $("#signatureCanvas").removeClass("greyed-out-form");
  $("#nip").attr("maxlength", "18");
  readonlyFormFields(
    "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu"
  );
  handlePegawaiNipInput();
}

function onErrorHandleTamuStatus() {
  // $("#instansiOption").hide();
  // $("#instansiText").show();
  // tamuAjax($("#nip").val());
  //get nip value
  var nipValue = $("#nip").val();
  restoreSavedValues(nipValue);
  tamuStatusClicked = false;
  $(".note").fadeIn(200);
  handleTamuNipInput();
}

// Function to handle status radio button click
var debounceTimeout;
function handleStatusRadioButtonClick() {
  // clearTimeout(debounceTimeout);

  // debounceTimeout = setTimeout(function () {
  var statusValue = $('input[name="statusRadio"]:checked');
  var asnNonAsnRadio = 'input[name="asnNonAsnRadio"]';
  $(asnNonAsnRadio).prop("checked", false);
  $(
    "#nip, #no_hp, #nama, #alamat, #asal_instansi_tamu, #asal_instansi_option"
  ).val("");
  if (statusValue.val() === "tamu") {
    // restoreSavedValues("tamu");
    handleTamuStatus();
  } else if (statusValue.val() === "pegawai") {
    // restoreSavedValues("pegawai");
    handlePegawaiStatus();
  }
  // }, 10);
}

// Function to handle NIP input change
function handleNipInputChange() {
  var statusValue = $('input[name="statusRadio"]:checked').val();

  if (statusValue === "pegawai") {
    handlePegawaiNipInput();
  } else if (statusValue === "tamu") {
    handleTamuNipInput();
  }
}

// Function to handle 'tamu' status
var tamuStatusClicked = false;

function handleTamuStatus() {
  signaturePad.on();
  if (!tamuStatusClicked) {
    $(".note").fadeIn(200); // add slide-in animation
    tamuStatusClicked = true;
  }
  $(".note").show(); // add slide-in animation

  enableFormFields(
    "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  );
  removeReadonlyFormFields(
    "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  );
  $("#asnNonAsnContainer").hide();
  $("#instansiOption").hide();
  $("#instansiText").show();
  $(
    "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  ).prop("readonly", false);
  $("#signatureCanvas").removeClass("greyed-out-form");
  $("#cariNikButton").hide();
  $("#label-nik").show();
  $("#label-default").hide();
  // add placeholder for nip input
  $("#nip").attr("placeholder", "Masukkan NIK");
}

// Function to handle 'pegawai' status
function handlePegawaiStatus() {
  var asnNonAsnRadio = 'input[name="asnNonAsnRadio"]';
  var statusValuePegawai = $(asnNonAsnRadio + ":checked");
  $(".note").hide();

  if (statusValuePegawai.length > 0) {
    // The radio button is already checked on page load
    removeReadonlyFormFields("#search, #nip");
    readonlyFormFields(
      "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    );
    enableFormFields(
      "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    );
    signaturePad.on();
  } else {
    readonlyFormFields(
      "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    );
  }
  $("#nip").attr("maxlength", "18");
  $("#cariNikButton").show();
  $("#asnNonAsnContainer").show();
  $("#instansiOption").show();
  $("#instansiText").hide();
  $("#label-default").show();
  $("#label-nik").hide();
  $("#nip").attr("placeholder", "Masukkan NIP");

  $(asnNonAsnRadio).on("click", function () {
    // console.log(statusValuePegawai);
    removeReadonlyFormFields("#search, #nip");
    enableFormFields(
      "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    );
    signaturePad.on();
  });
}

// Function to handle input change for 'pegawai' status
function handlePegawaiNipInput() {
  $("#nip").off("input");
  $("#nip").attr("maxlength", "18");

  $("#nip").on("input", function () {
    var nikValue = $(this).val();

    if (nikValue.length < 15) {
      $("#cariNikButton").addClass("disabled-button");
    } else {
      $("#cariNikButton").removeClass("disabled-button");
    }
  });

  handleCariNikButtonClick();
}

// Function to handle input change for 'tamu' status
function handleTamuNipInput() {
  var timeoutId;
  $("#nip").on("input", function () {
    $("#nip").attr("maxlength", "16");
    var nikValue = $(this).val();
    clearTimeout(timeoutId);

    if (nikValue.length === 0) {
      clearTamuFields();
    } else {
      $("#loadingIndicator").show();
      timeoutId = setTimeout(function () {
        tamuAjax(nikValue);
      }, 1000);
    }
  });
}

// Function to handle 'Cari NIK' button click
function handleCariNikButtonClick() {
  var initialClasses = "fa fa-search";
  var loadingClasses = "fa fa-circle-o-notch fa-spin";

  $("#cariNikButton")
    .off("click")
    .on("click", function () {
      $("#cariNikButton i").attr("class", loadingClasses);
      var nikValue = $("#nip").val();
      var statusValue = $('input[name="statusRadio"]:checked').val();
      var statusValuePegawai = $('input[name="asnNonAsnRadio"]:checked').val();

      // Additional validation logic if needed

      var apiEndpoint = getApiEndpoint(statusValuePegawai);
      console.log(apiEndpoint);

      if (nikValue.length > 0) {
        pegawaiAjax(apiEndpoint, nikValue);
      } else {
        handleCariNikButtonError(initialClasses);
      }
    });
}

// Function to clear 'tamu' fields
function clearTamuFields() {
  $("#no_hp, #nama, #alamat, #asal_instansi_tamu")
    .val("")
    .prop("readonly", false);
  $("#loadingIndicator").hide();
}

// Function to handle 'Cari NIK' button error
function handleCariNikButtonError(initialClasses) {
  $("#cariNikButton i").attr("class", initialClasses);
  Swal.fire({
    icon: "error",
    title: "NIK diperlukan",
    text: 'Masukkan nik sebelum klik "Cari".',
  });
}

// Function to enable form fields
function enableFormFields(elements) {
  $(elements).prop("disabled", false);
}

// Function to disable form fields
function disableFormFields(elements) {
  $(elements).prop("disabled", true);
}

function readonlyFormFields(elements) {
  $(elements).prop("readonly", true);
  $(elements).addClass("greyed-out-form");
}

function removeReadonlyFormFields(elements) {
  $(elements).prop("readonly", false);
  $(elements).removeClass("greyed-out-form");
}

// Function to get API endpoint based on statusValuePegawai
function getApiEndpoint(statusValuePegawai) {
  if (statusValuePegawai === "asn") {
    return "/api/pegawai/asn/";
  } else if (statusValuePegawai === "nonasn") {
    return "/api/pegawai/non-asn/";
  } else {
    // Handle the case when 'statusValuePegawai' is not set
    return "";
  }
}

var savedValues = {};
function saveCurrentValues(key, values) {
  // Save the values to savedValues object
  savedValues[key] = values;

  // Save the values to localStorage
  localStorage.setItem(key, JSON.stringify(values));
}

function restoreSavedValues(key) {
  // Get the saved values from localStorage
  const savedValuesFromLocalStorage = JSON.parse(localStorage.getItem(key));

  // If there are saved values from localStorage, restore them
  if (savedValuesFromLocalStorage) {
    // Update savedValues object for consistency
    savedValues[key] = savedValuesFromLocalStorage;

    $("#no_hp").val(savedValuesFromLocalStorage.no_hp);
    $("#nama").val(savedValuesFromLocalStorage.nama);
    $("#alamat").val(savedValuesFromLocalStorage.alamat);
    $("#asal_instansi_tamu").val(
      savedValuesFromLocalStorage.asal_instansi_tamu
    );
    // Add other form fields as needed
  }

  // Return the saved values
  return savedValuesFromLocalStorage;
}
// Function to clear all form values
function removeValues(key) {
  // Clear the form fields
  $("#no_hp, #nama, #alamat, #asal_instansi_tamu").val("");

  // Clear the saved values
  savedValues = {};

  // Remove the saved values from localStorage
  localStorage.removeItem(key);
}

function clearValues() {
  savedValues = {};
  localStorage.clear();
}

function setInputFilter(textboxes, errMsg) {
  if (textboxes && Array.isArray(textboxes)) {
    textboxes.forEach(function (textbox) {
      textbox.addEventListener("input", function () {
        const numericValue = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters

        if (this.value !== numericValue) {
          // Non-numeric characters were entered - block and show error
          this.value = numericValue;
          this.classList.add("input-error");
          this.setCustomValidity(errMsg);
          this.reportValidity();
        } else {
          // Numeric input - remove error
          this.classList.remove("input-error");
          this.setCustomValidity("");
          this.reportValidity();
        }
      });
    });
  }
}

const username = "meetingcheck";
const password = "meetingcheck%^2023";
function tamuAjax(nikValue) {
  $.ajax({
    url: base_url + "/api/peserta/" + nikValue, // Replace with your API endpoint
    type: "GET",
    beforeSend: function (xhr) {
      xhr.setRequestHeader(
        "Authorization",
        "Basic " + btoa(username + ":" + password)
      );
    },
    success: function (data) {
      console.log(data);
      console.log(data.status);
      if (!data.error) {
        if (data.status === false) {
          $("#loadingIndicator").hide();
          $("#no_hp, #nama, #alamat, #asal_instansi_tamu")
            .val("")
            .prop("readonly", false);
        } else if (data.status === true) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            toast: "true",
            position: "top-end",
            text: "Silahkan melakukan tanda tangan.",
            showConfirmButton: false, // Optionally, hide the "OK" button
            timer: 4000, // Auto-close the toast after 2 seconds (adjust the duration as needed)
          });
          nipValue = $("#nip").val();
          removeValues(nipValue);
          saveCurrentValues(nipValue, {
            no_hp: data.data.no_hp,
            nama: data.data.nama,
            alamat: data.data.alamat,
            asal_instansi_tamu: data.data.asal_instansi,
          });
          console.log(restoreSavedValues("tamu"));
          $("#loadingIndicator").hide();
          $("#signatureCanvas").removeClass("greyed-out-form");
          // $('#no_hp, #nama, #alamat, #asal_instansi_tamu').addClass('greyed-out-form');
          // Update the form fields with the fetched data
          $("#no_hp").val(data.data.no_hp).prop("readonly", false);
          $("#nama").val(data.data.nama).prop("readonly", false);
          $("#alamat").val(data.data.alamat).prop("readonly", false);
          $("#instansiText, #asal_instansi_tamu")
            .val(data.data.asal_instansi)
            .prop("readonly", false);
          // let no_hp = document.getElementById("no_hp");
          // no_hp.setAttribute("value", data.data.no_hp);
          // no_hp.value = data.data.no_hp;

          // let nama = document.getElementById("nama");
          // nama.setAttribute("value", data.data.nama);
          // nama.value = data.data.nama;

          // let alamat = document.getElementById("alamat");
          // alamat.setAttribute("value", data.data.alamat);
          // alamat.value = data.data.alamat;

          // let asal_instansi_tamu =
          //   document.getElementById("asal_instansi_tamu");
          // asal_instansi_tamu.setAttribute("value", data.data.asal_instansi);
          // asal_instansi_tamu.value = data.data.asal_instansi;
        }
      } else {
        $("#loadingIndicator").hide();
        Swal.fire({
          icon: "error",
          title: "Terjadi Kesalahan!",
          text: "Mohon tunggu beberapa saat dan coba lagi.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Handle errors if the AJAX request fails
      console.log("AJAX Error: " + textStatus);
    },
  });
}

function pegawaiAjax(apiEndpoint, nikValue) {
  var initialClasses = "fa fa-search";
  $.ajax({
    url: base_url + apiEndpoint + nikValue, // Replace with your API endpoint
    type: "GET",
    beforeSend: function (xhr) {
      xhr.setRequestHeader(
        "Authorization",
        "Basic " + btoa(username + ":" + password)
      );
    },
    success: function (data) {
      console.log(data);
      console.log(data.status);
      if (!data.error) {
        if (data.status === false) {
          // Handle the case where data is not found
          $("#no_hp, #nama, #alamat, #asal_instansi_option")
            .val("")
            .prop("readonly", false);
          // $("#loadingIndicator").hide();
          $("#cariNikButton i").attr("class", initialClasses);
          // Show an alert using SweetAlert when NIK is not found
          Swal.fire({
            icon: "error",
            title: "NIP Tidak ditemukan.",
            text: "NIP tidak ditemukan. Cek kembali NIP anda dan coba lagi.",
          });
        } else if (data.status === true) {
          // $("#loadingIndicator").hide();
          $("#cariNikButton i").attr("class", initialClasses);
          $("#cariNikButton").addClass("disabled-button");
          $("#nip").on("change", function () {
            $("#cariNikButton").removeClass("disabled-button");
          });
          Swal.fire({
            icon: "success",
            title: "Success!",
            toast: "true",
            position: "top-end",
            text: "Silahkan melakukan tanda tangan.",
            showConfirmButton: false, // Optionally, hide the "OK" button
            timer: 4000, // Auto-close the toast after 2 seconds (adjust the duration as needed)
          });
          $("#signatureCanvas").removeClass("greyed-out-form");
          signaturePad.on();
          // console.log(data);
          // $("#nip").val(data.data.nip).prop("readonly", false);
          $("#no_hp").val(data.data.no_hp).prop("readonly", true);
          $("#nama").val(data.data.nama_lengkap).prop("readonly", true);
          $("#alamat").val(data.data.alamat).prop("readonly", true);
          $("#instansiOption, #asal_instansi_option")
            .val(data.data.ket_ukerja)
            .prop("readonly", true);
        }
      } else {
        $("#cariNikButton i").attr("class", initialClasses);
        Swal.fire({
          icon: "error",
          title: "Terjadi Kesalahan!",
          text: "Mohon tunggu beberapa saat dan coba lagi.",
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Handle errors if the AJAX request fails
      console.log("AJAX Error: " + textStatus);
    },
  });
}

function validateRecaptcha() {
  // Use the grecaptcha object to check if the user has checked the reCAPTCHA.
  var recaptchaResponse = grecaptcha.getResponse();
  var recaptchaErrorElement = document.getElementById("recaptcha-error");

  if (recaptchaResponse.length === 0) {
    // User hasn't checked the reCAPTCHA, display an error message.
    recaptchaErrorElement.textContent = "centang reCAPTCHA terlebih dahulu.";
    return false;
  }

  // User has checked the reCAPTCHA, clear the error message and continue with form submission.
  recaptchaErrorElement.textContent = "";
  return true;
}

// custom invalid effect input nip
// function load() {
//     $("#cariNikButton i").removeClass("fa fa-search");
//     $("#cariNikButton i").addClass("fa fa-circle-o-notch fa-spin");

//     setTimeout(function() {
//         $("#cariNikButton i").removeClass("fa fa-circle-o-notch fa-spin");
//         $("#cariNikButton i").addClass("fa fa-search");
//     });
// }

// $(document).ready(function() {
//     $("#cariNikButton").on("click", load);

//     $("#input").on("keydown", function() {
//         if (event.keyCode == 13) load();
//     });
// });

var searchElement = document.getElementsByClassName("search")[0];
searchElement.addEventListener("focusin", function () {
  this.style.borderColor = "#007bff";
  this.style.boxShadow = "0 0 0 0.2rem rgba(0,123,255,.25)";
});

searchElement.addEventListener("focusout", function () {
  this.style.borderColor = "#ddd";
  this.style.boxShadow = "none";
});
