@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />

  <style>
    .highcharts-axis-labels{
      border: white 1px solid !important;
    }
    .highcharts-exporting-group, .highcharts-credits{
      display: none !important;
    }
  </style>
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
  <div class="row" style="margin-top: 5px;">
    <div class="col-3">
      <label for="requerimiento" class="form-label">Requerimientos:</label>
      <input type="text" name="requerimiento" id="requerimiento"value="" class="form-control" />
    </div>
    <div class="col-3">
      <label for="responsable" class="form-label">Responsable:</label>
      <select id="responsable" name="responsable" value="" class="form-select" >
      <option value="">Selecciona un responsable</option>
        @foreach ($reclutador as $r)
            <option value="{{ $r->id }}">{{ $r->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-3">
      <label for="fecha" class="form-label">Fecha:</label>
      <input type="date" name="fecha" id="fecha" class="form-control" value="">
    </div>
    <div class="col-3">
      <label for="estatus" class="form-label">Estatus:</label>
      <select id="estatus" name="estatus" value="" class="form-select" >
        <option value="">Selecciona un estatus</option>
        @foreach ($estatus_vacantes as $ev)
            <option value="{{ $ev->id }}">{{ $ev->estatus }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <button class="btn btn-primary float-end" id="buscarReporte">Buscar reporte</button>
    </div>
  </div>
  <br><br><br>

  <div class="row" id="columnV1Padre" style="display:none;">
    <div class="col-12 col-md-12 col-xl-12">
      <div id="columnV1"></div>
    </div>
  </div>

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table" id="table">
              <thead>
                 <tr>
                    <th>Id</th>
                    <th>Fecha de alta</th>
                    <th>Requerimiento</th>
                    <th>Días transcurridos</th>
                    <th>Número de candidatos</th>
                    <th>Estatus</th>
                    <th>Ubicación</th>
                    <th>Responsable</th>
                 </tr>
              </thead>
           </table>
          </div>
        </div>
      </div>
    </div>

</div>


<?php 
$vac = "[";
$num_ele = count($vacantes);
$count = 0;
foreach ($vacantes as $v) {
  if($num_ele != $count)
  {
    $vac.= '"'.$v->puesto.'",';
  }
    else{
      $vac.= '"'.$v->puesto.'",';
    }
  $count++;
}

$vac .= "]";

?>





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
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('code/highcharts.js') }}"></script>
  <script src="{{ asset('code/modules/data.js') }}"></script>
  <script src="{{ asset('code/modules/drilldown.js') }}"></script>
  <script src="{{ asset('code/modules/exporting.js') }}"></script>
  <script src="{{ asset('code/modules/export-data.js') }}"></script>
  <script src="{{ asset('code/modules/accessibility.js') }}"></script>
  <script src="{{ asset('code/grouped-categories.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>

  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script>
    let table;
    let exportar = <?php echo $roles[1]->permitido; ?>;
    let exportOptions = '';

    var requirements = <?php print_r($vac); ?>;
    $( "#requerimiento" ).autocomplete({
      source: requirements
    });


    if(exportar == 1){
      exportOptions = 'Bfrtip';
    }
    else{
      exportOptions = '<lf<t>ip>';
    }

    $(function() {
      
      $.ajax({
            type: "POST",
            data: { requerimiento: "", 
                    responsable : "",
                    fecha: "",
                    estatus: "",
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/searchdatachart",
            success: function(msg){ 

            $("#columnV1Padre").css("display","block");
            console.log(msg);
              let code = msg;
              var parsed_response = msg.jsonXasis;
              var information = msg.jsonValues;
              console.log(parsed_response);
              Highcharts.chart('columnV1', {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      align: 'left',
                      text: ''
                  },
                  accessibility: {
                      announceNewData: {
                          enabled: true
                      }
                  },
                  xAxis: {
                      categories: parsed_response
                    ,
                    tickColor: '#FFF'
                  },
                  yAxis: {
                      title: {
                          text: 'Requerimientos'
                      }

                  },
                  legend: {
                      enabled: false
                  },
                  plotOptions: {
                      series: {
                          borderWidth: 0,
                          dataLabels: {
                              enabled: true,
                              format: '{point.y}'
                          }
                      }
                  },

                  tooltip: {
                      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                  },

                  series: [
                      {
                          name: '',
                          colorByPoint: true,
                          data: information
                      }
                  ]
              });
              

            },
            error: function (err) {
              //console.log(err);
            }
        }); 

      table = $(function() {
            table = $('#table').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            bLengthChange: false,
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
                      title: 'Reporte de requerimientos',
                      exportOptions: {
                              columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                      },
                      customize: function (doc) {
                                  doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                  doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                  doc.content[1].table.widths = [ '3%', '10%', '24%', '12%',
                                                                  '13%','12%','12%','16%'];
                      }
                  },
                  {
                      extend: 'excel',
                      className: 'btn-dark',
                      text: 'Excel',
                      exportOptions: {
                          columns: [ 0, 1,2,3, 4, 5, 6, 7]
                      },
                      title: 'Reporte de requerimientos'
                  }
            ],
            ajax: {
                url: '{{ url('searchreport') }}',
                data: { requerimiento: "",
                        responsable: "",
                        fecha: "",
                        estatus: "", 
                        "_token": "{{ csrf_token() }}" },
                        type: 'POST'
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fechaalta', name: 'fechaalta' },
                    { data: 'puesto', name: 'puesto' },
                    { data: 'dias_transcurridos', name: 'dias_transcurridos' },
                    { data: 'numero_candidatos', name: 'numero_candidatos' },
                    { data: 'estatus_vacante', name: 'estatus_vacante' },
                    { data: 'ubicacion', name: 'ubicacion' },
                    { data: 'responsable', name: 'responsable' }
                  ],
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": 3 },
            ]
        });
      });
    });

    $(document).on("click", "#buscarReporte", function(){

        let requerimiento = $("#requerimiento").val();
        let responsable = $("#responsable").val(); 
        let fecha = $("#fecha").val();
        let estatus = $("#estatus").val();


        $.ajax({
            type: "POST",
            data: { requerimiento: requerimiento, 
                    responsable : responsable,
                    fecha: fecha,
                    estatus: estatus,
                    "_token": "{{ csrf_token() }}" },
            dataType: 'JSON',
            url: "/searchdatachart",
            success: function(msg){ 

            $("#columnV1Padre").css("display","block");
            console.log(msg);
              let code = msg;
              var parsed_response = msg.jsonXasis;
              var information = msg.jsonValues;
              console.log(parsed_response);
              Highcharts.chart('columnV1', {
                  chart: {
                      type: 'column'
                  },
                  title: {
                      align: 'left',
                      text: ''
                  },
                  accessibility: {
                      announceNewData: {
                          enabled: true
                      }
                  },
                  xAxis: {
                      categories: parsed_response
                    ,
                    tickColor: '#FFF'
                  },
                  yAxis: {
                      title: {
                          text: 'Requerimientos'
                      }

                  },
                  legend: {
                      enabled: false
                  },
                  plotOptions: {
                      series: {
                          borderWidth: 0,
                          dataLabels: {
                              enabled: true,
                              format: '{point.y}'
                          }
                      }
                  },

                  tooltip: {
                      headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                      pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                  },

                  series: [
                      {
                          name: '',
                          colorByPoint: true,
                          data: information
                      }
                  ]
              });
              

            },
            error: function (err) {
              //console.log(err);
            }
        }); 

        

        table.destroy();
        table = $(function() {
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
                      title: 'Reporte de requerimientos',
                      exportOptions: {
                              columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                      },
                      customize: function (doc) {
                                  doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                  doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                  doc.content[1].table.widths = [ '3%', '10%', '24%', '12%',
                                                                  '13%','12%','12%','16%'];
                      }
                  },
                  {
                      extend: 'excel',
                      className: 'btn-dark',
                      text: 'Excel',
                      exportOptions: {
                          columns: [ 0, 1,2,3, 4, 5, 6, 7]
                      },
                      title: 'Reporte de requerimientos'
                  }
            ],
            ajax: {
                url: '{{ url('searchreport') }}',
                data: { requerimiento: requerimiento,
                        responsable: responsable,
                        fecha: fecha,
                        estatus: estatus, 
                        "_token": "{{ csrf_token() }}" },
                        type: 'POST'
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'fechaalta', name: 'fechaalta' },
                    { data: 'puesto', name: 'puesto' },
                    { data: 'dias_transcurridos', name: 'dias_transcurridos' },
                    { data: 'numero_candidatos', name: 'numero_candidatos' },
                    { data: 'estatus_vacante', name: 'estatus_vacante' },
                    { data: 'ubicacion', name: 'ubicacion' },
                    { data: 'responsable', name: 'responsable' }
                  ],
            "order": [],
            "columnDefs": [
                { "orderable": false, "targets": 3 },
            ]
        });
      });
      
    });

  </script>
@endpush
