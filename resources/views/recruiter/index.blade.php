@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reclutadores</li>
  </ol>
</nav>

<div class="row">

  <h2>Reclutadores</h2>
  <div class="row">
    <div class="col-lg-12">
        <button class="btn btn-primary float-end" id="generarReclutadorNuevo" data-bs-toggle="modal" data-bs-target="#agregarReclutadorModal">Agregar reclutadores</button>
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
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Estatus</th>
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
<div class="modal fade" id="agregarReclutadorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarReclutador">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Reclutador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          
          <div class="col-md-6">
              <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Nombres</label>
                <input type="text" class="form-control alpha-only" id="names" name="names" maxlength="45" required placeholder="Nombres">
                <div class="invalid-feedback" id="invalid-names-required">Los nombres son requerido</div>
              </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleInputUsername1" class="form-label">Apellidos</label>
              <input type="text" class="form-control alpha-only" id="lastnames" name="lastnames" maxlength="45" required placeholder="Nombres">
              <div class="invalid-feedback" id="invalid-lastnames-required">Los apellidos son requerido</div>
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
        <button type="button"class="btn btn-secondary" id="cancelarReclutador" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarReclutador">Guardar</button>
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
                <input type="text" class="form-control alpha-only" id="namesEdit" name="namesEdit" maxlength="100" required placeholder="Nombre">
                <div class="invalid-feedback" id="invalid-namesEdit-required">El nombre es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="exampleInputUsername1" class="form-label">Apellidos</label>
              <input type="text" class="form-control alpha-only" id="lastnamesEdit" name="lastnamesEdit" maxlength="45" required placeholder="Nombres">
              <div class="invalid-feedback" id="invalid-lastnamesEdit-required">Los apellidos son requerido</div>
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
        <button type="button"class="btn btn-secondary" id="cancelarReclutadorReclutador" data-bs-dismiss="modal">Cancelar</button>
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
          dom: 'Bfrtip',
            buttons: [
                {
                    extend:  'pdfHtml5',
                    className: 'btn-dark',
                    text: 'PDF',
                    title: 'Reclutadores',
                    exportOptions: {
                            columns: [ 0, 1, 2, 3]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '10%', '35%', '35%', '%20'];
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-dark',
                    text: 'CSV',
                    title: 'Reclutadores',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3]
                    },
                    customize: function (csv) {
                    var split_csv = csv.split("\n");
    
                    //Remove the row one to personnalize the headers
                    split_csv[0] = '"ID","Nombre","Apellidos","Estatus"';
                    csv = split_csv.join("\n");
                    return csv;
                    }
                }
          ],
          ajax: '{{ url('recruiter.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'nombres', name: 'nombres' },
                   { data: 'apellidos', name: 'apellidos' },
                   { data: 'state', name: 'state' },
                   { data: 'action', name: 'action' },
                ],
          "columnDefs": [
              { "visible": false, "targets": 0 },
              { "orderable": false, "targets": 4 },
          ]
       });
    });

  let errores = 0;
  $("#guardarReclutador").click(function(){

        let names = $("#names").val().trim();
        let lastnames = $("#lastnames").val().trim();

        //validar nombre
        if(names == '' || names == null){
            $("#invalid-names-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-names-required").removeClass("showFeedback");
        }

        if(lastnames == '' || lastnames == null){
            $("#invalid-lastnames-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-lastnames-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarReclutador").attr("disabled",true);
        $("#cancelarReclutador").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { names: names, 
                        lastnames: lastnames,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/recruiteractions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Reclutador agregado",
                      });
                      table.ajax.reload();
                      $("#agregarReclutador").trigger("reset");
                      $("#agregarReclutadorModal").modal('hide');
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

                  $("#guardarReclutador").attr("disabled",false);
                  $("#cancelarReclutador").attr("disabled",false);
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
                    $("#guardarReclutador").attr("disabled",false);
                    $("#cancelarReclutador").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarReclutador").click(function(){
      
      let idReclutador = $("#idReclutadorEdit").val().trim();
      let names = $("#namesEdit").val().trim();
      let lastnames = $("#lastnamesEdit").val().trim();

      //validar nombres
      if(names == '' || names == null){
          $("#invalid-namesEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-namesEdit-required").removeClass("showFeedback");
      }

      if(lastnames == '' || lastnames == null){
            $("#invalid-lastnamesEdit-required").addClass("showFeedback");
            erroresEdit++;
        }
        else{
            $("#invalid-lastnamesEdit-required").removeClass("showFeedback");
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
                      lastnames: lastnames, 
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
              
              $("#namesEdit").val(msg.nombres);
              $("#lastnamesEdit").val(msg.apellidos);
              $("#idReclutadorEdit").val(msg.id);
              
              $("#editarReclutadorModal").modal("show");
              
            }
        }); 
      
    });

    $(document).on("click", ".desactivar, .activar", function(){
        let id = this.id;
        let claseNombre = this.className; 
        let pregunta = '';
        let estado = '';

        if(claseNombre == 'desactivar operaciones'){
          pregunta = '¿Quieres desactivar este reclutador?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este reclutador?';
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
                url: "/recruiteractions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Reclutador " + estado,
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

    $(document).on("change", "#names, #lastnames, #namesEdit, #lastnamesEdit", function () {
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
