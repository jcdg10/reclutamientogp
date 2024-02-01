@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style='background-image:url("{{ URL::to('/') }}/assets/images/login-fondo.jpg")'>

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">Restablecer contraseña</a>
              <h5 class="text-muted fw-normal mb-4">Por favor ingresa otra contraseña.
              </h5>
              <form class="forms-sample">
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Correo:</label>
                  <input type="text" class="form-control" id="recoverEmail" readonly value="{{ $email }}">
                  <input type="hidden" id="token" name="token" value="{{ $token }}" />
                </div>
                <div class="mb-3">
                  <label for="resetPassword" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="resetPassword" placeholder="Contraseña">
                  <div class="invalid-feedback" id="invalid-password-required">La contraseña es requerida</div>
                  <div class="invalid-feedback" id="invalid-passUs" style="position:relative !important;">10 caracteres minimo, letra mayuscula, número y caracter especial permitido (@$!%*?&-_.).</div><div class="invalid-feedback" id="invalid-loginPassword-required"><span class="span-invalid-feedback">La contraseña es requerida</span></div>
                </div>
                <div class="mb-3">
                    <label for="resetPassword" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="resetConfirmPassword" placeholder="Contraseña">
                    <div class="invalid-feedback" id="invalid-pass-confirm-valid">Las contraseñas no coinciden</div>
                </div>
                <div class="form-check mb-3">
                  <!--  Alertas -->
                  <div class="invalid-feedback mostrarErroresServidor" id="erroresAgregar" style="display: none;"></div>
                  <center>
                  <div class="spinner-border text-primary" role="status" style="visibility:hidden;">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                  </center>
                </div>
                <div>
                  <button type="button" class="btn btn-primary me-2 mb-2 mb-md-0" id="reset-password">Restablecer</button>
                </div>
                <span class="d-block mt-4">
                    Tengo usuario y contraseña <br>
                    <a href="{{ url('/login') }}" class="mt-1 text-muted" style="color: #6571ff !important">Iniciar sesión</a>
                </span>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('custom-scripts')
<script src="{{ URL::to('/') }}/assets/js/main.js"></script>
<script>
let errores = 0;
$("#reset-password").click(function(){

    let password = $("#resetPassword").val().trim();
    let confirm_password = $("#resetConfirmPassword").val().trim();
    let token = $("#token").val().trim();
    let email = $("#recoverEmail").val().trim();

    $("#erroresAgregar").css("display","none");

    //validar password
    if(password == '' || password == null){
        $("#invalid-password-required").addClass("showFeedback");
        errores++;
    }
    else{
        $("#invalid-password-required").removeClass("showFeedback");
    }

    if(validar_clave()){
        $("#invalid-passUs").removeClass("showFeedback");
    }
    else{
        $("#invalid-passUs").addClass("showFeedback");
        errores++;
    }

    if(confirm_password == '' || confirm_password == null){
        $("#invalid-pass-confirm-required").addClass("showFeedback");
        errores++;
    }
    else{
        $("#invalid-pass-confirm-required").removeClass("showFeedback");
    }

    if(password != confirm_password){
        $("#invalid-pass-confirm-valid").addClass("showFeedback");
        errores++;
    }
    else{
        $("#invalid-pass-confirm-valid").removeClass("showFeedback");
    }

    if(errores > 0){
        errores = 0;
        return;
    }

    $('#reset-password').prop('disabled', true);
    $('.spinner-border').css('visibility','visible');
    
        $.ajax({
            type: "POST",
            data: { 
                    email : email,
                    token: token,
                    password: password,
                    password_confirmation: confirm_password,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/password/reset/" + token,
            success: function(msg){ 
                //console.log(msg);
                if(msg == '1'){
    
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Has cambiado tu contraseña exitosamente. Ahora serás redirigido.',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    setTimeout(function(){
                        window.location = "/login";
                    }, 3000);
                }

                if(msg == '0'){
                    
                    let timerInterval
                    Swal.fire({
                    title: '',
                    html: 'El link de activación ya no es válido, ahora será redirigido',
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                    }).then((result) => {
                    /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            //console.log('I was closed by the timer')
                            window.location = "/recuperar-password";
                        }
                    })

                }

                $('#reset-password').prop('disabled', false);
                $('.spinner-border').css('visibility','hidden');
            },
            error: function (err) {
                console.log(err);
                let mensaje = '';
                let contenido;
                $.each(err.responseJSON.errors, function (key, value) {
                    
                    contenido = replaceContenido(value[0]);
                    mensaje = mensaje + contenido + "<br>";
                    /*$("#" + key).next().html(value[0]);
                    $("#" + key).next().removeClass('d-none');*/
                });
                mensaje = mensaje + "<br>";
                $("#erroresAgregar").html(mensaje);
                $("#erroresAgregar").css("display","flex");

                $('#reset-password').prop('disabled', false);
                $('.spinner-border').css('visibility','hidden');
            }
        }); 
    });

    function replaceContenido(contenido)
    {
    let nuevo_contenido;
    if(contenido == "The password field is required.")
        nuevo_contenido = contenido.replace("The password field is required.", "El campo contraseña es requerido.");
    
    if(contenido == "The password confirmation field is required.")
        nuevo_contenido = contenido.replace("The password confirmation field is required.", "El campo confirmar contraseña es requerido.");
    
        return nuevo_contenido;
    }

    function validar_clave() {
        const pass = $("#resetPassword").val();

        if(pass == '' || pass == null){
            $("#invalid-pass-required").addClass("showFeedback");
        }
        else{
            $("#invalid-pass-required").removeClass("showFeedback");
        }

        const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&-_.])[A-Za-z\d@$!%*?&-_.]{10,}$/;
        if (reg.test(pass)) {
            document.getElementById("invalid-passUs").style.display = "none";
            return true;
        } else {
            document.getElementById("invalid-passUs").style.display = "block";
            return false;
        }
    }

    $(document).on("change", "#resetConfirmPassword", function () {
        let confirm_password = $("#resetConfirmPassword").val().trim();
        let password = $("#resetPassword").val().trim();

        if(confirm_password == '' || confirm_password == null){
            $("#invalid-pass-confirm-required").addClass("showFeedback");
        }
        else{
            $("#invalid-pass-confirm-required").removeClass("showFeedback");
        }

        if(password != confirm_password){
            $("#invalid-pass-confirm-valid").addClass("showFeedback");
        }
        else{
            $("#invalid-pass-confirm-valid").removeClass("showFeedback");
        }
    });
</script>
@endpush