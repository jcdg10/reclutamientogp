$(document).ready(function () {
  /*Permitir solamente letras*/
  $(".alpha-only").on("input", function () {
    var regexp = /[^a-zA-ZñÑ& ]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".email-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @._-]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".rfc-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9nÑ&]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras y numeros*/
  $(".alphaNumeric-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @.&nÑ_-]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras, numeros,puntos y comas*/
  $(".alphaNumericDot-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @.,:-ñÑ&]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".alphaNumericDotAlter-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 .-ñÑ&]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras y numeros sin punto*/
  $(".alphaNumericNDot-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @ñÑ&]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras, numeros,puntos y comas, guiones*/
  $(".alphaNumericSpecial-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 áéíóúÁÉÍÓÚ°ñÑ@_.,:-]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });
  /*Permitir solamente numeros*/
  $(".numeric-only").on("input", function () {
    var regexp = /[^0-9]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });
  /*Permitir solamente numeros y ":" reloj*/
  $(".time-only").on("input", function () {
    var regexp = /[^0-9:]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir numero decimales */
  $(".numericDecimal-only").on("input", function () {
    var regexp = /[^\d.]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".numericTwoDecimal-only").on("input", function () {
    var regexp = /[^(\d+.\d{3})$]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(document).on('keypress', '.decimalesNegativosClass',  function(evt){

      var txt = $(this).val();
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.indexOf('.') === -1) {
          return true;
        } else {
          return false;
        }
      } 
      if (charCode == 45) {
        if (txt.indexOf('-') === -1) {
          return true;
        } else {
          return false;
        }
      }
      if (charCode == 47) {
          return false;
      }
      if (charCode != 45 || charCode != 46 || charCode != 47) {
        //console.log(charCode);
        if (charCode > 31 && 
          (charCode < 45 || charCode > 57 ))
          return false;
      }
      return true;

  });

  $(document).on('keypress', '.decimalesClass',  function(evt){

    var txt = $(this).val();
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
      //Check if the text already contains the . character
      if (txt.indexOf('.') === -1) {
        return true;
      } else {
        return false;
      }
    } 
    else {
      //console.log(charCode);
      if (charCode > 31 && 
        (charCode < 48 || charCode > 57 ))
        return false;
    }
    return true;

  });

});
