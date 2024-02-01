@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

<style>

/* CSS */
.button-28 {
  appearance: none;
  background-color: transparent;
  border: 1px solid #6f9c9c;
  border-radius: 5px;
  box-sizing: border-box;
  color: #6f9c9c;
  cursor: pointer;
  display: inline-block;
  font-family: Roobert,-apple-system,BlinkMacSystemFont,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  font-size: 16px;
  font-weight: 600;
  line-height: normal;
  margin: 0;
  min-height: 50px;
  min-width: 0;
  outline: none;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  transition: all 300ms cubic-bezier(.23, 1, 0.32, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  width: 100%;
  will-change: transform;
}

.button-28:disabled {
  pointer-events: none;
}

.button-28:hover {
  color: #fff;
  background-color: #6571ff;
  border: 1px solid #6571ff;
  box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
  transform: translateY(-2px);
}

.active-uniq {
  color: #fff;
  background-color: #6571ff;
  border: 1px solid #6571ff;
  box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
  transform: translateY(-2px);
}

table {
			width: 100%;
			color: #333;
			font-family: Arial, sans-serif;
			font-size: 14px;
			text-align: left;
			margin: auto;
      border-radius: 10px;
      border: 1px solid #ccc;
		}
		table th {
			background-color: #f3f3f3;
			font-weight: bold;
			padding: 10px;
			letter-spacing: 1px;
			border-bottom: 1px solid #ccc;
      text-align: center;
		}
		table td {
			padding: 10px;
			border-bottom: 1px solid #ccc;
      margin-bottom: 100px; 
			font-weight: bold;
      text-align: center;
      vertical-align:top
		}
    .form-check-input{width:2em !important;height:2em !important;}
</style>
@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Roles y permisos</li>
  </ol>
</nav>

<div class="row">

  <h2>Roles y permisos</h2>
  <br><br>
  <div class="card">
      <br>
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label for="reclutador_id" class="form-label">Perfil</label>
            <select class="form-select" id="rol_id" name="rol_id">
              <option value="">Seleccionar el perfil</option>
                @foreach ($roles_det as $r)
                    <option value="{{ $r->id }}">{{ $r->rol }}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-6"></div>
      </div>
      <br><br>

      <div class="row" id="cambiarModulosPermisos" style="margin-bottom: 15px;">
        
      </div>
  </div>
  

</div>

<input type="hidden" id="id_modulo" name="id_modulo" />





@endsection

@push('custom-scripts')
  <script>
  
  $("#rol_id").change(function(){
    let id_rol = $("#rol_id").val();
    
    $.ajax({
        type: "POST",
        dataType: 'JSON',
        data: { modulo: 1 ,"_token": "{{ csrf_token() }}" },
        url: "getPermisosModulo/" + id_rol,
        success: function(msg){ 
          console.log(msg);

          $("#id_modulo").val(1);
          $("#cambiarModulosPermisos").html(msg);
          
        }
    }); 
  });

  function cargarRolPermiso(modulo_id){
    let id_rol = $("#rol_id").val();
    
    $.ajax({
        type: "POST",
        dataType: 'JSON',
        data: { modulo: modulo_id ,"_token": "{{ csrf_token() }}" },
        url: "getPermisosModulo/" + id_rol,
        success: function(msg){ 
          //console.log(msg);
          $("#id_modulo").val(modulo_id);
          $( "#cambiarModulosPermisos" ).fadeOut("fast" );
          $("#cambiarModulosPermisos").html(msg);
          $( "#cambiarModulosPermisos" ).fadeIn( "fast");
          
        }
    });
  }
  
  $(document).on("click", "#guardarPermisos", function(){

        let id_rol = $("#rol_id").val();
        let id_modulo = $("#id_modulo").val();

        if(id_rol == 0 || id_rol == ""){
          Swal.fire({
                      icon: 'warning',
                      html:
                        '<b>¡Advertencia!</b><br> ' +
                        'Selecciona un perfil',
                      showCloseButton: true,
                      showCancelButton: false,
                      focusConfirm: false,
                      showConfirmButton: false
                    });
            return;
        }

        let check1, check2, check3, check4, check5, check6;

        if($('#Check1').is(':checked')){
          check1 = 1;
        }
        else{
          check1 = 0;
        }

        if($('#Check2').is(':checked')){
          check2 = 1;
        }
        else{
          check2 = 0;
        }

        if($('#Check3').is(':checked')){
          check3 = 1;
        }
        else{
          check3 = 0;
        }

        if($('#Check4').is(':checked')){
          check4 = 1;
        }
        else{
          check4 = 0;
        }

        if($('#Check5').is(':checked')){
          check5 = 1;
        }
        else{
          check5 = 0;
        }

        if($('#Check6').is(':checked')){
          check6 = 1;
        }
        else{
          check6 = 0;
        }

        $("#guardarPermisos").attr("disabled",true);

            $.ajax({
                type: "POST",
                data: { id_rol: id_rol,
                        id_modulo: id_modulo,
                        check1: check1, 
                        check2 : check2,
                        check3: check3,
                        check4 : check4,
                        check5: check5,
                        check6 : check6,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/modifypermissions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Permisos modificados.",
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

                  $("#guardarPermisos").attr("disabled",false);
                },
                error: function (err) {
                  //console.log(err);
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
                    $("#guardarPermisos").attr("disabled",false);
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarCliente").click(function(){
      
      let idCliente = $("#idClienteEdit").val().trim();
      let names = $("#namesEdit").val().trim();
      let lastnames = $("#lastnamesEdit").val().trim();
      let recruiter = $("#reclutador_idEdit").val().trim();
      let telefono = $("#telefonoEdit").val().trim();
      let calle = $("#calleEdit").val().trim();
      let num_int = $("#num_intEdit").val().trim();
      let num_ext = $("#num_extEdit").val().trim();
      let codigo_postal = $("#codigo_postalEdit").val().trim();
      let ciudad = $("#ciudadEdit").val().trim();
      let estado = $("#estado_idEdit").val();

      //validar name
      if(names == '' || names == null){
          $("#invalid-names-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-names-required").removeClass("showFeedback");
      }

      //validar lastnames
      if(lastnames == '' || lastnames == null){
          $("#invalid-lastnames-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-lastnames-required").removeClass("showFeedback");
      }

      //validar recruiter
      if(recruiter == '' || recruiter == 0){
          $("#invalid-reclutador_idEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-reclutador_idEdit-required").removeClass("showFeedback");
      }

      if(erroresEdit > 0){
          erroresEdit = 0;
          $(".showErrorsEdit").css("display","flex");
          setTimeout(function(){
              $(".showErrorsEdit").css("display","none");
          }, 5000);
          return;
      }

      $("#modificarCliente").attr("disabled",true);
      $("#cancelarClienteEdit").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

          $.ajax({
              type: "PUT",
              data: { names: names, 
                      lastnames : lastnames,
                      recruiter: recruiter,
                      telefono : telefono,
                      calle : calle,
                      num_int : num_int,
                      num_ext : num_ext,
                      codigo_postal : codigo_postal,
                      ciudad : ciudad,
                      estado : estado,
                      "_token": "{{ csrf_token() }}" },
              dataType: 'JSON',
              url: "/clientactions/" + idCliente,
              success: function(msg){ 
                if(msg == '1'){

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "Cliente modificado",
                  });
                  table.ajax.reload();
                  $("#modificarClienteForm").trigger("reset");
                  $("#modificarClienteModal").modal('hide');
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

                $("#modificarCliente").attr("disabled",false);
                $("#cancelarClienteEdit").attr("disabled",false);
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

                  $("#modificarCliente").attr("disabled",false);
                  $("#cancelarClienteEdit").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });


    $(document).on("click", ".editar", function(){
      let id = this.id;

      $("#modificarClienteForm").trigger("reset");
      $("#erroresAgregarEditar").css('display','none');
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/clientactions/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#idClienteEdit").val(msg.id);
              $("#namesEdit").val(msg.nombres);
              $("#lastnamesEdit").val(msg.apellidos);
              $("#telefonoEdit").val(msg.telefono);
              $("#calleEdit").val(msg.calle);
              $("#num_intEdit").val(msg.num_int);
              $("#num_extEdit").val(msg.num_ext);
              $("#codigo_postalEdit").val(msg.codigo_postal);
              $("#ciudadEdit").val(msg.ciudad);
              $("#reclutador_idEdit").html(msg.recruiter_select);
              $("#estado_idEdit").html(msg.state_select);
              
              
              $("#modificarClienteModal").modal("show");
              
            }
        }); 
      
    });

    $(document).on("click", ".desactivar, .activar", function(){
        let id = this.id;
        let claseNombre = this.className; 
        let pregunta = '';
        let estado = '';

        if(claseNombre == 'desactivar operaciones'){
          pregunta = '¿Quieres inactivar este cliente?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este cliente?';
          estado = 'activo';
        }

        Swal.fire({
        title: pregunta,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        reverseButtons : true,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

            $.ajax({
                type: "DELETE",
                dataType: 'JSON',
                data: { "_token": "{{ csrf_token() }}" },
                url: "/clientactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Cliente " + estado,
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

        } else if (result.isDenied) {
            
        }
        })
        
  });

    $(document).on("change", "#names, #lastnames, #reclutador_id, #namesEdit, #lastnamesEdit, #reclutador_idEdit", function () {
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

    function replaceContenido(contenido)
    {
        let nuevo_contenido;

        if(contenido == "The names field is required.")
          nuevo_contenido = contenido.replace("The names field is required.", "El campo nombres es requerido.");
        
        if(contenido == "The lastnames field is required.")
          nuevo_contenido = contenido.replace("The lastnames field is required.", "El campo apellidos es requerido.");
        
        if(contenido == "The recruiter field is required.")
          nuevo_contenido = contenido.replace("The recruiter field is required.", "El campo reclutador es requerido.");
          
        return nuevo_contenido;
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
