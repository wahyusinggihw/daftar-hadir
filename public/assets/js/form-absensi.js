/**
 * Sets an input filter on a textbox to only allow numeric input and displays an error message if non-numeric characters are entered.
 * @param {HTMLInputElement} textbox - The input element to set the filter on.
 * @param {string} errMsg - The error message to display if non-numeric characters are entered.
 */
function setInputFilter(textbox, errMsg) {
  if (textbox) {
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
  }
}

$(document).ready(function () {
  setInputFilter(document.getElementById("nip"), "Harus berupa angka");
  // label nik

  // INITIAL
  $("#label-default").show();
  $("#cariNikButton").hide();
  // $(
  //   "#search, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  // ).addClass("greyed-out-form");
  signaturePad.off();
  $(
    "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
  ).prop("disabled", true);
  $("#search, #signatureCanvas").addClass("greyed-out-form");

  // handle on error validation
  if ($('input[name="statusRadio"]:checked').val() === "tamu") {
    signaturePad.on();
    $(
      "#search, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu"
    ).removeClass("greyed-out-form");
    $(
      "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    ).prop("disabled", false);
    $(
      "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    ).prop("readonly", false);
    $("#signatureCanvas").removeClass("greyed-out-form");
  }

  if ($('input[name="statusRadio"]:checked').val() === "pegawai") {
    $("#nip").attr("maxlength", "18");
    signaturePad.on();
    $(
      "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu"
    ).addClass("greyed-out-form");
    $("#search").removeClass("greyed-out-form");
    $("#nip").prop("disabled", false);
    $("#cariNikButton").show();
    $(
      "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
    ).prop("disabled", false);
    $(
      "#no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu"
    ).prop("readonly", true);
    $("#asal_instansi_option").prop("readonly", true);
    $("#cariNikButton").addClass("disabled-button");

    $("#signatureCanvas").removeClass("greyed-out-form");
  }
  // end handle on validation

  $(".statusRadio").on("click", function () {
    var statusValue = $('input[name="statusRadio"]:checked').val();

    // Handle pegawai
    if (statusValue === "pegawai") {
      $("#label-default").show();
      $("#label-nik").hide();
      $("#cariNikButton").show();
      $("#cariNikButton i").addClass("fa fa-search");
      // $("#loadingIndicator").hide();
      $("#nip").off("input"); // Remove the input event for "pegawai"
      $("#nip").attr("maxlength", "18");
      // Handle pegawai
      $("#nip").on("input", function () {
        var nikValue = $(this).val();

        if (nikValue.length < 15) {
          $("#cariNikButton").addClass("disabled-button");
        } else {
          $("#cariNikButton").removeClass("disabled-button");
        }
      });
      var initialClasses = "fa fa-search";
      var loadingClasses = "fa fa-circle-o-notch fa-spin";

      $("#cariNikButton")
        .off("click")
        .on("click", function () {
          // $("#cariNikButton i").removeClass("fa fa-search");
          // $("#cariNikButton i").addClass("fa fa-circle-o-notch fa-spin");
          $("#cariNikButton i").attr("class", loadingClasses);
          var nikValue = $("#nip").val();
          var statusValue = $('input[name="statusRadio"]:checked').val();
          var statusValuePegawai = $(
            'input[name="asnNonAsnRadio"]:checked'
          ).val();
          console.log(statusValuePegawai);
          console.log(statusValue);

          if (!statusValue) {
            // Show an alert using SweetAlert when no radio button is selected
            Swal.fire({
              icon: "error",
              title: "Pilih Status",
              text: 'Pilih status "Pegawai" atau "Tamu" sebelum klik "Cari".',
            });
            return; // Exit the function
          }

          if (statusValuePegawai === "asn") {
            apiEndpoint = "/api/pegawai/asn/";
          } else if (statusValuePegawai === "nonasn") {
            apiEndpoint = "/api/pegawai/non-asn/";
          } else {
            // Handle the case when 'statusValuePegawai' is not set
          }

          console.log(apiEndpoint);

          if (nikValue.length > 0) {
            // Perform an AJAX request to check if the NIK exists
            pegawaiAjax(apiEndpoint, nikValue);
          } else {
            $("#cariNikButton i").attr("class", initialClasses);
            // $("#loadingIndicator").hide();
            // Show an alert using SweetAlert when NIK is empty
            Swal.fire({
              icon: "error",
              title: "NIK diperlukan",
              text: 'Masukkan nik sebelum klik "Cari".',
            });
          }
        });
    }

    // Handle tamu
    if (statusValue === "tamu") {
      $(
        "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
      ).prop("disabled", false);
      $(
        "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
      ).prop("readonly", false);
      $("#search, #signatureCanvas").addClass("greyed-out-form");
      $("#signatureCanvas").removeClass("greyed-out-form");
      signaturePad.on();
      $("#label-default").hide();
      $("#label-nik").show();
      // hide cari
      $("#nip").attr("maxlength", "16");
      $("#cariNikButton").hide();
      var timeoutId; // Store a timeout ID for delayed NIP input

      $("#nip").on("input", function () {
        var nikValue = $(this).val();
        clearTimeout(timeoutId); // Clear previous timeout

        if (nikValue.length === 0) {
          // Handle empty NIP input (clear other fields and hide loading)
          $("#no_hp, #nama, #alamat, #asal_instansi_tamu")
            .val("")
            .prop("readonly", false);
          $("#loadingIndicator").hide();
        } else {
          // Show loading indicator while user is still typing
          $("#loadingIndicator").show();

          // Set a timeout before making the AJAX request
          timeoutId = setTimeout(function () {
            tamuAjax(nikValue);
          }, 1000); // Adjust the delay (in milliseconds) as needed
        }
      });
    }
  });

  // Trigger the change event on 'nip' input when a radio button is clicked
  $(".statusRadio").on("click", function () {
    $("#nip, #no_hp, #nama, #alamat, #asal_instansi_tamu")
      .val("")
      .prop("readonly", false);
    $("#search").addClass("greyed-out-form");
    var isTamu = $('input[name="statusRadio"]:checked').val();
    if (isTamu === "tamu") {
      $(
        "#no_hp, #nama, #alamat, #asal_instansi_tamu, #signatureCanvas"
      ).removeClass("greyed-out-form");
      $("#no_hp, #nama, #alamat, #asal_instansi_tamu, #signatureCanvas").prop(
        "disabled",
        false
      );
      $("#search").removeClass("greyed-out-form");
      $("#cariNikButton").removeClass("disabled-button");
      $("#signatureCanvas").removeClass("greyed-out-form");
    } else {
      $(
        "#search, #nip, #no_hp, #nama, #alamat, #asal_instansi_option, #asal_instansi_tamu, #signatureCanvas"
      ).prop("disabled", false);
      $("#cariNikButton").addClass("disabled-button");
      $(
        "#no_hp, #nama, #alamat, #asal_instansi_option, #signatureCanvas"
      ).addClass("greyed-out-form");
      $("#no_hp, #nama, #alamat, #asal_instansi_option, #signatureCanvas").prop(
        "readonly",
        true
      );
    }
    $('input[name="asnNonAsnRadio"]').on("change", function () {
      // $("#cariNikButton").removeClass("disabled-button");
      // Check if one of the radio buttons is selected
      if ($('input[name="asnNonAsnRadio"]:checked').length > 0) {
        $("#search").removeClass("greyed-out-form");
        // search read only false
        $("#nip").prop("disabled", false);
        $("#nip").prop("readonly", false);
      }
    });

    $(".asnNonAsnRadio").prop("checked", false);
    $(this).prop("checked", true);
    $('input[name="asnNonAsnRadio"]').prop("checked", false);
    // Check the clicked radio button

    clearSignature();
    // Show/hide the 'instansiOption' and 'instansiText' divs based on the selected radio button
    if ($(this).val() === "pegawai") {
      $("#asnNonAsnContainer").show();
      $("#instansiOption").show();
      $("#instansiText").hide();
    } else {
      $("#asnNonAsnContainer").hide();
      $("#instansiOption").hide();
      $("#instansiText").show();
    }
  });
});

function tamuAjax(nikValue) {
  $.ajax({
    url: "/api/peserta/" + nikValue, // Replace with your API endpoint
    type: "GET",
    success: function (data) {
      console.log(data);
      console.log(data.status);
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
        console.log(data);
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
    url: apiEndpoint + nikValue, // Replace with your API endpoint
    type: "GET",
    success: function (data) {
      console.log(data.status);
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
        console.log(data);
        // $("#nip").val(data.data.nip).prop("readonly", false);
        $("#no_hp").val(data.data.no_hp).prop("readonly", true);
        $("#nama").val(data.data.nama_lengkap).prop("readonly", true);
        $("#alamat").val(data.data.alamat).prop("readonly", true);
        $("#instansiOption, #asal_instansi_option")
          .val(data.data.ket_ukerja)
          .prop("readonly", true);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Handle errors if the AJAX request fails
      console.log("AJAX Error: " + textStatus, errorThrown, jqXHR);
    },
  });
}

function validateRecaptcha() {
  // Use the grecaptcha object to check if the user has checked the reCAPTCHA.
  var recaptchaResponse = grecaptcha.getResponse();
  var recaptchaErrorElement = document.getElementById("recaptcha-error");

  if (recaptchaResponse.length === 0) {
    // User hasn't checked the reCAPTCHA, display an error message.
    recaptchaErrorElement.textContent = "Mohon centang reCAPTCHA.";
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
