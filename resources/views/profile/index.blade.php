@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
  </ol>
</nav>

<div class="row">

  <h2>Perfil</h2>
  <div class="row">
    <div class="col-lg-12">
        <?php if($roles[1]->permitido == 1){ ?>
          <button class="btn btn-primary float-end" id="generarPerfilNuevo" data-bs-toggle="modal" data-bs-target="#agregarPerfilModal">Agregar perfil</button>
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
                    <th>Id</th>
                    <th>Perfil</th>
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
<div class="modal fade" id="agregarPerfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarPerfil">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-nombre-required">El nombre es requerido</div>
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
        <button type="button"class="btn btn-secondary" id="cancelarPerfil" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarPerfil">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Editar Modal -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="modificarPerfilForm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombreEdit" name="nombreEdit" maxlength="100" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-nombreEdit-required">El nombre es requerido</div>
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
        <input type="hidden" name="idPerfilEdit" id="idPerfilEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarPerfil" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarPerfil">Guardar</button>
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
                    title: 'Perfil',
                    exportOptions: {
                            columns: [ 0, 1, 2]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '10%', '55%', '35%'];
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-dark',
                    text: 'CSV',
                    title: 'Perfil',
                    exportOptions: {
                        columns: [ 0, 1, 2]
                    },
                    customize: function (csv) {
                    var split_csv = csv.split("\n");
    
                    //Remove the row one to personnalize the headers
                    split_csv[0] = '"ID","Nombre","Estatus"';
                    csv = split_csv.join("\n");
                    return csv;
                    }
                }
          ],
          ajax: '{{ url('profile.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'perfil', name: 'perfil' },
                   { data: 'state', name: 'state' },
                   { data: 'action', name: 'action' },
                ],
          "order": [],
          "columnDefs": [
              { "visible": false, "targets": 2 },
              { "orderable": false, "targets": 3 },
          ]
       });
    });

  let errores = 0;
  $("#guardarPerfil").click(function(){

        let name = $("#nombre").val().trim();

        //validar nombre
        if(name == '' || name == null){
            $("#invalid-nombre-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-nombre-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarPerfil").attr("disabled",true);
        $("#cancelarPerfil").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { name: name, 
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/profileactions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Perfil agregado.",
                      });
                      table.ajax.reload();
                      $("#agregarPerfil").trigger("reset");
                      $("#agregarPerfilModal").modal('hide');
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

                  $("#guardarPerfil").attr("disabled",false);
                  $("#cancelarPerfil").attr("disabled",false);
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
                    $("#guardarPerfil").attr("disabled",false);
                    $("#cancelarPerfil").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarPerfil").click(function(){
      
      let idPerfil = $("#idPerfilEdit").val().trim();
      let name = $("#nombreEdit").val().trim();

      //validar nombres
      if(name == '' || name == null){
          $("#invalid-nombreEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-nombreEdit-required").removeClass("showFeedback");
      }

      if(erroresEdit > 0){
        erroresEdit = 0;
        $(".showErrorsEdit").css("display","flex");
        setTimeout(function(){
          $(".showErrorsEdit").css("display","none");
        }, 5000);
        return;
      }

      $("#modificarPerfil").attr("disabled",true);
      $("#cancelarModificarPerfil").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

          $.ajax({
              type: "PUT",
              data: { name: name,
                      "_token": "{{ csrf_token() }}" },
              dataType: 'JSON',
              url: "/profileactions/" + idPerfil,
              success: function(msg){ 
                if(msg == '1'){

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "Perfil modificado.",
                  });
                  table.ajax.reload();
                  $("#modificarPerfilForm").trigger("reset");
                  $("#editarPerfilModal").modal('hide');
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

                $("#modificarPerfil").attr("disabled",false);
                $("#cancelarModificarPerfil").attr("disabled",false);
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

                  $("#modificarPerfil").attr("disabled",false);
                  $("#cancelarModificarPerfil").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });


    $(document).on("click", ".editar", function(){
      let id = this.id;

      $("#modificarPerfilForm").trigger("reset");
      $("#erroresAgregarEditar").css('display','none');
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/profileactions/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#nombreEdit").val(msg.perfil);
              $("#idPerfilEdit").val(msg.id);
              
              $("#editarPerfilModal").modal("show");
              
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
          pregunta = '¿Quieres desactivar este perfil?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este perfil?';
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
                url: "/profileactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Perfil " + estado,
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

    $(document).on("change", "#nombre", function () {
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

    $(document).on("click", "#cerrarAlerta", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#generarCiudadNuevo", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaEditar", function () {
      $("#erroresAgregarEditar").css('display','none');
    });
  </script>
@endpush
