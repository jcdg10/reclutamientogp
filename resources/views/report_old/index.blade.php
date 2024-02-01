@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reportes</li>
  </ol>
</nav>

<div class="row">

  <h2>Reportes</h2>
  <div class="row">
    <div class="col-lg-12">
        <button class="btn btn-primary float-end" id="generarReporteNuevo" data-bs-toggle="modal" data-bs-target="#agregarReporteModal">Agregar reporte</button>
    </div>
  </div>
  <br><br><br>


    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table" id="table">
              <thead>
                 <tr>
                    <th>Id</th>
                    <th>Nombre del reporte</th>
                    <th>Subido</th>
                    <th></th>
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
<div class="modal fade" id="agregarReporteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarReporte" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control alphaNumeric-only" id="nombre" name="nombre" maxlength="80" required placeholder="Nombres">
                <div class="invalid-feedback" id="invalid-nombre-required">El nombre del reporte es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Adjuntar reporte</label>
                <input type="file" id="archivo" name="archivo" class="form-control" accept="application/pdf"/>
                <div class="invalid-feedback" id="invalid-archivo-required">Necesitas adjuntar un archivo</div>
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
        <button type="button"class="btn btn-secondary" id="cancelarReporte" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarReporte">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Editar Modal -->
<div class="modal fade" id="editarReclutadorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="modificarReclutadorForm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Reclutador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombre</label>
                <input type="text" class="form-control alpha-only" id="nombresEdit" name="nombresEdit" maxlength="255" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-nombresEdit-required">Los nombres son requeridos</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Apellidos</label>
                <input type="text" class="form-control alpha-only" id="apellidosEdit" name="apellidosEdit" maxlength="45" required placeholder="Apellidos">
                <div class="invalid-feedback" id="invalid-apellidosEdit-required">Los apellidos son requeridos</div>
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
        <input type="hidden" name="idReclutadorEdit" id="idReclutadorEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarModificarReclutador" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarReclutador">Modificar</button>
      </div>
    </div>
    </form>
  </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script>
    let table;
    $(function() {
          table = $('#table').DataTable({
          processing: true,
          serverSide: false,
          responsive: true,
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
          ajax: '{{ url('report.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'reporte', name: 'reporte' },
                   { data: 'fechalta', name: 'fechalta' },
                   { data: 'action', name: 'action' }
                ],
          "columnDefs": [
              { "visible": false, "targets": 0 },
              { "orderable": false, "targets": 3 },
          ]
       });
    });

  let errores = 0;
  $("#guardarReporte").click(function(){

        let nombre = $("#nombre").val().trim();
        let archivo = $("#archivo").val().trim();

        //validar nombre
        if(nombre == '' || nombre == null){
            $("#invalid-nombre-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-nombre-required").removeClass("showFeedback");
        }

        //validar archivo
        if(archivo == '' || archivo == null){
            $("#invalid-archivo-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-archivo-required").removeClass("showFeedback");
        }

        let formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('archivo', $('#archivo')[0].files[0]);
        formData.append('_token', "{{ csrf_token() }}");

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarReporte").attr("disabled",true);
        $("#cancelarReporte").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: formData ,
                cache:false,
                contentType: false,
                processData: false,
                url: "/reportactions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Reporte agregado",
                      });
                      table.ajax.reload();
                      $("#agregarReporte").trigger("reset");
                      $("#agregarReporteModal").modal('hide');
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

                  $("#guardarReporte").attr("disabled",false);
                  $("#cancelarReporte").attr("disabled",false);
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
                    $("#guardarReporte").attr("disabled",false);
                    $("#cancelarReporte").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarReclutador").click(function(){
      
      let idReclutador = $("#idReclutadorEdit").val().trim();
      let names = $("#nombresEdit").val().trim();
      let lastnames = $("#apellidosEdit").val().trim();

      //validar nombres
      if(names == '' || names == null){
          $("#invalid-nombresEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-nombresEdit-required").removeClass("showFeedback");
      }

      //validar lastnames
      if(lastnames == '' || lastnames == null){
          $("#invalid-apellidosEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-apellidosEdit-required").removeClass("showFeedback");
      }

      if(erroresEdit > 0){
        erroresEdit = 0;
        $(".showErrorsEdit").css("display","flex");
        setTimeout(function(){
          $(".showErrorsEdit").css("display","none");
        }, 5000);
        return;
      }

      $("#modificarReclutador").attr("disabled",true);
      $("#cancelarModificarReclutador").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

          $.ajax({
              type: "PUT",
              data: { names: names, 
                      lastnames : lastnames,
                      "_token": "{{ csrf_token() }}" },
              dataType: 'JSON',
              url: "/recruiteractions/" + idReclutador,
              success: function(msg){ 
                if(msg == '1'){

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "Reclutador modificado",
                  });
                  table.ajax.reload();
                  $("#modificarReclutadorForm").trigger("reset");
                  $("#editarReclutadorModal").modal('hide');
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

                $("#modificarReclutador").attr("disabled",false);
                $("#cancelarModificarReclutador").attr("disabled",false);
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

                  $("#modificarReclutador").attr("disabled",false);
                  $("#cancelarModificarReclutador").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });


    $(document).on("click", ".editar", function(){
      let id = this.id;

      $("#modificarReclutadorForm").trigger("reset");
      $("#erroresAgregarEditar").css('display','none');
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/recruiteractions/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#nombresEdit").val(msg.nombres);
              $("#apellidosEdit").val(msg.apellidos);
              $("#idReclutadorEdit").val(msg.id);
              
              $("#editarReclutadorModal").modal("show");
              
            }
        }); 
      
    });

    $(document).on("click", ".descargarReporte ", function(){
      let id = this.id;
      let filename = $("#" + id).attr("name") + ".pdf";
        $.ajax({
            type: "GET",
            data: { "_token": "{{ csrf_token() }}" },
            url: "/reportedownload/" + id,
            xhrFields: {
                responseType: 'blob'
            },
            success: function(msg){ 

              //console.log(msg);
              var blob = new Blob([msg]);
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.download = filename;
              link.click();
              
            },
            error: function(blob){
                console.log(blob);
            }
        }); 
      
    });

    $(document).on("click", ".eliminarReporte", function(){
        let id = this.id;

        Swal.fire({
          title: '¿Quieres eliminar este reporte?',
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
                url: "/reportactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Reporte eliminado.",
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

    $(document).on("change", "#nombres, #apellidos, #nombresEdit, #apellidosEdit", function () {
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
