@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
  </ol>
</nav>

<div class="row">

  <h2>Usuarios</h2>
  <div class="row">
    <div class="col-lg-12">
        <?php if($roles[1]->permitido == 1){ ?>
          <button class="btn btn-primary float-end" id="generarUsuarioNuevo" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">Agregar Usuario</button>
        <?php } ?>
    </div>
  </div>
  <br><br><br>

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table especial" id="table">
              <thead>
                 <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono/Celular</th>
                    <th>Rol</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                 </tr>
              </thead>
           </table>
          </div>
        </div>
      </div>
    </div>

</div>






<!-- MODALES -->
<!-- Agregar Modal -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarUsuario">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombre</label>
                <input type="text" class="form-control alpha-only" id="name" name="name" maxlength="255" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-name-required">El nombre es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input type="text" class="form-control email-only" id="email" name="email" maxlength="255" required placeholder="Correo">
                <div class="invalid-feedback" id="invalid-email-required">El correo es requerido</div>
                <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un correo válido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Teléfono/Celular</label>
                <input type="text" class="form-control numeric-only" id="phone" name="phone" maxlength="10" required placeholder="Teléfono/Celular">
              </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="rol" class="form-label">Rol</label>
              <select class="form-select" id="rol">
                <option selected disabled>Selecciona un rol</option>
                <?php 
                    foreach ($roles_det as $r) {
                      echo "<option value='".$r->id."'>".$r->rol."</option>";
                    }
                ?>
              </select>
              <div class="invalid-feedback" id="invalid-rol-required">El rol es requerido</div>
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
      </div>
      <div class="modal-footer">
        <button type="button"class="btn btn-secondary" id="cancelarUsuario" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarUsuario">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Editar Modal -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="modificarUsuarioForm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombre</label>
                <input type="text" class="form-control alpha-only" id="nameEdit" name="nameEdit" maxlength="255" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-nameEdit-required">El nombre es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="emailEdit" class="form-label">Correo</label>
                <input type="text" class="form-control email-only" id="emailEdit" name="emailEdit" maxlength="255" required placeholder="Correo">
                <div class="invalid-feedback" id="invalid-emailEdit-required">El correo es requerido</div>
                <div class="invalid-feedback" id="invalid-emailEdit-valid-required">Ingresa un correo válido</div>
              </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleInputUsername1" class="form-label">Cambiar contraseña</label>
              <input type="password" class="form-control" id="passwordEdit" name="passwordEdit" maxlength="40" required onkeyup="validar_clave_edit()" placeholder="Contraseña" />
              <div class="invalid-feedback" id="invalid-passwordEdit-required-">La contraseña es requerido</div>
              <div class="invalid-feedback" id="invalid-passwordEdit">La contraseña debe tener 10 caracteres minimo,
                  al menos una letra mayuscula, un número y un caracter especial permitido (@$!%*?&_-.).</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
              <label for="emailEdit" class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" id="confirm-passwordEdit" name="confirm-passwordEdit" maxlength="40" required />
              <div class="invalid-feedback" id="invalid-confirm-passwordEdit-required">Es necesario confirmar la contraseña</div>
              <div class="invalid-feedback" id="invalid-passEdit-confirm-valid">Las contraseñas no coinciden</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleInputUsername1" class="form-label">Teléfono/Celular</label>
              <input type="text" class="form-control numeric-only" id="phoneEdit" name="phoneEdit" maxlength="10" required placeholder="Teléfono/Celular">
            </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select class="form-select" id="rolEdit">
            </select>
            <div class="invalid-feedback" id="invalid-rolEdit-required">El rol es requerido</div>
          </div>
        </div>

          <div class="row">
            <div class="col-lg-12 invalid-feedback showErrors"><br>
              Completa los campos que se te piden
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregarEditar" style="display: none;">
            </div>
          </div>
          <div class="text-center" id="loadingSEdit" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="idUsuarioEdit" id="idUsuarioEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarModificarUsuario" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary me-2" id="modificarUsuario">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables/buttons.print.min') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script>
    let table;
    let exportar = <?php echo $roles[2]->permitido; ?>;
    let exportOptions = '';

    if(exportar == 1){
      exportOptions = 'Bfrtip';
    }
    else{
      exportOptions = '<lf<t>ip>';
    }

    $(function() {
          table = $('#table').DataTable({
          processing: true,
          serverSide: false,
          responsive: true,
          bLengthChange: false,
          drawCallback: function (settings, json) {
              //console.log(json);
              $('[data-toggle="tooltip"]').tooltip();
          },
          language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
          },
          dom: exportOptions,
            buttons: [
                {
                    extend:  'pdfHtml5',
                    className: 'btn-dark',
                    text: 'PDF',
                    title: 'Usuarios',
                    exportOptions: {
                            columns: [ 1,2, 3, 4,5, 6]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '6%', '27%', '27%', '12%',
                                                                '16%','12%'];
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-dark',
                    text: 'Excel',
                    exportOptions: {
                        columns: [ 1,2,3, 4, 5, 6]
                    },
                    title: 'Usuarios'
                }
          ],
          ajax: '{{ url('index') }}',
          columns: [
                   { data: 'avatar', name: 'avatar' },
                   { data: 'id', name: 'id' },
                   { data: 'name', name: 'name' },
                   { data: 'email', name: 'email' },
                   { data: 'phone', name: 'phone' },
                   { data: 'profile', name: 'profile' },
                   { data: 'state', name: 'state' },
                   { data: 'action', name: 'action' },
                ],
          "order": [],
          "columnDefs": [
              { "visible": false, "targets": 6 },
              { "orderable": false, "targets": 7 },
              { "orderable": false, "targets": 0 },
          ]
       });
    });

  let errores = 0;
  $("#guardarUsuario").click(function(){

        let name = $("#name").val().trim();
        let mail = $("#email").val().trim();
        let rol = $("#rol").val();
        let phone = $("#phone").val().trim();

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

        //validar rol
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
        $("#cancelarUsuario").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { name: name, 
                        email : mail,
                        rol: rol,
                        phone: phone,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/usersactions",
                success: function(msg){ 
                console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "¡Usuario agregado correctamente!",
                      });
                      table.ajax.reload();
                      $("#agregarUsuario").trigger("reset");
                      $("#agregarUsuarioModal").modal('hide');
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
                  $("#cancelarUsuario").attr("disabled",false);
                  $("#loadingS").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        console.log("min " +value);
                        contenido = replaceContenido(value[0]);
                        mensaje = mensaje + contenido + "<br>";
                        /*$("#" + key).next().html(value[0]);
                        $("#" + key).next().removeClass('d-none');*/
                    });
                    mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlerta">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button>';
                    $("#erroresAgregar").html(mensaje);
                    $("#erroresAgregar").css("display","flex");
                    $("#guardarUsuario").attr("disabled",false);
                    $("#cancelarUsuario").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarUsuario").click(function(){
      
      let idUsuario = $("#idUsuarioEdit").val().trim();
      let name = $("#nameEdit").val().trim();
      let mail = $("#emailEdit").val().trim();
      let password = $("#passwordEdit").val().trim();
      let confirm_password = $("#confirm-passwordEdit").val().trim();
      let rol = $("#rolEdit").val();
      let franquicia = $("#franchiseEdit").val();
      let phone = $("#phoneEdit").val().trim();
      let responsable;

      //validar name
     /* if(name == '' || name == null){
        $("#invalid-name-required-Edit").addClass("showFeedback");
        erroresEdit++;
      }
      else{
        $("#invalid-name-required-Edit").removeClass("showFeedback");
      }

      //validar email
      if(mail == '' || mail == null){
        $("#invalid-email-required-Edit").addClass("showFeedback");
        erroresEdit++;
      }
      else{
        $("#invalid-email-required-Edit").removeClass("showFeedback");
      }

      if(!isEmail(mail)){
        $("#invalid-email-valid-required-Edit").addClass("showFeedback");
        erroresEdit++;
      }
      else{
        $("#invalid-email-valid-required-Edit").removeClass("showFeedback");
      }

      //validar password
      if(password != ''){

          if(validar_clave_edit()){
            $("#invalid-passwordEdit").removeClass("showFeedback");
          }
          else{
            $("#invalid-passwordEdit").addClass("showFeedback");
            erroresEdit++;
          }
      
          if(password != confirm_password){
            $("#invalid-passEdit-confirm-valid").addClass("showFeedback");
            erroresEdit++;
          }
          else{
            $("#invalid-passEdit-confirm-valid").removeClass("showFeedback");
          }
      }

      //validar perfil
      if(rol == 0 || rol == null){
          $("#invalid-rolEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-rolEdit-required").removeClass("showFeedback");
      }

      if(erroresEdit > 0){
        erroresEdit = 0;
        $(".showErrorsEdit").css("display","flex");
        setTimeout(function(){
          $(".showErrorsEdit").css("display","none");
        }, 5000);
        return;
      }
*/
      $("#modificarUsuario").attr("disabled",true);
      $("#cancelarModificarUsuario").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

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
                  table.ajax.reload();
                  $("#editarUsuario").trigger("reset");
                  $("#editarUsuarioModal").modal('hide');
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

                $("#modificarUsuario").attr("disabled",false);
                $("#cancelarModificarUsuario").attr("disabled",false);
                $("#loadingSEdit").css("visibility","hidden");
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
                  $("#erroresAgregarEditar").html(mensaje);
                  $("#erroresAgregarEditar").css("display","flex");

                  $("#modificarUsuario").attr("disabled",false);
                  $("#cancelarModificarUsuario").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });


    $(document).on("click", ".editar", function(){
      let id = this.id;

      $("#editarUsuario").trigger("reset");
      $("#erroresAgregarEditar").css('display','none');
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/usersactions/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#nameEdit").val(msg.name);
              $("#emailEdit").val(msg.email);
              $("#rolEdit").html(msg.roles);
              $("#phoneEdit").val(msg.phone);
              $("#idUsuarioEdit").val(msg.id);
              $("#passwordEdit").val('');
              $("#confirm-passwordEdit").val('');
              
              $("#invalid-passwordEdit").removeClass("showFeedback");
              $("#editarUsuarioModal").modal("show");
              
            }
        }); 
      
    });

    $(document).on("click", ".desactivar, .activar", function(){
      let check = this.id;
        let array = check.split("_");
        let id = array[1];
        let claseNombre = this.className; 
        let pregunta = '';
        let estado = '';

        let state;
        if ($("#switch_" + id).is(':checked')) {
          state = 1;
        }
        else{
          state = 0
        }

        if(claseNombre == 'desactivar'){
          pregunta = '¿Quieres desactivar este usuario?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este usuario?';
          estado = 'activo';
        }

        Swal.fire({
        title: pregunta,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        reverseButtons : true,
        allowOutsideClick: false,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

            $.ajax({
                type: "DELETE",
                dataType: 'JSON',
                data: { "_token": "{{ csrf_token() }}" },
                url: "/usersactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Usuario " + estado,
                    });
                    table.ajax.reload();
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
                }
            });

        } else if (result.isDismissed) {
            
          if(claseNombre == 'desactivar'){

              if(state == 1){
                $("#switch_" + id).prop("checked",true);
              }
              if(state == 0){
                $("#switch_" + id).prop("checked",false);
              }
          }
          if(claseNombre == 'activar'){
              if(state == 1){
                $("#switch_" + id).prop("checked",true);
              }
              if(state == 0){
                $("#switch_" + id).prop("checked",false);
              }
          }

        }
        })
        
  });

    $(document).on("change", "#name, #rol, #nameEdit, #passwordEdit, #rolEdit", function () {
        let idModificado = $(this).attr('id');
        let value = $("#" + idModificado).val().trim();
        //console.log(idModificado + " ++ " + value);

        if(value == '' || value == null){
          $("#invalid-" + idModificado + "-required").addClass("showFeedback");
        }
        else{
          $("#invalid-" + idModificado + "-required").removeClass("showFeedback");
        }
    });

    $(document).on("change", "#confirm-passwordEdit", function () {
        let idModificado = $(this).attr('id');
        let value = $("#" + idModificado).val().trim();
        let passIni = $("#passwordEdit").val().trim();
        //console.log(idModificado + " ++ " + value);

        if(passIni != ''){
            if(value == '' || value == null){
              $("#invalid-" + idModificado + "-required").addClass("showFeedback");
            }
            else{
              $("#invalid-" + idModificado + "-required").removeClass("showFeedback");
            }

            if(passIni != value){
              $("#invalid-passEdit-confirm-valid").addClass("showFeedback");
            }
            else{
              $("#invalid-passEdit-confirm-valid").removeClass("showFeedback");
            }
        }
    });

    $(document).on("change", "#email, #emailEdit", function () {
        let idModificado = $(this).attr('id');
        let value = $("#" + idModificado).val().trim();
        //console.log(idModificado + " ++ " + value);

        if(value == '' || value == null){
          $("#invalid-" + idModificado + "-required").addClass("showFeedback");
        }
        else{
          $("#invalid-" + idModificado + "-required").removeClass("showFeedback");
        }

        if(!isEmail(value)){
          $("#invalid-" + idModificado + "-valid-required").addClass("showFeedback");
          errores++;
        }
        else{
          $("#invalid-" + idModificado + "-valid-required").removeClass("showFeedback");
        }
        
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
        let pass = $("#passwordEdit").val();

        if(pass != ''){

            const reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&-_.])[A-Za-z\d@$!%*?&-_.]{10,}$/;
            if (reg.test(pass)) {
              $("#invalid-passwordEdit").removeClass("showFeedback");
              return true;
            } else {
              $("#invalid-passwordEdit").addClass("showFeedback");
              return false;
            }
        }
    }

    $(document).on("click", "#cerrarAlerta", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#generarUsuarioNuevo", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaEditar", function () {
      $("#erroresAgregarEditar").css('display','none');
    });
  </script>
@endpush
