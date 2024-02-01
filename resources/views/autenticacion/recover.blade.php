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
              <h5 class="text-muted fw-normal mb-4">Ingresa tu correo electrónico y te enviaremos un enlace para recuperar tu contraseña.
              </h5>
              <form class="forms-sample">
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Correo electrónico:</label>
                  <input type="text" class="form-control" id="recoverEmail" placeholder="Correo electrónico">
                  <div class="invalid-feedback" id="invalid-email-required"><span class="span-invalid-feedback">El correo es requerido</span></div>
                  <div class="invalid-feedback" id="invalid-email-valid-required"><span class="span-invalid-feedback">Ingresa un correo válido</span></div>
                  <div class="invalid-feedback mostrarErroresServidor" id="erroresAgregar" style="display: none;"></div>
                </div>
                <div class="form-check mb-1">
                  <!--  Alertas -->
                  <center>
                  <div class="spinner-border text-primary" role="status" style="visibility:hidden;">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                  </center>
                </div>
                <div>
                  <button type="button" class="btn btn-primary me-2 mb-2 mb-md-0" id="recuperar-pass">Enviar</button>
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
$("#recuperar-pass").click(function(){

    let mail = $("#recoverEmail").val().trim();
    
    //validar email
    if(mail == '' || mail == null){
        $("#invalid-email-required").addClass("showFeedback");
        errores++;
    }
    else{
        $("#invalid-email-required").removeClass("showFeedback");
    }

    if(!isEmail(mail)){
        $("#invalid-email-valid-required").addClass("showFeedback");
        errores++;
    }
    else{
        $("#invalid-email-valid-required").removeClass("showFeedback");
    }

    if(errores > 0){
        errores = 0;
        return;
    }

    $("#erroresAgregar").css("display","none");
    $('#recuperar-pass').prop('disabled', true);
    $('.spinner-border').css('visibility','visible');

        $.ajax({
            type: "POST",
            data: { 
                    email : mail,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/recuperar-password",
            success: function(msg){ 
                //console.log(msg);
                if(msg == '1'){
    
                    Swal.fire({
                        position: 'top-center',
                        icon: 'success',
                        title: 'Se ha enviado un correo a tu email registrado con las instrucciones para restablecer tu password. Ahora serás redirigido.',
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
                    html: 'Ha ocurrido un error. Vuelva a intentarlo.',
                    timer: 2000,
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
                        }
                    })

                }
                $('#recuperar-pass').prop('disabled', false);
                $('.spinner-border').css('visibility','hidden');
            },
            error: function (err) {
                //console.log(err);
                let mensaje = '';
                let contenido;
                $.each(err.responseJSON.errors, function (key, value) {
                    
                    contenido = replaceContenido(value[0]);
                    mensaje = mensaje + contenido + "<br>";
                    /*$("#" + key).next().html(value[0]);
                    $("#" + key).next().removeClass('d-none');*/
                });
                $("#erroresAgregar").html(mensaje);
                $("#erroresAgregar").css("display","flex");

                $('#recuperar-pass').prop('disabled', false);
                $('.spinner-border').css('visibility','hidden');
            }
        }); 
    });

    $(document).on("change", "#recoverEmail", function () {
        let email = $("#recoverEmail").val().trim();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if(email == '' || email == null){
            $("#invalid-email-required").addClass("showFeedback");
        }
        else{
            $("#invalid-email-required").removeClass("showFeedback");
        }

        //validar si el email esta validado
        if (!isEmail(email)) {
            $("#invalid-email-valid-required").addClass("showFeedback");
        }
        else {
            $("#invalid-email-valid-required").removeClass("showFeedback");
        }
    });

    function isEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        return emailReg.test(email);
    }

    function replaceContenido(contenido)
    {
        let nuevo_contenido;
        nuevo_contenido = contenido.replace("name", "nombre");
        nuevo_contenido = contenido.replace("email", "correo");
        nuevo_contenido = contenido.replace("The selected email is invalid.", "El correo seleccionado es inválido.");
        return nuevo_contenido;
    }
</script>
@endpush