@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

  <style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 320px;
        max-width: 800px;
        margin: 1em auto;
    }
    
    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    
    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }
    
    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    
    input[type="number"] {
        min-width: 50px;
    }

    .highcharts-exporting-group, .highcharts-credits{
      display: none !important;
    }

    .color-title{
      color: #438eff;
    }
    
    .big-size{
      font-size: 40px;
    }
    </style>
@endpush

<?php 

foreach ($clientes as $c ) {
  $num_clientes =  $c->clientes;
}
foreach ($clientes_activos as $c ) {
  $num_clientes_activos =  $c->activos;
}
foreach ($clientes_inactivos as $c ) {
  $num_clientes_inactivos =  $c->inactivos;
}

foreach ($candidatos_por_asignar as $c ) {
  $num_candidatos_por_asignar =  $c->porasignar;
}
foreach ($candidatos_asignados as $c ) {
  $num_candidatos_asignados =  $c->asignados;
}
$total_candidatos = $num_candidatos_por_asignar + $num_candidatos_asignados;

foreach ($requerimientos_pendiente as $r ) {
  $num_requerimientos_pendiente =  $r->pendiente;
}
foreach ($requerimientos_proceso as $r ) {
  $num_requerimientos_proceso =  $r->proceso;
}
foreach ($requerimientos_contratado as $r ) {
  $num_requerimientos_contratado =  $r->contratado;
}
foreach ($requerimientos_descartado as $r ) {
  $num_requerimientos_descartado =  $r->descartado;
}
/*foreach ($requerimientos_cartera as $r ) {
  $num_requerimientos_cartera =  $r->cartera;
}*/
$total_requerimientos = $num_requerimientos_pendiente + $num_requerimientos_proceso + $num_requerimientos_contratado + $num_requerimientos_descartado;
?>

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Dashboard</h4>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row text-center">
              <h6 class="card-title mb-0 color-title">Clientes</h6>
              <h3 class="mb-2 color-title big-size" >{{ $num_clientes }}</h3>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-xl-12">
                <div id="containerPie1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row text-center">
              <h6 class="card-title mb-0 color-title">Candidatos</h6>
              <h3 class="mb-2 color-title big-size">{{ $total_candidatos }}</h3>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-xl-12">
                <div id="containerPie2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div> <!-- row -->


<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="row text-center">
              <h6 class="card-title mb-0 color-title">Requerimientos</h6>
              <h3 class="mb-2 color-title big-size">{{ $total_requerimientos }}</h3>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-xl-12">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-12 col-xl-12">
                <div id="columnV1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
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

  <script type="text/javascript">
    // Data retrieved from https://netmarketshare.com
    Highcharts.chart('containerPie1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})'
                },
                size: 300
            }
        },
        series: [{
            name: 'Clientes',
            colorByPoint: true,
            data: [{
                name: 'Activos',
                y: <?php  echo $num_clientes_activos; ?>,
                sliced: true,
                selected: true
            }, {
                name: 'Inactivos',
                y: <?php  echo $num_clientes_inactivos; ?>
            }]
        }]
    });
    
    Highcharts.chart('containerPie2', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}% ({point.y})</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})'
                },
                size: 300
            }
        },
        series: [{
            name: 'Candidatos',
            colorByPoint: true,
            data: [{
                name: 'Por asignar',
                y: <?php  echo $num_candidatos_por_asignar; ?>,
                sliced: true,
                selected: true
            }, {
                name: 'Asignados',
                y: <?php  echo $num_candidatos_asignados; ?>
            }]
        }]
    });

    //'{point.y:.1f}%'
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
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total de requerimientos'
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
            data: [
                {
                    name: 'En búsqueda',
                    y: <?php  echo $num_requerimientos_proceso; ?>,
                },
                {
                    name: 'Pendiente de revisión',
                    y: <?php  echo $num_requerimientos_pendiente; ?>,
                },
                {
                    name: 'Cubierto',
                    y: <?php  echo $num_requerimientos_contratado; ?>,
                },
                {
                    name: 'Rechazado',
                    y: <?php  echo $num_requerimientos_descartado; ?>,
                }
            ]
        }
    ]
});
        </script>
@endpush