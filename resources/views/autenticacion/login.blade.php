@extends('layout.master2')

@section('cssextra')
<style>
.main-wrapper .page-wrapper .page-content {
    padding: 0px !important;
}
.special-margin {
    padding-right: 0 !important;
    padding-left: 0 !important;
    overflow-x: hidden;
}
</style>
@endsection
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 h-100 mx-0 auth-page">
    <div class="col-md-12 col-xl-12 mx-auto special-margin">

        <div class="row h-100">
          <div class="col-md-6 pe-md-0">
            <div class="auth-side-wrapper" style='background-image:url("{{ URL::to('/') }}/assets/images/login-fondo.jpg")'>

            </div>
          </div>
          <div class="col-md-6 ps-md-0">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="auth-form-wrapper px-4 py-5">
                    <a href="#" class="noble-ui-logo d-block mb-2">Reclutamiento</a>
                    <h5 class="text-muted fw-normal mb-4">Bienvenido, por favor ingresa a tu cuenta.
                    </h5>
                    <form class="forms-sample">
                        <div class="mb-3">
                        <label for="userEmail" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="email" placeholder="Email" style="width: 80%;">
                        <div class="invalid-feedback" id="invalid-email-required"><span class="span-invalid-feedback">El correo/usuario es requerido</span></div>
                        <div class="invalid-feedback" id="invalid-email-valid-required"><span class="span-invalid-feedback">Ingresa un correo válido</span></div>
                        </div>
                        <div class="mb-3">
                        <label for="userPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" autocomplete="current-password" placeholder="Password" style="width: 80%;">
                        <div class="invalid-feedback" id="invalid-loginPassword-required"><span class="span-invalid-feedback">La contraseña es requerida</span></div>
                        </div>
                        <div class="form-check mb-3">
                        <!--  Alertas -->
                        <center>
                        <div class="spinner-border text-primary" role="status" style="visibility:hidden;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        </center>
                        </div>
                        <div>
                        <button type="button" class="btn btn-primary me-2 mb-2 mb-md-0" id="login">Ingresar</button>
                        </div>
                        <a href="{{ url('/recuperar-password') }}" class="d-block mt-3 text-muted">Restablecer contraseña</a>
                    </form>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>

          </div>
        </div>

    </div>
  </div>

</div>
@endsection

@push('custom-scripts')
<script src="{{ URL::to('/') }}/assets/js/main.js"></script>
    <script type="text/javascript">
    let errores = 0;
    let minutos = {{ $tiempo->valor }};
    let intentos = {{ $intentos->valor }} - 1;

    if (localStorage.getItem('intentos') === null) {
        localStorage.setItem('intentos',0);
    }

    $("#login").click(function(){

        let password = $("#loginPassword").val().trim();
        let mail = $("#email").val().trim();

        if(localStorage.getItem('intentos') > intentos){

            let tiempoLimite = new Date($.now());
            let tiempoActual = new Date($.now());
            tiempoLimite.addMinutes(); 

            let retrievedObject = localStorage.getItem('hora');

            if (!Date.parse(retrievedObject)) {
                if (JSON.parse(retrievedObject) === null) {
                localStorage.setItem('hora',tiempoLimite);
                //console.log(localStorage.getItem('hora'));
                }
            }

            if(new Date(localStorage.getItem('hora')) < new Date(tiempoActual))
            {
                limpiarValores();
            }
            else
            {

                let timerInterval
                Swal.fire({
                title: '',
                html: 'No puedes ingresar por ' + minutos + ' minutos.',
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
                return;
            }

        }
        
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

        //validar name
        if(password == '' || password == null){
            $("#invalid-loginPassword-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-loginPassword-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            return;
        }

        $('#login').prop('disabled', true);
        $('.loader-personalisado').css('visibility','visible');

            $.ajax({
                type: "POST",
                data: { password: password, 
                        email : mail,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/login",
                success: function(msg){ 
                    //console.log(msg);
                    if(msg == '1'){
        
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: '¡Ingreso exitoso! Ahora serás redigirido',
                            showConfirmButton: false,
                            timer: 1500
                        })

                        limpiarValores();

                        setTimeout(function(){
                            window.location = "/";
                        }, 1500);
                    }

                    if(msg == '0'){
                        
                        let timerInterval
                        Swal.fire({
                        title: '',
                        html: 'Tu correo y/o contraseña son incorrectos. Vuelva a intentarlo.',
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
                        localStorage.intentos++;
                    }

                    if(msg == '2'){
                        let timerInterval
                        Swal.fire({
                        title: '',
                        html: 'El usuario esta desactivado.',
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
                    if(msg == '3'){
                        let timerInterval
                        Swal.fire({
                        title: '',
                        html: 'El usuario no fue localizado. Intente nuevamente',
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

                    $('#login').prop('disabled', false);
                    $('.loader-personalisado').css('visibility','hidden');
                }
            }); 
      });

      $(document).on("change", "#email", function () {
            let email = $("#email").val().trim();
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

       $(document).on("change", "#loginPassword", function () {
            let password = $("#loginPassword").val().trim();

            if(password == '' || password == null){
                $("#invalid-loginPassword-required").addClass("showFeedback");
            }
            else{
                $("#invalid-loginPassword-required").removeClass("showFeedback");
            }
       });

       function isEmail(email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

            return emailReg.test(email);
       }

       Date.prototype.addMinutes = function(){
            return this.setMinutes(this.getMinutes() + minutos);
       }

       function limpiarValores()
       {
            localStorage.setItem('intentos',0);
            localStorage.setItem('hora',null);
       }

       var inputEmail = document.getElementById("email");

        inputEmail.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("login").click();
        }
        });

        var inputPassword = document.getElementById("loginPassword");

        inputPassword.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("login").click();
        }
        });
    </script>
    @endpush