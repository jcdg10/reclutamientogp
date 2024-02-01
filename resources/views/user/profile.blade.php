@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
  </ol>
</nav>


<div class="row profile-body">
  <!-- left wrapper start -->
  <div class="d-none d-md-block col-md-6 col-xl-4 left-wrapper">
    <div class="card rounded">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h6 class="card-title mb-0">Acerca de:</h6>
        </div>
        <div class="d-flex align-items-center">
          <?php 
              $words = explode(" ", auth()->user()->name);

              $nombreIniciales = '';
              foreach ($words as $w) {
                  $nombreIniciales .= $w . '+'; 
              }
          ?>
          <img class="img-sm rounded-circle" src="https://ui-avatars.com/api/?name={{ $nombreIniciales }}" alt="">													
          <div class="ms-2">
            <p>{{ auth()->user()->name }}</p>
          </div>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Correo electrónico:</label>
          <p class="text-muted"><a href="mailto:{{ auth()->user()->email }}" class="hp-p1-body">{{ auth()->user()->email }}</a></p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Perfil:</label>
          <p class="text-muted">
              <?php 
                  foreach($roles_det as $r){
                    if($r->id == auth()->user()->roles_id){
                      echo $r->rol;
                    }
                  }
              ?>
          </p>
        </div>
        <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Teléfono/Celular:</label>
          <p class="text-muted">&nbsp;{{ auth()->user()->phone }}</p>
        </div>
      </div>
    </div>
  </div>
  <!-- left wrapper end -->
  <!-- middle wrapper start -->
  <div class="col-md-6 col-xl-8 middle-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card rounded">
          <div class="card-body">
            
            <div class="row">

              <div class="col-md-6">
                  <div class="mb-3">
                    <label for="exampleInputUsername1" class="form-label">Nombre</label>
                    <input type="text" class="form-control alpha-only" id="name" name="name" maxlength="255" required placeholder="Nombre" value="{{ auth()->user()->name }}">
                    <div class="invalid-feedback" id="invalid-name-required">El nombre es requerido</div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="mb-3">
                    <label for="email" class="form-label">Correo</label>
                    <input type="text" class="form-control email-only" id="email" name="email" maxlength="255" required placeholder="Correo" value="{{ auth()->user()->email }}">
                    <div class="invalid-feedback" id="invalid-email-required">El correo es requerido</div>
                    <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un correo válido</div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="mb-3">
                    <label for="exampleInputUsername1" class="form-label">Teléfono/Celular</label>
                    <input type="text" class="form-control numeric-only" id="phone" name="phone" maxlength="10" required placeholder="Teléfono/Celular" value="{{ auth()->user()->phone }}">
                  </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="rol" class="form-label">Rol</label>
                  <select class="form-select" id="rol">
                    <option selected disabled>Selecciona un rol</option>
                    <?php 
                        foreach ($roles_det as $r) {
                          echo "<option value='".$r->id."' ";

                            if($r->id == auth()->user()->roles_id){
                              echo "selected";
                            }
                            
                          echo ">".$r->rol."</option>";
                        }
                    ?>
                  </select>
                  <div class="invalid-feedback" id="invalid-rol-required">El rol es requerido</div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="exampleInputUsername1" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="password" name="password" maxlength="40" required onkeyup="validar_clave_edit()" placeholder="Contraseña" />
                  <div class="invalid-feedback" id="invalid-password-required">La contraseña es requerido</div>
                  <div class="invalid-feedback" id="invalid-password">La contraseña debe tener 10 caracteres minimo,
                      al menos una letra mayuscula, un número y un caracter especial permitido (@$!%*?&_-.).</div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                      <label for="confirm-password" class="form-label">Confirmar contraseña</label>
                      <input type="password" class="form-control" id="confirm-password" name="confirm-password" maxlength="40" required />
                      <div class="invalid-feedback" id="invalid-confirm-password-required">Es necesario confirmar la contraseña</div>
                      <div class="invalid-feedback" id="invalid-pass-confirm-valid">Las contraseñas no coinciden</div>
                    </div>
                </div>
    
              <div class="row">
                <div class="col-lg-12 invalid-feedback showErrors"><br>
                  Completa los campos que se te piden
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                </div>
              </div>
              <div class="text-center" id="loadingS" style="visibility: hidden;">
                <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
              </div>

          </div>
          <div class="card-footer">
            <input type="hidden" name="idUsuarioEdit" id="idUsuarioEdit" value="{{ auth()->user()->id }}" />
            <button type="button" class="btn btn-primary me-2 float-end" id="guardarUsuario">Modificar</button>
          </div>
        </div>
      </div>

      

    </div>
  </div>
  <!-- middle wrapper end -->
  

</div>





@endsection

@push('custom-scripts')

<script>
    let errores = 0;
    $("#guardarUsuario").click(function(){
      
      let idUsuario = $("#idUsuarioEdit").val().trim();
      let name = $("#name").val().trim();
      let mail = $("#email").val().trim();
      let password = $("#password").val().trim();
      let confirm_password = $("#confirm-password").val().trim();
      let rol = $("#rol").val();
      let franquicia = $("#franchise").val();
      let phone = $("#phone").val().trim();
      let responsable;

      //validar name
      if(name == '' || name == null){
        $("#invalid-name-required").addClass("showFeedback");
        errores++;
      }
      else{
        $("#invalid-name-required").removeClass("showFeedback");
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

      //validar password
      if(password != ''){

          if(validar_clave_edit()){
            $("#invalid-password").removeClass("showFeedback");
          }
          else{
            $("#invalid-password").addClass("showFeedback");
            errores++;
          }
      
          if(password != confirm_password){
            $("#invalid-pass-confirm-valid").addClass("showFeedback");
            errores++;
          }
          else{
            $("#invalid-pass-confirm-valid").removeClass("showFeedback");
          }
      }

      //validar perfil
      if(rol == 0 || rol == null){
          $("#invalid-rol-required").addClass("showFeedback");
          errores++;
      }
      else{
          $("#invalid-rol-required").removeClass("showFeedback");
      }

      if(errores > 0){
        errores = 0;
        $(".showErrors").css("display","flex");
        setTimeout(function(){
          $(".showErrors").css("display","none");
        }, 5000);
        return;
      }

      $("#guardarUsuario").attr("disabled",true);
      $("#loadingS").css("visibility","visible");

          $.ajax({
              type: "PUT",
              data: { name: name, 
                      email : mail,
                      password: password, 
                      rol: rol,
                      phone: phone,
                      "_token": "{{ csrf_token() }}" },
              dataType: 'JSON',
              url: "/usersactions/" + idUsuario,
              success: function(msg){ 
                if(msg == '1'){

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "¡Usuario modificado correctamente!",
                  });

                }
                if(msg == '0'){
                  Swal.fire({
                      icon: 'warning',
                      html:
                        '<b>¡Error inesperado!</b><br> ' +
                        'Ha ocurrido un error inesperado, favor de contactar a Soporte Técnico',
                      showCloseButton: true,
                      showCancelButton: false,
                      focusConfirm: false,
                      showConfirmButton: false
                  });
                }

                $("#guardarUsuario").attr("disabled",false);
                $("#loadingS").css("visibility","hidden");
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
                  mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaEditar">' +
                  '<span aria-hidden="true">&times;</span>' +
                  '</button>';
                  $("#erroresAgregar").html(mensaje);
                  $("#erroresAgregar").css("display","flex");

                  $("#guardarUsuario").attr("disabled",false);
                  $("#loadingS").css("visibility","hidden");
              }
          }); 

    });

    function isEmail(email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

      return emailReg.test(email);
    }

    function replaceContenido(contenido)
    {
        let nuevo_contenido;

        if(contenido == "The name field is required.")
          nuevo_contenido = contenido.replace("The name field is required.", "El campo nombre es requerido.");
        
        if(contenido == "The email field is required.")
          nuevo_contenido = contenido.replace("The email field is required.", "El campo correo electrónico es requerido.");
        
          if(contenido == "The email has already been taken.")
          nuevo_contenido = contenido.replace("The email has already been taken.", "El correo electrónico ya está registrado.");
          
        if(contenido == "The rol field is required.")
          nuevo_contenido = contenido.replace("The rol field is required.", "El campo rol es requerido.");

        return nuevo_contenido;
    }

    function validar_clave_edit() {
        let pass = $("#password").val();

        if(pass != ''){

            const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&-_.])[A-Za-z\d@$!%*?&-_.]{10,}$/;
            if (reg.test(pass)) {
              $("#invalid-password").removeClass("showFeedback");
              return true;
            } else {
              $("#invalid-password").addClass("showFeedback");
              return false;
            }
        }
    }

    $(document).on("click", "#cerrarAlerta", function () {
      $("#erroresAgregar").css('display','none');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/lobibox@1.2.7/dist/js/lobibox.min.js"></script>
@endpush