@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Clientes</li>
  </ol>
</nav>

<div class="row">

  <h2>Clientes</h2>
  <div class="row">
    <div class="col-lg-12">
      <?php if($roles[1]->permitido == 1){ ?>
        <button class="btn btn-primary float-end" id="generarClienteNuevo" data-bs-toggle="modal" data-bs-target="#agregarClienteModal">Agregar cliente</button>
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
                    <th>Nombres</th>
                    <th>Teléfono/Celular</th>
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
<div class="modal fade" id="agregarClienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarCliente">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="names" class="form-label">Nombre (Empresa)</label>
                <input type="text" class="form-control alphaNumericSpecial-only" id="names" name="names" maxlength="100" required placeholder="Nombre (Empresa)">
                <div class="invalid-feedback" id="invalid-names-required">El nombre es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono/Celular</label>
                <input type="text" class="form-control numeric-only" id="telefono" name="telefono" maxlength="10" required placeholder="Nombres">
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

          <br>
          <div class="col-md-12">Dirección
            <hr style="margin:5px 2px">
          </div>
          
          <br><br>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="calle" class="form-label">Calle</label>
              <input type="text" class="form-control alpha-only" id="calle" name="calle" maxlength="80" required placeholder="Calle">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="num_int" class="form-label">Núm. interior</label>
              <input type="text" class="form-control numeric-only" id="num_int" name="num_int" maxlength="10" required placeholder="Núm. interior">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="num_ext" class="form-label">Núm. exterior</label>
              <input type="text" class="form-control alphaNumeric-only" id="num_ext" name="num_ext" maxlength="8" required placeholder="Núm. exterior">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="codigo_postal" class="form-label">Código postal</label>
              <input type="text" class="form-control numeric-only" id="codigo_postal" name="codigo_postal" maxlength="10" required placeholder="Código postal">
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="ciudad" class="form-label">Ciudad</label>
              <input type="text" class="form-control alpha-only" id="ciudad" name="ciudad" maxlength="80" required placeholder="Ciudad">
            </div>
          </div>
          <div class="col-md-4">
              <div class="mb-3">
                <label for="estado_id" class="form-label">Estado</label>
                <select class="form-select" id="estado_id" name="estado_id">
                  <option value="">Selecciona un estado</option>
                    @foreach ($estados as $e)
                        <option value="{{ $e->id }}">{{ $e->estado }}</option>
                    @endforeach
                </select>
              </div>
          </div>
          <div class="col-md-12">
            <div class="mb-3">
              <label for="referencia" class="form-label">Referencia de ubicación</label>
              <input type="text" class="form-control" id="referencia" name="referencia" maxlength="100" placeholder="Referencia de ubicación">
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
        <button type="button"class="btn btn-secondary" id="cancelarCliente" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarCliente">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Editar Modal -->
<div class="modal fade" id="modificarClienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="modificarClienteForm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="names" class="form-label">Nombre (Empresa)</label>
                <input type="text" class="form-control alphaNumericSpecial-only" id="namesEdit" name="namesEdit" maxlength="100" required placeholder="Nombre (Empresa)">
                <div class="invalid-feedback" id="invalid-namesEdit-required">El nombre es requerido</div>
              </div>
          </div>
        <div class="col-md-6">
            <div class="mb-3">
              <label for="telefonoEdit" class="form-label">Teléfono/Celular</label>
              <input type="text" class="form-control numeric-only" id="telefonoEdit" name="telefonoEdit" maxlength="10" required placeholder="Nombres">
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

        <br>
        <div class="col-md-12">Dirección
          <hr style="margin:5px 2px">
        </div>
        
        <br><br>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="calleEdit" class="form-label">Calle</label>
            <input type="text" class="form-control alpha-only" id="calleEdit" name="calleEdit" maxlength="80" required placeholder="Calle">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="num_intEdit" class="form-label">Núm. interior</label>
            <input type="text" class="form-control numeric-only" id="num_intEdit" name="num_intEdit" maxlength="10" required placeholder="Núm. interior">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="num_extEdit" class="form-label">Núm. exterior</label>
            <input type="text" class="form-control alphaNumeric-only" id="num_extEdit" name="num_extEdit" maxlength="8" required placeholder="Núm. exterior">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="codigo_postalEdit" class="form-label">Código postal</label>
            <input type="text" class="form-control numeric-only" id="codigo_postalEdit" name="codigo_postalEdit" maxlength="10" required placeholder="Código postal">
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="ciudadEdit" class="form-label">Ciudad</label>
            <input type="text" class="form-control alpha-only" id="ciudadEdit" name="ciudadEdit" maxlength="80" required placeholder="Ciudad">
          </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
              <label for="estado_idEdit" class="form-label">Estado</label>
              <select class="form-select" id="estado_idEdit" name="estado_idEdit">
              </select>
            </div>
        </div>
        <div class="col-md-12">
          <div class="mb-3">
            <label for="referencia" class="form-label">Referencia de ubicación</label>
            <input type="text" class="form-control" id="referenciaEdit" name="referenciaEdit" maxlength="100" placeholder="Referencia de ubicación">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 invalid-feedback showErrorsEdit"><br>
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
        <input type="hidden" name="idClienteEdit" id="idClienteEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarClienteEdit" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarCliente">Guardar</button>
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
                    title: 'Clientes',
                    exportOptions: {
                            columns: [ 0,1,2,3]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '10%', '45%', '23%', 
                                                                '22%'];
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-dark',
                    text: 'Excel',
                    exportOptions: {
                        columns: [ 0,1,2,3]
                    },
                    title: 'Clientes'
                }
          ],
          ajax: '{{ url('client.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'nombres', name: 'names' },
                   { data: 'telefono', name: 'telefono' },
                   { data: 'state', name: 'state' },
                   { data: 'action', name: 'action' },
                ],
          "order": [],
          "columnDefs": [
              { "visible": false, "targets": 3 },
              { "orderable": false, "targets": 4 },
          ]
       });

    });

  let errores = 0;
  $("#guardarCliente").click(function(){

        let names = $("#names").val().trim();
        let telefono = $("#telefono").val().trim();
        let mail = $("#email").val().trim();
        let calle = $("#calle").val().trim();
        let num_int = $("#num_int").val().trim();
        let num_ext = $("#num_ext").val().trim();
        let codigo_postal = $("#codigo_postal").val().trim();
        let ciudad = $("#ciudad").val().trim();
        let estado = $("#estado_id").val();
        let referencia = $("#referencia").val().trim();

        //validar name
        if(names == '' || names == null){
            $("#invalid-names-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-names-required").removeClass("showFeedback");
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

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarCliente").attr("disabled",true);
        $("#cancelarCliente").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { names: names, 
                        email: mail,
                        telefono : telefono,
                        calle : calle,
                        num_int : num_int,
                        num_ext : num_ext,
                        codigo_postal : codigo_postal,
                        ciudad : ciudad,
                        estado : estado,
                        referencia: referencia,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/clientactions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Cliente agregado.",
                      });
                      table.ajax.reload();
                      $("#agregarCliente").trigger("reset");
                      $("#agregarClienteModal").modal('hide');
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

                  $("#guardarCliente").attr("disabled",false);
                  $("#cancelarCliente").attr("disabled",false);
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
                    $("#guardarCliente").attr("disabled",false);
                    $("#cancelarCliente").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });


    let erroresEdit = 0;
    $("#modificarCliente").click(function(){
      
      let idCliente = $("#idClienteEdit").val().trim();
      let names = $("#namesEdit").val().trim();
      let telefono = $("#telefonoEdit").val().trim();
      let mail = $("#emailEdit").val().trim();
      let calle = $("#calleEdit").val().trim();
      let num_int = $("#num_intEdit").val().trim();
      let num_ext = $("#num_extEdit").val().trim();
      let codigo_postal = $("#codigo_postalEdit").val().trim();
      let ciudad = $("#ciudadEdit").val().trim();
      let estado = $("#estado_idEdit").val();
      let referencia = $("#referenciaEdit").val().trim();

      //validar name
      if(names == '' || names == null){
          $("#invalid-names-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-names-required").removeClass("showFeedback");
      }

      //validar email
      if(mail == '' || mail == null){
          $("#invalid-emailEdit-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-emailEdit-required").removeClass("showFeedback");
      }

      if(!isEmail(mail)){
          $("#invalid-emailEdit-valid-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-emailEdit-valid-required").removeClass("showFeedback");
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
                      telefono : telefono,
                      email: mail,
                      calle : calle,
                      num_int : num_int,
                      num_ext : num_ext,
                      codigo_postal : codigo_postal,
                      ciudad : ciudad,
                      estado : estado,
                      referencia: referencia,
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
              $("#telefonoEdit").val(msg.telefono);
              $("#emailEdit").val(msg.email);
              $("#calleEdit").val(msg.calle);
              $("#num_intEdit").val(msg.num_int);
              $("#num_extEdit").val(msg.num_ext);
              $("#codigo_postalEdit").val(msg.codigo_postal);
              $("#ciudadEdit").val(msg.ciudad);
              $("#estado_idEdit").html(msg.state_select);
              $("#referenciaEdit").val(msg.referencia);
              
              
              $("#modificarClienteModal").modal("show");
              
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
        allowOutsideClick: false,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        //console.log(result);
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

    $(document).on("change", "#names, #namesEdit, #lastnamesEdit, #reclutador_idEdit", function () {
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
