@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
  <style>
    .alignLeft{
      text-align: left !important;
    }
  </style>
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Requerimientos</li>
  </ol>
</nav>

<div class="row">

  <h2>Requerimientos</h2>
  <div class="row">
    <div class="col-lg-12">
      <?php if($roles[1]->permitido == 1){ ?>
        <button class="btn btn-primary float-end" id="generarRequerimientoNuevo">Agregar requerimiento</button>
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
                    <th>Vacante</th>
                    <th>Cliente</th>
                    <th>Estatus</th>
                    <th>Estatus vacante</th>
                    <th>Reclutador</th>
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
<div class="modal fade" id="agregarRequerimientoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Requerimiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <!-- HIDDEN FIELDS -->
          <input type="hidden" id="idRequerimientoUnico" name="idRequerimientoUnico" />
          <input type="hidden" id="idRequerimientoEdit" name="idRequerimientoEdit" />

          <ul class="nav nav-tabs mb-12" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="client-tab" data-bs-toggle="tab" data-bs-target="#clientDiv" type="button" role="tab" aria-controls="clientDiv" aria-selected="true" disabled>Datos del cliente</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="general-tab" data-bs-toggle="tab" data-bs-target="#generalDiv" type="button" role="tab" aria-controls="generalDiv" aria-selected="true" disabled>Datos generales</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personalDiv" type="button" role="tab" aria-controls="personalDiv" aria-selected="true" disabled>Información personal</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="academic-tab" data-bs-toggle="tab" data-bs-target="#academicDiv" type="button" role="tab" aria-controls="academicDiv" aria-selected="true" disabled>Información academica</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="job-tab" data-bs-toggle="tab" data-bs-target="#jobDiv" type="button" role="tab" aria-controls="jobDiv" aria-selected="true" disabled>Descripción del puesto</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additionalDiv" type="button" role="tab" aria-controls="additionalDiv" aria-selected="true" disabled>Requerimientos adicionales</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="economic-tab" data-bs-toggle="tab" data-bs-target="#economicDiv" type="button" role="tab" aria-controls="economicDiv" aria-selected="true" disabled>Propuesta económica</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="process-tab" data-bs-toggle="tab" data-bs-target="#processDiv" type="button" role="tab" aria-controls="processDiv" aria-selected="true" disabled>Proceso</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="dataadd-tab" data-bs-toggle="tab" data-bs-target="#dataaddDiv" type="button" role="tab" aria-controls="dataaddDiv" aria-selected="true" disabled>Datos adicionales</button>
            </li>
            <li class="nav-item" role="presentation" style="visibility:hidden">
              <button class="nav-link" id="assign-tab" data-bs-toggle="tab" data-bs-target="#assignDiv" type="button" role="tab" aria-controls="assignDiv" aria-selected="true" >Asignar candidatos</button>
            </li>
          </ul>
          
          <div class="tab-content" id="myTabContent">
            <!-- BEGINNING TAB INFORMACION -->
            <div class="tab-pane fade" id="clientDiv" role="tabpanel" aria-labelledby="client-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosClientes">

                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-6" >
                          <div class="mb-3">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select class="form-select" id="cliente_id" name="cliente_id">
                              <option value="">Selecciona un cliente</option>
                                @foreach ($clientes as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombres }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="invalid-cliente_id-required">El cliente es requerido</div>
                          </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="direccion" class="form-label">Dirección</label>
                              <input type="text" class="form-control" id="direccion" name="direccion" readonly>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="referencia" class="form-label">Referencia de ubicación</label>
                              <input type="text" class="form-control" id="referencia" name="referencia" readonly>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="telefono" class="form-label">Teléfono</label>
                              <input type="text" class="form-control" id="telefono" name="telefono" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="email" name="email" readonly>
                          </div>
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
              </form>   
              
              <span id="buttonStatus">
                <?php 
                if(auth()->user()->roles_id != 3){
                ?>
                <br>
                <!--<div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label for="telefono" class="form-label">Aceptas el requerimiento</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                     <div class="col-4">
                        <button type="button" class="btn btn-success" id="aceptarRequerimiento">Aceptar</button>
                      </div>
                      <div class="col-4">
                        <button type="button" class="btn btn-danger me-2" id="rechazarRequerimiento">Rechazar</button>
                      </div>
                      <div class="col-12">
                          <span id="buttonRecruitment">
                            <button type="button" class="btn btn-info" id="seleccionarReclutador">Asignar reclutador</button>
                          </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <span id="buttonApplicant">
                        <button type="button" class="btn btn-info" id="asignarCandidato">Asignar candidato</button>
                      </span>
                    </div>
                  </div>
                </div>-->
                <?php 
                }
                ?>
              </span>

              </p>
            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <!-- GENERAL -->
            <div class="tab-pane fade" id="generalDiv" role="tabpanel" aria-labelledby="general-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosGenerales">

                      <input type="hidden" id="idGeneralUnico" name="idGeneralUnico" />

                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="namePosition" class="form-label">Nombre del puesto</label>
                              <input type="text" class="form-control" id="namePosition" name="namePosition" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-namePosition-required">El nombre del puesto es requerido</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="numVacant" class="form-label">Número de vacantes</label>
                              <input type="number" class="form-control" id="numVacant" name="numVacant" min="0" required>
                              <div class="invalid-feedback" id="invalid-numVacant-required">El número de vacantes es requerido</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="requestDate" class="form-label">Fecha de solicitud</label>
                            <input type="date" class="form-control" id="requestDate" name="requestDate" value="<?=date('Y-m-d');?>" required>
                            <div class="invalid-feedback" id="invalid-requestDate-required">La fecha de solicitud es requerida</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="requestService" class="form-label">Servicio requerido</label>
                              <select class="form-select" id="requestService" name="requestService">
                                  @foreach ($request_service as $rs)
                                      <option value="{{ $rs->id }}">{{ $rs->servicio }}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="modality" class="form-label">Modalidad</label>
                            <select class="form-select" id="modality" name="modality">
                                @foreach ($modalidad as $m)
                                    <option value="{{ $m->id }}">{{ $m->modalidad }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="asignmentTime" class="form-label">Tiempo de asignación</label>
                            <div class="row">
                              <div class="col-4">
                                <input type="radio" id="asignmentTime" name="asignmentTime" value="1" class="asignmentTime1" checked>
                                <label for="asignmentTime">Días</label>
                                <input type="number" name="days" id="days" value="" class="form-control" />
                                <div class="invalid-feedback" id="invalid-days-required">Los días son requeridos</div>
                              </div>
                              <div class="col-4">
                                <input type="radio" id="asignmentTime" name="asignmentTime" class="asignmentTime2" value="2">
                                <label for="asignmentTime">Meses</label>
                                <input type="number" name="months" id="months" value="" class="form-control"  />
                                <div class="invalid-feedback" id="invalid-months-required">Los meses son requeridos</div>
                              </div>
                              <div class="col-4">
                                <input type="radio" id="asignmentTime" name="asignmentTime" class="asignmentTime3" value="3">
                                <label for="asignmentTime">Indefinido</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="timeBegin" class="form-label">Horario</label>
                            <div class="row">
                              <div class="col-6">
                                <input type="time" class="form-control" id="timeBegin" name="timeBegin">
                              </div>
                              <div class="col-6">
                                <input type="time" class="form-control" id="timeEnd" name="timeEnd">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="executiveInCharge" class="form-label">Ejecutivo encargado</label>
                              <input type="text" class="form-control" id="executiveInCharge" name="executiveInCharge" value="<?=auth()->user()->name?>" readonly>
                              <input type="hidden" id="executiveInChargeID" name="executiveInChargeID" value="<?=auth()->user()->id?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregarGeneral" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSGeneral" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>

                </form>     
              </p>
            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <!-- PERSONAL -->
            <div class="tab-pane fade" id="personalDiv" role="tabpanel" aria-labelledby="personal-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosPersonales">

                    <input type="hidden" id="idPersonalUnico" name="idPersonalUnico" />

                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="rangeAge" class="form-label">Rango de edad</label>
                              <input type="text" class="form-control" id="rangeAge" name="rangeAge" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-rangeAge-required">El rango de edad es requerido</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="sex" class="form-label">Sexo</label>
                              <select class="form-select" name="sex" id="sex">
                                <option value="1">Femenino</option>
                                <option value="2">Masculino</option>
                                <option value="3">Indiferente</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="civilstate" class="form-label">Estado civil</label>
                            <select class="form-select" name="civilstate" id="civilstate">
                              @foreach ($estado_civiles as $e)
                                <option value="{{ $e->id }}">{{ $e->estados_civiles }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="residencePlace" class="form-label">Lugar residencia</label>
                              <input type="text" class="form-control" id="residencePlace" name="residencePlace" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSPersonal" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <!-- ACADEMIC -->
            <div class="tab-pane fade" id="academicDiv" role="tabpanel" aria-labelledby="academic-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosAcademicos">

                    <input type="hidden" id="idAcademicoUnico" name="idAcademicoUnico" />

                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="escolaridad" class="form-label">Escolaridad</label>
                              <input type="text" class="form-control" id="escolaridad" name="escolaridad" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-escolaridad-required">La escolaridad es requerida</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <span style="margin-bottom: 10px;">
                                <label for="certificado" class="form-label">Certificados o cursos</label>
                                <button type="button" class="btn btn-info me-2 float-end" id="addCertificate" >Agregar certificado/curso</button>
                              </span>
                              <br><br>
                              <span id="areaCertificate">
                                <div class="row" style="margin-bottom: 5px;margin-right:5px;">
                                  <input type="text" class="form-control certificado_class" id="certificado0" name="certificado[0]" maxlength="100" placeholder="Certificado o curso">
                                </div>
                              </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                              <span style="margin-bottom: 10px;">
                                <label for="idiom" class="form-label">Idiomas</label>
                                <button type="button" class="btn btn-info me-2 float-end" id="addIdiom" >Agregar idioma</button>
                              </span>
                              <br><br>
                              <span id="areaIdiom">
                                <div class="row" style="margin-bottom: 5px;margin-right:5px;">
                                  <input type="text" class="form-control idiom_class" id="idiom0" name="idiom[0]" maxlength="100" placeholder="Idioma">
                                </div>
                              </span>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSAcademic" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>



          <div class="tab-content" id="myTabContent">
            <!-- JOB POSITION -->
            <div class="tab-pane fade" id="jobDiv" role="tabpanel" aria-labelledby="job-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosPuesto">

                    <input type="hidden" id="idPuestoUnico" name="idPuestoUnico" />
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="experience" class="form-label">Experiencia</label>
                              <input type="text" class="form-control" id="experience" name="experience" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-experience-required">La experiencia es requerida</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="activities" class="form-label">Actividades</label>
                              <textarea id="activities" name="activities" rows="3" cols="50" class="form-control"></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="technical_knowledge" class="form-label">Conocimientos técnicos</label>
                              <textarea id="technical_knowledge" name="technical_knowledge" rows="3" cols="50" class="form-control"></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="necessary_skills" class="form-label">Competencias necesarias</label>
                              <textarea id="necessary_skills" name="necessary_skills" rows="3" cols="50" class="form-control"></textarea>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSJob" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>



          <div class="tab-content" id="myTabContent">
            <!-- ADDITIONAL POSITION -->
            <div class="tab-pane fade" id="additionalDiv" role="tabpanel" aria-labelledby="additional-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosAdicional">

                    <input type="hidden" id="idAdicionalUnico" name="idAdicionalUnico" />
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="desplazarse" class="form-label">Disponibilidad para desplazarse</label>
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="radio" id="desplazarse" name="desplazarse" class="desplazarse1" value="1" checked>
                                  <label for="desplazarse">Sí</label>
                                </div>
                                <div class="col-md-3">
                                  <input type="radio" id="desplazarse" name="desplazarse" class="desplazarse2" value="2" >
                                  <label for="desplazarse">No</label>
                                </div>
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-4">
                                      <input type="radio" id="desplazarse" name="desplazarse" class="desplazarse3" value="3" >
                                      <label for="desplazarse">Especificar</label>
                                    </div>
                                    <div class="col-8">
                                      <input type="text" class="form-control" id="desplazarse_motivo" name="desplazarse_motivo" maxlength="100" required>
                                      <div class="invalid-feedback" id="invalid-desplazarse_motivo-required">El motivo es requerido</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="viajar" class="form-label">Disponibilidad para viajar</label>
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="radio" id="viajar" name="viajar" class="viajar1" value="1" checked>
                                  <label for="viajar">Sí</label>
                                </div>
                                <div class="col-md-3">
                                  <input type="radio" id="viajar" name="viajar" class="viajar2" value="2" >
                                  <label for="viajar">No</label>
                                </div>
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-4">
                                      <input type="radio" id="viajar" name="viajar" class="viajar3" value="3" >
                                      <label for="viajar">Especificar</label>
                                    </div>
                                    <div class="col-8">
                                      <input type="text" class="form-control" id="viajar_motivo" name="viajar_motivo" maxlength="100" required>
                                      <div class="invalid-feedback" id="invalid-viajar_motivo-required">El motivo es requerido</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="disponibilidad_horario" class="form-label">Disponibilidad de horario</label>
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="radio" id="disponibilidad_horario" name="disponibilidad_horario" class="disponibilidad_horario1" value="1" checked>
                                  <label for="disponibilidad_horario">Sí</label>
                                </div>
                                <div class="col-md-3">
                                  <input type="radio" id="disponibilidad_horario" name="disponibilidad_horario" class="disponibilidad_horario2" value="2" >
                                  <label for="disponibilidad_horario">No</label>
                                </div>
                                <div class="col-md-6">
                                  <div class="row">
                                    <div class="col-4">
                                      <input type="radio" id="disponibilidad_horario" name="disponibilidad_horario" class="disponibilidad_horario3" value="3" >
                                      <label for="disponibilidad_horario">Especificar</label>
                                    </div>
                                    <div class="col-8">
                                      <input type="text" class="form-control" id="disponibilidad_horario_motivo" name="disponibilidad_horario_motivo" maxlength="100" required>
                                      <div class="invalid-feedback" id="invalid-disponibilidad_horario_motivo-required">El motivo es requerido</div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="personal_cargo" class="form-label">Cuenta con personal a cargo</label>
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="radio" id="personal_cargo" name="personal_cargo" value="1" class="personal_cargo1" checked>
                                  <label for="personal_cargo">Sí</label>
                                </div>
                                <div class="col-md-3">
                                  <input type="radio" id="personal_cargo" name="personal_cargo" value="2" class="personal_cargo2" >
                                  <label for="personal_cargo">No</label>
                                </div>
                                <div class="col-md-6">
                                      <input type="number" class="form-control" id="num_personas_cargo" name="num_personas_cargo" required>
                                      <div class="invalid-feedback" id="invalid-num_personas_cargo-required">El número de personas a cargo es requerido</div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="persona_reporta" class="form-label">A quién reporta directamente</label>
                              <input type="text" class="form-control" id="persona_reporta" name="persona_reporta" maxlength="100">
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="equipo_computo" class="form-label">Requiere equipo de cómputo propio</label>
                              <div class="row">
                                <div class="col-md-3">
                                  <input type="radio" id="equipo_computo" name="equipo_computo" value="1" class="equipo_computo1" checked>
                                  <label for="equipo_computo">Sí</label>
                                </div>
                                <div class="col-md-3">
                                  <input type="radio" id="equipo_computo" name="equipo_computo" value="2" class="equipo_computo2" >
                                  <label for="equipo_computo">No</label>
                                </div>
                                <div class="col-md-6">
                                      &nbsp;
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                     

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSAdicionales" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>




          <div class="tab-content" id="myTabContent">
            <!-- ECONOMIC POSITION -->
            <div class="tab-pane fade" id="economicDiv" role="tabpanel" aria-labelledby="economic-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosEconomicos">

                    <input type="hidden" id="idEconomicoUnico" name="idEconomicoUnico" />
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="esquemacontratacion" class="form-label">Esquema de contratación</label>
                              <input type="text" class="form-control" id="esquemacontratacion" name="esquemacontratacion" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-esquemacontratacion-required">El esquema de contratación es requerido</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                              <label for="tiposalario" class="form-label">Tipo de salario</label>
                              <input type="text" class="form-control" id="tiposalario" name="tiposalario" maxlength="100" >
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="montominimo" class="form-label">Monto mínimo</label>
                              <input type="text" class="form-control alignLeft" id="montominimo" name="montominimo" required data-inputmask="'alias': 'currency', 'prefix':'$'">
                              <div class="invalid-feedback" id="invalid-montominimo-required">El monto mínimo es requerido</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                              <label for="montomaximo" class="form-label">Monto máximo</label>
                              <input type="text" class="form-control alignLeft" id="montomaximo" name="montomaximo" required data-inputmask="'alias': 'currency', 'prefix':'$'" >
                              <div class="invalid-feedback" id="invalid-montomaximo-required">El monto máximo es requerido</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="jornadalaboral" class="form-label">Jornada laboral</label>
                              <input type="text" class="form-control" id="jornadalaboral" name="jornadalaboral" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                          &nbsp;
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="prestaciones_beneficios" class="form-label">Prestaciones/Beneficios</label>
                              <textarea id="prestaciones_beneficios" name="prestaciones_beneficios" rows="3" cols="50" class="form-control"></textarea>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSEconomic" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <!-- PROCESS POSITION -->
            <div class="tab-pane fade" id="processDiv" role="tabpanel" aria-labelledby="process-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosProceso">

                    <input type="hidden" id="idProcesoUnico" name="idProcesoUnico" />
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="duracion" class="form-label">Duración estimada del proceso</label>
                              <input type="text" class="form-control" id="duracion" name="duracion" maxlength="100" required>
                              <div class="invalid-feedback" id="invalid-duracion-required">La duración es requerida</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                              <label for="cantidadfiltros" class="form-label">Cantidad de filtros a realizar</label>
                              <input type="number" class="form-control" id="cantidadfiltros" name="cantidadfiltros" >
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="niveles_flitro" class="form-label">Niveles que participan en el filtro</label>
                              <input type="text" class="form-control" id="niveles_flitro" name="niveles_flitro">
                            </div>
                        </div>
                        <div class="col-md-6">
                          &nbsp;
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="proceso" class="form-label">Proceso</label>
                              <div class="row">
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="entrevista" id="entrevista" value="1">
                                    Entrevista filtro
                                  </label>
                                </div>
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="pruebat" id="pruebat" value="1">
                                    Prueba técnica
                                  </label>
                                </div>
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="pruebap" id="pruebap" value="1">
                                    Pruebas psicométricas
                                  </label>
                                </div>
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="referencias" id="referencias" value="1">
                                    Referencias
                                  </label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="entrevista_tecnica" id="entrevista_tecnica" value="1">
                                    Entrevista técnica
                                  </label>
                                </div>
                                <div class="col-3">
                                  <label class="radio"><input type="checkbox" name="estudio_socioeconomico" id="estudio_socioeconomico" value="1">
                                    Estudio socioeconómico
                                  </label>
                                </div>
                                <div class="col-3">
                                </div>
                                <div class="col-3">
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSProcess" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>




          <div class="tab-content" id="myTabContent">
            <!-- FINAL POSITION -->
            <div class="tab-pane fade" id="dataaddDiv" role="tabpanel" aria-labelledby="dataadd-tab">
                <p class="hp-p1-body mb-0">
                  <form action="#" method="POST" id="agregarDatosFinal">

                    <input type="hidden" id="idFinalUnico" name="idFinalUnico" />
                      <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="razonnocontratacion" class="form-label">Razón no contratación</label>
                              <input type="text" class="form-control" id="razonnocontratacion" name="razonnocontratacion" maxlength="100" required>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                              <label for="fechacontratacion" class="form-label">Fecha de contratación</label>
                              <input type="date" class="form-control" id="fechacontratacion" name="fechacontratacion">
                              <div class="invalid-feedback" id="invalid-fechacontratacion-required">Necesitas ingresar la fecha de contratación o la razón de no contratación</div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="errorCampoAdicional" style="display: none;">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSFinal" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>
                
                </form>
              </p>
            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <!-- ASSIGNING PERSONAL -->
            <div class="tab-pane fade" id="assignDiv" role="tabpanel" aria-labelledby="assign-tab">
                <p class="hp-p1-body mb-0">

                  <div class="row" style="margin-top: 15px;">
                    <div class="col-6">
                      Seleccione uno o más candidatos para asignarlos al requerimiento:
                    </div>
                    <div class="col-6">
                      Candidatos asignados:
                    </div>
                  </div>
                      <div class="row" style="margin-top: 15px;">
                        <div class="col-6">
                          <form id="addNewApplicant">
                          <div class="table-responsive">
                            <table class="table" id="table-assign">
                              <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                </tr>
                              </thead>
                            </table>
                          </div>

                          </form>
                        </div>

                        <div class="col-6">
                          <div class="table-responsive">
                            <table class="table" id="table-delete">
                              <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estatus</th>
                                    <th></th>
                                </tr>
                              </thead>
                            </table>
                          </div>
                        </div>

                      </div>

                      <div class="row">
                        <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregar" style="display: none;">
                        </div>
                      </div>
                      <div class="text-center" id="loadingSAssign" style="visibility: hidden;">
                        <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                      </div>

              </p>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <button type="button"class="btn btn-secondary" id="cancelarDatosClientes" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosClientes">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosGenerales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosPersonales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosAcademicos" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosPuesto" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosAdicionales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosEconomicos" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosProceso" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarDatosFinales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosClientes" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosGenerales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosPersonales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosAcademicos" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosPuesto" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosAdicionales" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosEconomicos" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosProceso" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="editarDatosFinales" style="display: none;">Guardar</button>

        <button type="button" class="btn btn-primary me-2" id="addApplicant" style="display: none;">Agregar candidatos</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="agregarReclutadorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form action="#" method="POST" id="agregarReclutador">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Reclutador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
            <div class="mb-3">
              <label for="rol" class="form-label">Seleccionar reclutador</label>
              <select class="form-select" id="reclutador_id">
              </select>
            </div>
          </div>

          <div class="text-center" id="loadingSReclutador" style="visibility: hidden;">
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


<!--ASIGNAR CANDIDATO--->
<div class="modal fade" id="agregarCandidatoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="#" method="POST" id="agregarCandidato">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Candidato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
            <div class="mb-3">
              <label for="rol" class="form-label">Seleccionar candidato</label>
              <select class="form-select" id="candidato_sel_id">
              </select>
            </div>
          </div>

          <div class="text-center" id="loadingSReclutador" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <button type="button"class="btn btn-secondary" id="cancelarCandidato" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarCandidato">Guardar</button>
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
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script>
    let table;
    $(function() {
          table = $('#table').DataTable({
          processing: true,
          serverSide: false,
          responsive: true,
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
          dom: 'Bfrtip',
            buttons: [
                {
                    extend:  'pdfHtml5',
                    className: 'btn-dark',
                    text: 'PDF',
                    title: 'Requerimientos',
                    exportOptions: {
                            columns: [ 0,1,2,3,4]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '10%', '25%', '25%', 
                                                                '25%','15%'];
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-dark',
                    text: 'Excel',
                    exportOptions: {
                        columns: [ 0,1,2,3, 4]
                    },
                    title: 'Requerimientos'
                }
          ],
          ajax: '{{ url('requerimiento.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'puesto', name: 'puesto' },
                   { data: 'nombre_cliente', name: 'nombre_cliente' },
                   { data: 'state', name: 'state' },
                   { data: 'estatus_vacante', name: 'esttatus_vacante' },
                   { data: 'namereclutador', name: 'namereclutador' },
                   { data: 'action', name: 'action' },
                ],
          "order": [],
          "columnDefs": [
              { "visible": false, "targets": 3 },
              { "orderable": false, "targets": 6 },
          ]
       });
    });
  
  function disableTabs(){

    $("#client-tab").attr('disabled',true);
    $("#general-tab").attr('disabled',true);
    $("#personal-tab").attr('disabled',true);
    $("#academic-tab").attr('disabled',true);
    $("#job-tab").attr('disabled',true);
    $("#additional-tab").attr('disabled',true);
    $("#economic-tab").attr('disabled',true);
    $("#process-tab").attr('disabled',true);
    $("#dataadd-tab").attr('disabled',true);
  }

  function enableTabs(){

    $("#client-tab").attr('disabled',false);
    $("#general-tab").attr('disabled',false);
    $("#personal-tab").attr('disabled',false);
    $("#academic-tab").attr('disabled',false);
    $("#job-tab").attr('disabled',false);
    $("#additional-tab").attr('disabled',false);
    $("#economic-tab").attr('disabled',false);
    $("#process-tab").attr('disabled',false);
    $("#dataadd-tab").attr('disabled',false);
  }

  $(".asignmentTime1").click(function(){
      $("#days").css("visibility","visible");
      $("#months").css("visibility","hidden");
      $("#invalid-months-required").removeClass("showFeedback");
  })

  $(".asignmentTime2").click(function(){
      $("#days").css("visibility","hidden");
      $("#months").css("visibility","visible");
      $("#invalid-days-required").removeClass("showFeedback");
  })

  $(".asignmentTime3").click(function(){
      $("#days").css("visibility","hidden");
      $("#months").css("visibility","hidden");
      $("#invalid-months-required").removeClass("showFeedback");
      $("#invalid-days-required").removeClass("showFeedback");
  })
  
    
  $("#generarRequerimientoNuevo").click(function(){
      $("#agregarRequerimientoModal").modal("show");

      $("#client-tab").addClass('active');   
      $("#clientDiv").addClass('active show');   
      $("#general-tab").removeClass('active');
      $("#personal-tab").removeClass('active');
      $("#academic-tab").removeClass('active');  
      $("#job-tab").removeClass('active');
      $("#additional-tab").removeClass('active');
      $("#economic-tab").removeClass('active');
      $("#process-tab").removeClass('active');
      $("#dataadd-tab").removeClass('active');
      $("#assign-tab").removeClass('active');

      $("#clientDiv").addClass('active show');   
      $("#generalDiv").removeClass('active show');
      $("#personalDiv").removeClass('active show');
      $("#academicDiv").removeClass('active show');
      $("#jobDiv").removeClass('active show');
      $("#additionalDiv").removeClass('active show');
      $("#economicDiv").removeClass('active show');
      $("#processDiv").removeClass('active show');
      $("#dataaddDiv").removeClass('active show');
      $("#assignDiv").removeClass('active show');

      disableTabs();

      $("#assign-tab").css('visibility','hidden');

      $("#guardarDatosClientes").prop('disabled',false);
      $("#guardarDatosGenerales").prop('disabled',false);
      $("#guardarDatosPersonales").prop('disabled',false);
      $("#guardarDatosAcademicos").prop('disabled',false);
      $("#guardarDatosPuesto").prop('disabled',false);
      $("#guardarDatosAdicionales").prop('disabled',false);
      $("#guardarDatosEconomicos").prop('disabled',false);
      $("#guardarDatosProceso").prop('disabled',false);
      $("#guardarDatosFinales").prop('disabled',false);

      $("#editarDatosClientes").prop('disabled',false);
      $("#editarDatosGenerales").prop('disabled',false);
      $("#editarDatosPersonales").prop('disabled',false);
      $("#editarDatosAcademicos").prop('disabled',false);
      $("#editarDatosPuesto").prop('disabled',false);
      $("#editarDatosAdicionales").prop('disabled',false);
      $("#editarDatosEconomicos").prop('disabled',false);
      $("#editarDatosProceso").prop('disabled',false);
      $("#editarDatosFinales").prop('disabled',false);

      $("#guardarDatosClientes").css('display','inline-block');
      $("#guardarDatosGenerales").css('display','none');
      $("#guardarDatosPersonales").css('display','none');
      $("#guardarDatosAcademicos").css('display','none');
      $("#guardarDatosPuesto").css('display','none');
      $("#guardarDatosAdicionales").css('display','none');
      $("#guardarDatosEconomicos").css('display','none');
      $("#guardarDatosProceso").css('display','none');
      $("#guardarDatosFinales").css('display','none');

      $("#editarDatosClientes").css('display','none');
      $("#editarDatosGenerales").css('display','none');
      $("#editarDatosPersonales").css('display','none');
      $("#editarDatosAcademicos").css('display','none');
      $("#editarDatosPuesto").css('display','none');
      $("#editarDatosAdicionales").css('display','none');
      $("#editarDatosEconomicos").css('display','none');
      $("#editarDatosProceso").css('display','none');
      $("#editarDatosFinales").css('display','none');

      $("#addApplicant").css('display','none');
      
      $("#agregarDatosClientes").trigger("reset");
      $("#cliente_id").val("");

      indexCert = 1;
      indexIdiom = 1;

      $("#buttonStatus").css('display','none');

      $("#idRequerimientoEdit").val('');
      $("#idRequerimientoUnico").val('');
  
  });

  let errores = 0;
  $("#guardarDatosClientes").click(function(){

        let cliente = $("#cliente_id").val().trim();

        //validar cliente
        if(cliente == '' || cliente == 0){
            $("#invalid-cliente_id-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-cliente_id-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosClientes").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingS").css("visibility","visible");


            $.ajax({
                type: "POST",
                data: { cliente: cliente,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/requestactions",
                success: function(msg){ 
                //console.log(msg);

                  if(msg[0] == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos del cliente agregados.",
                      });
                      table.ajax.reload();
                      $("#agregarDatosClientes").trigger("reset");
                      $("#agregarDatosGenerales").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#clientDiv").removeClass('active show');
                      $("#general-tab").addClass('active');
                      $("#generalDiv").addClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');
                      
                      enableTabs();
                      $("#days").css("visibility","visible");
                      $("#months").css("visibility","hidden");
                      $(".asignmentTime1").prop("checked", true);

                      $("#idRequerimientoUnico").val(msg[1]);
                      $("#guardarDatosClientes").css('display','none');
                      $("#guardarDatosGenerales").css('display','inline-block');

                      $("#idRequerimientoEdit").val("");
                      $("#idGeneralUnico").val("");

                  }

                  if(msg[0] == '0'){
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

                  $("#guardarDatosClientes").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingS").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosClientes").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });

  $("#editarDatosClientes").click(function(){

        let cliente = $("#cliente_id").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar cliente
        if(cliente == '' || cliente == 0){
            $("#invalid-cliente_id-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-cliente_id-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosClientes").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingS").css("visibility","visible");


            $.ajax({
                type: "POST",
                data: { cliente: cliente,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/clientdataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos del cliente actualizados.",
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

                  $("#editarDatosClientes").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingS").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosClientes").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });

  let erroresGenerales = 0;
  $(document).on("click", "#guardarDatosGenerales", function(){

        let position = $("#namePosition").val().trim();
        let numVacant = $("#numVacant").val().trim();
        let requestDate = $("#requestDate").val().trim();
        let requestService = $("#requestService").val().trim();
        let asignmentTime = $("#asignmentTime:checked").val().trim();
        let time = 0;
        let modality = $("#modality").val().trim();
        let timeBegin = $("#timeBegin").val().trim();
        let timeEnd = $("#timeEnd").val().trim();
        let executiveInCharge = $("#executiveInChargeID").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }
        let idGeneralUnico = $("#idGeneralUnico").val().trim();

        //validar position
        if(position == '' || position == 0){
            $("#invalid-namePosition-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-namePosition-required").removeClass("showFeedback");
        }

        //validar numVacant
        if(numVacant == '' || numVacant == 0){
            $("#invalid-numVacant-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-numVacant-required").removeClass("showFeedback");
        }

        //validar requestDate
        if(requestDate == '' || requestDate == 0){
            $("#invalid-requestDate-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-requestDate-required").removeClass("showFeedback");
        }

        if(asignmentTime == 1){
          time = $("#days").val().trim();

          if(time== "" || time== 0){
            $("#invalid-days-required").addClass("showFeedback");
            erroresGenerales++;
          }
          else{
            $("#invalid-days-required").removeClass("showFeedback");
          }
        }

        if(asignmentTime == 2){
          time = $("#months").val().trim();

          if(time== "" || time== 0){
            $("#invalid-months-required").addClass("showFeedback");
            erroresGenerales++;
          }
          else{
            $("#invalid-months-required").removeClass("showFeedback");
          }
        } 

        if(erroresGenerales > 0){
          erroresGenerales = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosGenerales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSGeneral").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { position: position,
                        numVacant: numVacant,
                        requestDate: requestDate,
                        requestService: requestService,
                        asignmentTime: asignmentTime,
                        time: time,
                        modality: modality,
                        timeBegin: timeBegin,
                        timeEnd: timeEnd,
                        executiveInCharge: executiveInCharge,
                        idGeneralUnico: idGeneralUnico,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/generaldata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos generales agregados.",
                      });

                      $("#agregarDatosPersonales").trigger("reset");
                      table.ajax.reload();

                      $.ajax({
                        type: "GET",
                        dataType: 'JSON',
                        data: { type: 3, "_token": "{{ csrf_token() }}" },
                        url: "/validateinformation/" + idRequerimiento,
                        success: function(msg){ 
                          console.log(msg);
                          if(msg == 1){
                                $.ajax({
                                    type: "GET",
                                    dataType: 'JSON',
                                    data: { "_token": "{{ csrf_token() }}" },
                                    url: "/personaldataget/" + idRequerimiento,
                                    success: function(msg){ 
                                      //console.log(msg);
                                      $("#idPersonalUnico").val(msg.id);
                                      $("#rangeAge").val(msg.rangoedad);
                                      $("#sex").html(msg.sexo_select);
                                      $("#civilstate").html(msg.estados_civiles_select);
                                      $("#residencePlace").val(msg.lugarresidencia);

                                      activeButtons(1, 'DatosPersonales');
                                      
                                    }
                                  });   


                                }
                                else{

                                    activeButtons(0, 'DatosPersonales');
                                    $("#idPersonalUnico").val("");
                                }
                          }
                      }); 
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").addClass('active');
                      $("#personalDiv").addClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');

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

                  $("#guardarDatosGenerales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSGeneral").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosGenerales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSGeneral").css("visibility","hidden");
                }
            }); 
    });


  $(document).on("click", "#editarDatosGenerales", function(){

        let position = $("#namePosition").val().trim();
        let numVacant = $("#numVacant").val().trim();
        let requestDate = $("#requestDate").val().trim();
        let requestService = $("#requestService").val().trim();
        let asignmentTime = $("#asignmentTime:checked").val().trim();
        let time = 0;
        let modality = $("#modality").val().trim();
        let timeBegin = $("#timeBegin").val().trim();
        let timeEnd = $("#timeEnd").val().trim();
        let executiveInCharge = $("#executiveInChargeID").val().trim();
        let idGeneralUnico = $("#idGeneralUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar position
        if(position == '' || position == 0){
            $("#invalid-namePosition-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-namePosition-required").removeClass("showFeedback");
        }

        //validar numVacant
        if(numVacant == '' || numVacant == 0){
            $("#invalid-numVacant-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-numVacant-required").removeClass("showFeedback");
        }

        //validar requestDate
        if(requestDate == '' || requestDate == 0){
            $("#invalid-requestDate-required").addClass("showFeedback");
            erroresGenerales++;
        }
        else{
            $("#invalid-requestDate-required").removeClass("showFeedback");
        }

        if(asignmentTime == 1){
          time = $("#days").val().trim();

          if(time== "" || time== 0){
            $("#invalid-days-required").addClass("showFeedback");
            erroresGenerales++;
          }
          else{
            $("#invalid-days-required").removeClass("showFeedback");
          }
        }

        if(asignmentTime == 2){
          time = $("#months").val().trim();

          if(time== "" || time== 0){
            $("#invalid-months-required").addClass("showFeedback");
            erroresGenerales++;
          }
          else{
            $("#invalid-months-required").removeClass("showFeedback");
          }
        } 

        if(erroresGenerales > 0){
          erroresGenerales = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosGenerales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSGeneral").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { position: position,
                        numVacant: numVacant,
                        requestDate: requestDate,
                        requestService: requestService,
                        asignmentTime: asignmentTime,
                        time: time,
                        modality: modality,
                        timeBegin: timeBegin,
                        timeEnd: timeEnd,
                        executiveInCharge: executiveInCharge,
                        idGeneralUnico: idGeneralUnico,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/generaldataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos generales actualizados.",
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

                  $("#editarDatosGenerales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSGeneral").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosGenerales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSGeneral").css("visibility","hidden");
                }
            }); 
    });

  let erroresPersonales = 0;
  $(document).on("click", "#guardarDatosPersonales", function(){

        let rangeAge = $("#rangeAge").val().trim();
        let sex = $("#sex").val().trim();
        let civilstate = $("#civilstate").val().trim();
        let residencePlace = $("#residencePlace").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }
        let idPersonal = $("#idPersonalUnico").val().trim();

        //validar rangeAge
        if(rangeAge == '' || rangeAge == 0){
            $("#invalid-rangeAge-required").addClass("showFeedback");
            erroresPersonales++;
        }
        else{
            $("#invalid-rangeAge-required").removeClass("showFeedback");
        }

        if(erroresPersonales > 0){
          erroresPersonales = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosPersonales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSPersonal").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { rangeAge: rangeAge,
                        sex: sex,
                        civilstate: civilstate,
                        residencePlace: residencePlace,
                        idPersonal: idPersonal,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/personaldata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos personales agregados.",
                      });
                      table.ajax.reload(); 
                      $("#agregarDatosAcademicos").trigger("reset");
                      indexCert = 0;
                      let certificate = '<div class="row" style="margin-bottom: 5px;margin-right:5px;">' +
                      '<input type="text" class="form-control certificado_class" id="certificado' + indexCert + '" name="certificado[' + indexCert + ']" maxlength="100" placeholder="Certificado o curso">' +
                      '</div>';
                      indexCert++;
                      $("#areaCertificate").html("");
                      $("#areaCertificate").append(certificate);

                      indexIdiom = 0;
                      let idiom = '<div class="row" style="margin-bottom: 5px;margin-right:5px;">' +
                        '<input type="text" class="form-control idiom_class" id="idiom' + indexIdiom + '" name="idiom[' + indexIdiom + ']" maxlength="100" placeholder="Idioma">' +
                        '</div>';
                      indexIdiom++;
                      $("#areaIdiom").html("");
                      $("#areaIdiom").append(idiom);
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#personalDiv").removeClass('active show');
                      $("#academic-tab").addClass('active');
                      $("#academicDiv").addClass('active show');
                      $("#job-tab").removeClass('active');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type: 4, "_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                            if(msg == 1){

                              $.ajax({
                                  type: "GET",
                                  dataType: 'JSON',
                                  data: { "_token": "{{ csrf_token() }}" },
                                  url: "/academicdataget/" + idRequerimiento,
                                  success: function(msg){ 
                                    //console.log(msg);
                                    
                                    $("#idAcademicoUnico").val(msg.id);
                                    $("#escolaridad").val(msg.escolaridad);
                                    $("#areaCertificate").html(msg.certificado_select);
                                    $("#areaIdiom").html(msg.idiom_select);

                                    indexCert = msg.certificado_num;
                                    indexIdiom = msg.idiom_num;
                                    activeButtons(1, 'DatosAcademicos');
                                    
                                  }
                              }); 

                            }
                            else{
                              activeButtons(0, 'DatosAcademicos');
                              $("#idAcademicoUnico").val("");
                            }
                            
                          }
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

                  $("#guardarDatosPersonales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSPersonal").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosPersonales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSPersonal").css("visibility","hidden");
                }
            }); 
    });

  $(document).on("click", "#editarDatosPersonales", function(){

        let rangeAge = $("#rangeAge").val().trim();
        let sex = $("#sex").val().trim();
        let civilstate = $("#civilstate").val().trim();
        let residencePlace = $("#residencePlace").val().trim();
        let idPersonal = $("#idPersonalUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar rangeAge
        if(rangeAge == '' || rangeAge == 0){
            $("#invalid-rangeAge-required").addClass("showFeedback");
            erroresPersonales++;
        }
        else{
            $("#invalid-rangeAge-required").removeClass("showFeedback");
        }

        if(erroresPersonales > 0){
          erroresPersonales = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosPersonales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSPersonal").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { rangeAge: rangeAge,
                        sex: sex,
                        civilstate: civilstate,
                        residencePlace: residencePlace,
                        idPersonal: idPersonal,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                dataType: 'JSON',
                url: "/personaldataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos personales actualizados.",
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

                  $("#editarDatosPersonales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSPersonal").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosPersonales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSPersonal").css("visibility","hidden");
                }
            }); 
    });


    let erroresAcademicos = 0;
  $(document).on("click", "#guardarDatosAcademicos", function(){

        let escolaridad = $("#escolaridad").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }
        let idAcademico = $("#idAcademicoUnico").val().trim();

        //validar escolaridad
        if(escolaridad == '' || escolaridad == 0){
            $("#invalid-escolaridad-required").addClass("showFeedback");
            erroresAcademicos++;
        }
        else{
            $("#invalid-escolaridad-required").removeClass("showFeedback");
        }

        if(erroresAcademicos > 0){
          erroresAcademicos = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosAcademicos").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSAcademic").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: $( "#agregarDatosAcademicos" ).serialize() + "&idRequerimiento="+ idRequerimiento + "&idAcademico=" + idAcademico +"&_token="+"{{ csrf_token() }}" ,
                dataType: 'JSON',
                url: "/academicdata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos academicos agregados.",
                      });
                      table.ajax.reload();

                      $("#agregarDatosPuesto").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").addClass('active');
                      $("#jobDiv").addClass('active show');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');
                      

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type: 5, "_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                            if(msg == 1){

                              $.ajax({
                                  type: "GET",
                                  dataType: 'JSON',
                                  data: { "_token": "{{ csrf_token() }}" },
                                  url: "/jobdataget/" + idRequerimiento,
                                  success: function(msg){ 
                                    //console.log(msg);
                                    
                                    $("#idPuestoUnico").val(msg.id);
                                    $("#experience").val(msg.experiencia);
                                    $("#activities").val(msg.actividades);
                                    $("#technical_knowledge").val(msg.conocimientos_tecnicos);
                                    $("#necessary_skills").val(msg.competencias_necesarias);
                                
                                    activeButtons(1, 'DatosPuesto');
                                  }
                              }); 

                            }
                            else{
                                activeButtons(0, 'DatosPuesto');
                                $("#idPuestoUnico").val("");
                            }
                        
                            
                          }
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

                  $("#guardarDatosAcademicos").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSAcademic").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosAcademicos").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSAcademic").css("visibility","hidden");
                }
            }); 
    });

    $(document).on("click", "#editarDatosAcademicos", function(){

        let escolaridad = $("#escolaridad").val().trim();
        let idAcademico = $("#idAcademicoUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar escolaridad
        if(escolaridad == '' || escolaridad == 0){
            $("#invalid-escolaridad-required").addClass("showFeedback");
            erroresAcademicos++;
        }
        else{
            $("#invalid-escolaridad-required").removeClass("showFeedback");
        }

        if(erroresAcademicos > 0){
          erroresAcademicos = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosAcademicos").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSAcademic").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: $( "#agregarDatosAcademicos" ).serialize() + "&idRequerimiento="+ idRequerimiento + "&idAcademico=" + idAcademico + "&_token="+"{{ csrf_token() }}" ,
                dataType: 'JSON',
                url: "/academicdataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos academicos actualizados.",
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

                  $("#editarDatosAcademicos").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSAcademic").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosAcademicos").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSAcademic").css("visibility","hidden");
                }
            }); 
        });

  let erroresPuesto = 0;
  $(document).on("click", "#guardarDatosPuesto", function(){

        let experience = $("#experience").val().trim();
        let activities = $("#activities").val().trim();
        let technical_knowledge = $("#technical_knowledge").val().trim();
        let necessary_skills = $("#necessary_skills").val().trim();
        let idPuesto = $("#idPuestoUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }

        //validar experience
        if(experience == '' || experience == 0){
            $("#invalid-experience-required").addClass("showFeedback");
            erroresPuesto++;
        }
        else{
            $("#invalid-experience-required").removeClass("showFeedback");
        }

        if(erroresPuesto > 0){
          erroresPuesto = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosPuesto").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSJob").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        experience: experience,
                        activities: activities,
                        technical_knowledge: technical_knowledge,
                        necessary_skills: necessary_skills,
                        idPuesto: idPuesto,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/jobdata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos del puesto agregados.",
                      });
                      table.ajax.reload();

                      $("#agregarDatosAdicional").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#jobDiv").removeClass('active show');
                      $("#additional-tab").addClass('active');
                      $("#additionalDiv").addClass('active show');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');   

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type:6, "_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                            if(msg == 1){

                              $.ajax({
                                  type: "GET",
                                  dataType: 'JSON',
                                  data: { "_token": "{{ csrf_token() }}" },
                                  url: "/additionaldataget/" + idRequerimiento,
                                  success: function(msg){ 
                                    //console.log(msg);
                                    
                                    $("#idAdicionalUnico").val(msg.id);
                                    $(".desplazarse" + msg.desplazarse).prop("checked", true);
                                    $(".viajar" + msg.viajar).prop("checked", true);
                                    $(".disponibilidad_horario" + msg.disponibilidad_horario).prop("checked", true);
                                    $(".personal_cargo" + msg.personal_cargo).prop("checked", true);
                                    $(".equipo_computo" + msg.equipo_computo).prop("checked", true);
                                    
                                    $("#persona_reporta").val(msg.persona_reporta);
                                    $("#desplazarse_motivo").val(msg.desplazarse_motivo);
                                    $("#viajar_motivo").val(msg.viajar_motivo);
                                    $("#disponibilidad_horario_motivo").val(msg.disponibilidad_horario_motivo);
                                    $("#num_personas_cargo").val(msg.num_personas_cargo);

                                    activeButtons(1, 'DatosAdicionales');
                                  }
                              }); 

                            }
                            else{
                                activeButtons(0, 'DatosAdicionales');
                                $("#idAdicionalUnico").val("");
                            }
                            
                          }
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

                  $("#guardarDatosPuesto").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSJob").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosPuesto").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSJob").css("visibility","hidden");
                }
            }); 
    });

$(document).on("click", "#editarDatosPuesto", function(){

  let experience = $("#experience").val().trim();
  let activities = $("#activities").val().trim();
  let technical_knowledge = $("#technical_knowledge").val().trim();
  let necessary_skills = $("#necessary_skills").val().trim();
  let idPuesto = $("#idPuestoUnico").val().trim();
  let idRequerimiento = $("#idRequerimientoEdit").val().trim();

  //validar experience
  if(experience == '' || experience == 0){
      $("#invalid-experience-required").addClass("showFeedback");
      erroresPuesto++;
  }
  else{
      $("#invalid-experience-required").removeClass("showFeedback");
  }

  if(erroresPuesto > 0){
    erroresPuesto = 0;
      $(".showErrorsPersonales").css("display","flex");
      setTimeout(function(){
          $(".showErrorsPersonales").css("display","none");
      }, 5000);
      return;
  }

  $("#editarDatosPuesto").attr("disabled",true);
  $("#cancelarDatosClientes").attr("disabled",true);
  $("#loadingSJob").css("visibility","visible");

      $.ajax({
          type: "POST",
          data: { 
                  experience: experience,
                  activities: activities,
                  technical_knowledge: technical_knowledge,
                  necessary_skills: necessary_skills,
                  idPuesto: idPuesto,
                  idRequerimiento: idRequerimiento,
                  "_token": "{{ csrf_token() }}" 
                } ,
          dataType: 'JSON',
          url: "/jobdataedit",
          success: function(msg){ 
          //console.log(msg);

            if(msg == '1'){

                Lobibox.notify("success", {
                size: "mini",
                rounded: true,
                delay: 3000,
                delayIndicator: false,
                position: "center top",
                msg: "Datos del puesto actualizados.",
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

            $("#editarDatosPuesto").attr("disabled",false);
            $("#cancelarDatosClientes").attr("disabled",false);
            $("#loadingSJob").css("visibility","hidden");
          },
          error: function (err) {
            //console.log(err);
              let mensaje = '';
              let contenido;
              $.each(err.responseJSON.errors, function (key, value) {
                  //console.log("min " +value);
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
              $("#editarDatosPuesto").attr("disabled",false);
              $("#cancelarDatosClientes").attr("disabled",false);
              $("#loadingSJob").css("visibility","hidden");
          }
      }); 
  });

  let erroresAdicionales = 0;
  $(document).on("click", "#guardarDatosAdicionales", function(){

        let desplazarse = $('#desplazarse:checked').val();
        let desplazarse_motivo = $("#desplazarse_motivo").val().trim();
        let viajar = $("#viajar:checked").val();
        let viajar_motivo = $("#viajar_motivo").val().trim();
        let disponibilidad_horario = $('#disponibilidad_horario:checked').val();
        let disponibilidad_horario_motivo = $("#disponibilidad_horario_motivo").val().trim();
        let personal_cargo = $("#personal_cargo:checked").val();
        let num_personas_cargo = $("#num_personas_cargo").val().trim();
        let persona_reporta = $("#persona_reporta").val().trim();
        let equipo_computo = $("#equipo_computo:checked").val();
        let idAdicional = $("#idAdicionalUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }

        //validar desplazarse_motivo
        if(desplazarse == 3){
            if(desplazarse_motivo == '' || desplazarse_motivo == 0){
              $("#invalid-desplazarse_motivo-required").addClass("showFeedback");
              erroresAdicionales++;
            }
            else{
                $("#invalid-desplazarse_motivo-required").removeClass("showFeedback");
            }
        }

        //validar desplazarse_motivo
        if(disponibilidad_horario == 3){
            if(disponibilidad_horario_motivo == '' || disponibilidad_horario_motivo == 0){
              $("#invalid-disponibilidad_horario_motivo-required").addClass("showFeedback");
              erroresPuesto++;
            }
            else{
                $("#invalid-disponibilidad_horario_motivo-required").removeClass("showFeedback");
            }
        }

        if(viajar == 3){
            if(viajar_motivo == '' || viajar_motivo == 0){
              $("#invalid-viajar_motivo-required").addClass("showFeedback");
              erroresPuesto++;
            }
            else{
                $("#invalid-viajar_motivo-required").removeClass("showFeedback");
            }
        }
        

        if(erroresAdicionales > 0){
          erroresAdicionales = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosAdicionales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSAdicionales").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        desplazarse: desplazarse,
                        desplazarse_motivo: desplazarse_motivo,
                        viajar: viajar,
                        viajar_motivo: viajar_motivo,
                        disponibilidad_horario: disponibilidad_horario,
                        disponibilidad_horario_motivo: disponibilidad_horario_motivo,
                        personal_cargo: personal_cargo,
                        num_personas_cargo: num_personas_cargo,
                        equipo_computo: equipo_computo,
                        persona_reporta: persona_reporta,
                        idAdicional: idAdicional,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/additionaldata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos adicionales agregados.",
                      });

                      table.ajax.reload();

                      $("#agregarDatosEconomicos").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#jobDiv").removeClass('active show');
                      $("#additional-tab").removeClass('active');
                      $("#additionalDiv").removeClass('active show');
                      $("#economic-tab").addClass('active');
                      $("#economicDiv").addClass('active show');
                      $("#process-tab").removeClass('active');
                      $("#dataadd-tab").removeClass('active');

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type: 7,"_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                            if(msg == 1){

                              $.ajax({
                                  type: "GET",
                                  dataType: 'JSON',
                                  data: { "_token": "{{ csrf_token() }}" },
                                  url: "/economicdataget/" + idRequerimiento,
                                  success: function(msg){ 
                                    //console.log(msg);
                                    
                                    $("#idEconomicoUnico").val(msg.id);
                                    $("#esquemacontratacion").val(msg.esquemacontratacion);
                                    $("#tiposalario").val(msg.tiposalario);
                                    $("#montominimo").val(msg.montominimo);
                                    $("#montomaximo").val(msg.montomaximo);
                                    $("#jornadalaboral").val(msg.jornadalaboral);
                                    $("#prestaciones_beneficios").val(msg.prestaciones_beneficios);
                                
                                    activeButtons(1, 'DatosEconomicos');    
                                  }
                              }); 

                            }else{
                              activeButtons(0, 'DatosEconomicos');
                              $("#idEconomicoUnico").val("");
                            }
                        
                            
                          }
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

                  $("#guardarDatosAdicionales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSAdicionales").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosAdicionales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSAdicionales").css("visibility","hidden");
                }
            }); 
    });

    $(document).on("click", "#editarDatosAdicionales", function(){

        let desplazarse = $('#desplazarse:checked').val();
        let desplazarse_motivo = $("#desplazarse_motivo").val().trim();
        let viajar = $("#viajar:checked").val();
        let viajar_motivo = $("#viajar_motivo").val().trim();
        let disponibilidad_horario = $('#disponibilidad_horario:checked').val();
        let disponibilidad_horario_motivo = $("#disponibilidad_horario_motivo").val().trim();
        let personal_cargo = $("#personal_cargo:checked").val();
        let num_personas_cargo = $("#num_personas_cargo").val().trim();
        let persona_reporta = $("#persona_reporta").val().trim();
        let equipo_computo = $("#equipo_computo:checked").val();
        let idAdicional = $("#idAdicionalUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar desplazarse_motivo
        if(desplazarse == 3){
            if(desplazarse_motivo == '' || desplazarse_motivo == 0){
              $("#invalid-desplazarse_motivo-required").addClass("showFeedback");
              erroresAdicionales++;
            }
            else{
                $("#invalid-desplazarse_motivo-required").removeClass("showFeedback");
            }
        }

        //validar desplazarse_motivo
        if(disponibilidad_horario == 3){
            if(disponibilidad_horario_motivo == '' || disponibilidad_horario_motivo == 0){
              $("#invalid-disponibilidad_horario_motivo-required").addClass("showFeedback");
              erroresPuesto++;
            }
            else{
                $("#invalid-disponibilidad_horario_motivo-required").removeClass("showFeedback");
            }
        }

        if(viajar == 3){
            if(viajar_motivo == '' || viajar_motivo == 0){
              $("#invalid-viajar_motivo-required").addClass("showFeedback");
              erroresPuesto++;
            }
            else{
                $("#invalid-viajar_motivo-required").removeClass("showFeedback");
            }
        }


        if(erroresAdicionales > 0){
          erroresAdicionales = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosAdicionales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSAdicionales").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        desplazarse: desplazarse,
                        desplazarse_motivo: desplazarse_motivo,
                        viajar: viajar,
                        viajar_motivo: viajar_motivo,
                        disponibilidad_horario: disponibilidad_horario,
                        disponibilidad_horario_motivo: disponibilidad_horario_motivo,
                        personal_cargo: personal_cargo,
                        num_personas_cargo: num_personas_cargo,
                        persona_reporta: persona_reporta,
                        equipo_computo: equipo_computo,
                        idAdicional: idAdicional,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/additionaldataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos adicionales actualizados.",
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

                  $("#editarDatosAdicionales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSAdicionales").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosAdicionales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSAdicionales").css("visibility","hidden");
                }
            }); 
        });

    let erroresEconomicos = 0;
    $(document).on("click", "#guardarDatosEconomicos", function(){

        let esquemacontratacion = $("#esquemacontratacion").val().trim();
        let tiposalario = $("#tiposalario").val().trim();
        let montominimo = $("#montominimo").val().trim();
        let montomaximo = $("#montomaximo").val().trim();
        let jornadalaboral = $("#jornadalaboral").val().trim();
        let prestaciones_beneficios = $("#prestaciones_beneficios").val().trim();
        let idEconomico = $("#idEconomicoUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }

        //validar esquemacontratacion
        if(esquemacontratacion == '' || esquemacontratacion == 0){
            $("#invalid-esquemacontratacion-required").addClass("showFeedback");
            erroresEconomicos++;
        }
        else{
            $("#invalid-esquemacontratacion-required").removeClass("showFeedback");
        }

        //validar montominimo
        if(montominimo == '' || montominimo == 0){
            $("#invalid-montominimo-required").addClass("showFeedback");
            erroresEconomicos++;
        }
        else{
            $("#invalid-montominimo-required").removeClass("showFeedback");
        }

        //validar montomaximo
        if(montomaximo == '' || montomaximo == 0){
            $("#invalid-montomaximo-required").addClass("showFeedback");
            erroresEconomicos++;
        }
        else{
            $("#invalid-montomaximo-required").removeClass("showFeedback");
        }

        if(erroresEconomicos > 0){
          erroresEconomicos = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosEconomicos").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSEconomic").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        esquemacontratacion: esquemacontratacion,
                        tiposalario: tiposalario,
                        montominimo: montominimo,
                        montomaximo: montomaximo,
                        jornadalaboral: jornadalaboral,
                        prestaciones_beneficios: prestaciones_beneficios,
                        idEconomico: idEconomico,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/economicdata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos economicos agregados.",
                      });
                      table.ajax.reload();
                      $("#agregarDatosProceso").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#jobDiv").removeClass('active show');
                      $("#additional-tab").removeClass('active');
                      $("#additionalDiv").removeClass('active show');
                      $("#economic-tab").removeClass('active');
                      $("#economicDiv").removeClass('active show');
                      $("#process-tab").addClass('active');
                      $("#processDiv").addClass('active show');
                      $("#dataadd-tab").removeClass('active');
                      

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type:8,"_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                              if(msg == 1){

                                $.ajax({
                                    type: "GET",
                                    dataType: 'JSON',
                                    data: { "_token": "{{ csrf_token() }}" },
                                    url: "/processdataget/" + idRequerimiento,
                                    success: function(msg){ 
                                      //console.log(msg);
                                      
                                      $("#idProcesoUnico").val(msg.id);
                                      $("#duracion").val(msg.duracion);
                                      $("#cantidadfiltros").val(msg.cantidadfiltros);
                                      $("#niveles_flitro").val(msg.niveles_flitro);
                                      
                                      if(msg.entrevista == 1){
                                        $("#entrevista").prop("checked", true);
                                      }
                                      else{
                                        $("#entrevista").prop("checked", false);
                                      }

                                      if(msg.pruebatecnica == 1){
                                        $("#pruebat").prop("checked", true);
                                      }
                                      else{
                                        $("#pruebat").prop("checked", false);
                                      }

                                      if(msg.pruebapsicometrica == 1){
                                        $("#pruebap").prop("checked", true);
                                      }
                                      else{
                                        $("#pruebap").prop("checked", false);
                                      }

                                      if(msg.referencias == 1){
                                        $("#referencias").prop("checked", true);
                                      }
                                      else{
                                        $("#referencias").prop("checked", false);
                                      }

                                      if(msg.entrevista_tecnica == 1){
                                        $("#entrevista_tecnica").prop("checked", true);
                                      }
                                      else{
                                        $("#entrevista_tecnica").prop("checked", false);
                                      }

                                      if(msg.estudio_socioeconomico == 1){
                                        $("#estudio_socioeconomico").prop("checked", true);
                                      }
                                      else{
                                        $("#estudio_socioeconomico").prop("checked", false);
                                      }

                                      activeButtons(1, 'DatosProceso');
                                      
                                    }
                                }); 

                              }
                              else{
                                activeButtons(0, 'DatosProceso');
                                $("#idProcesoUnico").val("");
                              }
                            
                          }
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

                  $("#guardarDatosEconomicos").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSEconomic").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosEconomicos").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSEconomic").css("visibility","hidden");
                }
            }); 
    });

    

    $(document).on("click", "#editarDatosEconomicos", function(){

      let esquemacontratacion = $("#esquemacontratacion").val().trim();
      let tiposalario = $("#tiposalario").val().trim();
      let montominimo = $("#montominimo").val().trim();
      let montomaximo = $("#montomaximo").val().trim();
      let jornadalaboral = $("#jornadalaboral").val().trim();
      let prestaciones_beneficios = $("#prestaciones_beneficios").val().trim();
      let idEconomico = $("#idEconomicoUnico").val().trim();
      let idRequerimiento = $("#idRequerimientoEdit").val().trim();

      //validar esquemacontratacion
      if(esquemacontratacion == '' || esquemacontratacion == 0){
          $("#invalid-esquemacontratacion-required").addClass("showFeedback");
          erroresEconomicos++;
      }
      else{
          $("#invalid-esquemacontratacion-required").removeClass("showFeedback");
      }

      //validar montominimo
      if(montominimo == '' || montominimo == 0){
          $("#invalid-montominimo-required").addClass("showFeedback");
          erroresEconomicos++;
      }
      else{
          $("#invalid-montominimo-required").removeClass("showFeedback");
      }

      //validar montomaximo
      if(montomaximo == '' || montomaximo == 0){
          $("#invalid-montomaximo-required").addClass("showFeedback");
          erroresEconomicos++;
      }
      else{
          $("#invalid-montomaximo-required").removeClass("showFeedback");
      }

      if(erroresEconomicos > 0){
        erroresEconomicos = 0;
          $(".showErrorsPersonales").css("display","flex");
          setTimeout(function(){
              $(".showErrorsPersonales").css("display","none");
          }, 5000);
          return;
      }

      $("#editarDatosEconomicos").attr("disabled",true);
      $("#cancelarDatosClientes").attr("disabled",true);
      $("#loadingSEconomic").css("visibility","visible");

          $.ajax({
              type: "POST",
              data: { 
                      esquemacontratacion: esquemacontratacion,
                      tiposalario: tiposalario,
                      montominimo: montominimo,
                      montomaximo: montomaximo,
                      jornadalaboral: jornadalaboral,
                      prestaciones_beneficios: prestaciones_beneficios,
                      idEconomico: idEconomico,
                      idRequerimiento: idRequerimiento,
                      "_token": "{{ csrf_token() }}" 
                    } ,
              dataType: 'JSON',
              url: "/economicdataedit",
              success: function(msg){ 
              //console.log(msg);

                if(msg == '1'){

                    Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "Datos economicos actualizados.",
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

                $("#editarDatosEconomicos").attr("disabled",false);
                $("#cancelarDatosClientes").attr("disabled",false);
                $("#loadingSEconomic").css("visibility","hidden");
              },
              error: function (err) {
                //console.log(err);
                  let mensaje = '';
                  let contenido;
                  $.each(err.responseJSON.errors, function (key, value) {
                      //console.log("min " +value);
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
                  $("#editarDatosEconomicos").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSEconomic").css("visibility","hidden");
              }
          }); 
      });

    let erroresProceso = 0;
  $(document).on("click", "#guardarDatosProceso", function(){

        let duracion = $("#duracion").val().trim();
        let cantidadfiltros = $("#cantidadfiltros").val().trim();
        let niveles_flitro = $("#niveles_flitro").val().trim();
        let entrevista;
        if( $('#entrevista').is(':checked') ){
            entrevista = 1;
        }
        else{
            entrevista = 0;
        }
        let pruebat;
        if( $('#pruebat').is(':checked') ){
            pruebat = 1;
        }
        else{
            pruebat = 0;
        }
        let pruebap;
        if( $('#pruebap').is(':checked') ){
            pruebap = 1;
        }
        else{
            pruebap = 0;
        }
        let referencias;
        if( $('#referencias').is(':checked') ){
            referencias = 1;
        }
        else{
            referencias = 0;
        }
        let entrevista_tecnica;
        if( $('#entrevista_tecnica').is(':checked') ){
            entrevista_tecnica = 1;
        }
        else{
            entrevista_tecnica = 0;
        }
        let estudio_socioeconomico;
        if( $('#estudio_socioeconomico').is(':checked') ){
            estudio_socioeconomico = 1;
        }
        else{
            estudio_socioeconomico = 0;
        }
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }

        let idProceso = $("#idProcesoUnico").val().trim();

        //validar duracion
        if(duracion == '' || duracion == 0){
            $("#invalid-duracion-required").addClass("showFeedback");
            erroresProceso++;
        }
        else{
            $("#invalid-duracion-required").removeClass("showFeedback");
        }

        if(erroresProceso > 0){
          erroresProceso = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosProceso").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSProcess").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        duracion: duracion,
                        cantidadfiltros: cantidadfiltros,
                        niveles_flitro: niveles_flitro,
                        entrevista: entrevista,
                        pruebat: pruebat,
                        pruebap: pruebap,
                        referencias: referencias,
                        entrevista_tecnica: entrevista_tecnica,
                        estudio_socioeconomico: estudio_socioeconomico,
                        idRequerimiento: idRequerimiento,
                        idProceso: idProceso,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/processdata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos del proceso agregados.",
                      });
                      table.ajax.reload();
                      $("#agregarDatosFinal").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#jobDiv").removeClass('active show');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#processDiv").removeClass('active show');
                      $("#dataadd-tab").addClass('active');
                      $("#dataaddDiv").addClass('active show');
                      

                      $.ajax({
                          type: "GET",
                          dataType: 'JSON',
                          data: { type: 9 ,"_token": "{{ csrf_token() }}" },
                          url: "/validateinformation/" + idRequerimiento,
                          success: function(msg){ 
                            //console.log(msg);
                            
                            if(msg == 1){

                              $.ajax({
                                  type: "GET",
                                  dataType: 'JSON',
                                  data: { "_token": "{{ csrf_token() }}" },
                                  url: "/finaldataget/" + idRequerimiento,
                                  success: function(msg){ 
                                    //console.log(msg);
                                    
                                    $("#idFinalUnico").val(msg.id);
                                    $("#razonnocontratacion").val(msg.razonnocontratacion);
                                    $("#fechacontratacion").val(msg.fechacontratacion);

                                    activeButtons(1, 'DatosFinales');
                                  }
                              }); 
                            }
                            else{
                              activeButtons(0, 'DatosFinales');
                              $("#idFinalUnico").val("");
                            }
                            
                          }
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

                  $("#guardarDatosProceso").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSProcess").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosProceso").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSProcess").css("visibility","hidden");
                }
            }); 
    });

    $(document).on("click", "#editarDatosProceso", function(){

        let duracion = $("#duracion").val().trim();
        let cantidadfiltros = $("#cantidadfiltros").val().trim();
        let niveles_flitro = $("#niveles_flitro").val().trim();
        let entrevista;
        if( $('#entrevista').is(':checked') ){
            entrevista = 1;
        }
        else{
            entrevista = 0;
        }
        let pruebat;
        if( $('#pruebat').is(':checked') ){
            pruebat = 1;
        }
        else{
            pruebat = 0;
        }
        let pruebap;
        if( $('#pruebap').is(':checked') ){
            pruebap = 1;
        }
        else{
            pruebap = 0;
        }
        let referencias;
        if( $('#referencias').is(':checked') ){
            referencias = 1;
        }
        else{
            referencias = 0;
        }
        let entrevista_tecnica;
        if( $('#entrevista_tecnica').is(':checked') ){
            entrevista_tecnica = 1;
        }
        else{
            entrevista_tecnica = 0;
        }
        let estudio_socioeconomico;
        if( $('#estudio_socioeconomico').is(':checked') ){
            estudio_socioeconomico = 1;
        }
        else{
            estudio_socioeconomico = 0;
        }
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();
        let idProceso = $("#idProcesoUnico").val().trim();

        //validar duracion
        if(duracion == '' || duracion == 0){
            $("#invalid-duracion-required").addClass("showFeedback");
            erroresProceso++;
        }
        else{
            $("#invalid-duracion-required").removeClass("showFeedback");
        }

        if(erroresProceso > 0){
          erroresProceso = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosProceso").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSProcess").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        duracion: duracion,
                        cantidadfiltros: cantidadfiltros,
                        niveles_flitro: niveles_flitro,
                        entrevista: entrevista,
                        pruebat: pruebat,
                        pruebap: pruebap,
                        referencias: referencias,
                        entrevista_tecnica: entrevista_tecnica,
                        estudio_socioeconomico: estudio_socioeconomico,
                        idRequerimiento: idRequerimiento,
                        idProceso: idProceso,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/processdataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos del proceso actualizados.",
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

                  $("#editarDatosProceso").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSProcess").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosProceso").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSProcess").css("visibility","hidden");
                }
            }); 
        });

    let erroresFinal = 0;
  $(document).on("click", "#guardarDatosFinales", function(){

        let razonnocontratacion = $("#razonnocontratacion").val().trim();
        let fechacontratacion = $("#fechacontratacion").val().trim();
        let idRequerimiento = $("#idRequerimientoUnico").val().trim();
        
        if(idRequerimiento == ""){
          idRequerimiento = $("#idRequerimientoEdit").val().trim();
        }
        let idFinal = $("#idFinalUnico").val().trim();

        //validar fechacontratacion
        if(razonnocontratacion == '' && fechacontratacion == ''){
            $("#invalid-fechacontratacion-required").addClass("showFeedback");
            erroresFinal++;
        }
        else{
            $("#invalid-fechacontratacion-required").removeClass("showFeedback");
        }

        if(erroresFinal > 0){
          erroresFinal = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarDatosFinales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSFinal").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        razonnocontratacion: razonnocontratacion,
                        fechacontratacion: fechacontratacion,
                        idRequerimiento: idRequerimiento,
                        idFinal: idFinal,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/finaldata",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos completados.",
                      });
                      table.ajax.reload();
                      $("#agregarDatosFinal").trigger("reset");
                      
                      $("#client-tab").removeClass('active');   
                      $("#general-tab").removeClass('active');
                      $("#generalDiv").removeClass('active show');
                      $("#personal-tab").removeClass('active');
                      $("#academicDiv").removeClass('active show');
                      $("#academic-tab").removeClass('active');
                      $("#job-tab").removeClass('active');
                      $("#jobDiv").removeClass('active show');
                      $("#additional-tab").removeClass('active');
                      $("#economic-tab").removeClass('active');
                      $("#process-tab").removeClass('active');
                      $("#processDiv").removeClass('active show');
                      $("#dataadd-tab").addClass('active');
                      $("#dataaddDiv").addClass('active show');
                      

                      $("#guardarDatosFinales").css('display','inline-block');
                      $("#agregarRequerimientoModal").modal('hide');

                      $("#idRequerimientoEdit").val("");
                      $("#idFinalUnico").val("");
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

                  $("#guardarDatosFinales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSFinal").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarDatosFinales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSFinal").css("visibility","hidden");
                }
            }); 
    });

    $(document).on("click", "#editarDatosFinales", function(){

        let razonnocontratacion = $("#razonnocontratacion").val().trim();
        let fechacontratacion = $("#fechacontratacion").val().trim();
        let idFinal = $("#idFinalUnico").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        //validar fechacontratacion
        if(razonnocontratacion == '' && fechacontratacion == ''){
            $("#invalid-fechacontratacion-required").addClass("showFeedback");
            erroresFinal++;
        }
        else{
            $("#invalid-fechacontratacion-required").removeClass("showFeedback");
        }

        if(erroresFinal > 0){
          erroresFinal = 0;
            $(".showErrorsPersonales").css("display","flex");
            setTimeout(function(){
                $(".showErrorsPersonales").css("display","none");
            }, 5000);
            return;
        }

        $("#editarDatosFinales").attr("disabled",true);
        $("#cancelarDatosClientes").attr("disabled",true);
        $("#loadingSFinal").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        razonnocontratacion: razonnocontratacion,
                        fechacontratacion: fechacontratacion,
                        idRequerimiento: idRequerimiento,
                        idFinal: idFinal,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/finaldataedit",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Datos adicionales actualizados.",
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

                  $("#editarDatosFinales").attr("disabled",false);
                  $("#cancelarDatosClientes").attr("disabled",false);
                  $("#loadingSFinal").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#editarDatosFinales").attr("disabled",false);
                    $("#cancelarDatosClientes").attr("disabled",false);
                    $("#loadingSFinal").css("visibility","hidden");
                }
            }); 
        });

    

    let classNameG;
    $(document).on("click", ".editar, .ver_editar", function(){
      let id = this.id;
      let getClass = this.className;
      let array = getClass.split(" ");
      classNameG = array[0];

      $("#idRequerimientoEdit").val('');
      $("#idRequerimientoUnico").val('');
      $("#agregarDatosClientes").trigger("reset");
      //$("#erroresAgregarEditar").css('display','none');
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/clientdataget/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#idRequerimientoEdit").val(msg.id);
              $("#cliente_id").html(msg.client_select);
              $("#cliente_id").trigger("change");

              $("#client-tab").addClass('active');   
              $("#clientDiv").addClass('active show');   
              $("#general-tab").removeClass('active');
              $("#personal-tab").removeClass('active');
              $("#academic-tab").removeClass('active');  
              $("#job-tab").removeClass('active');
              $("#additional-tab").removeClass('active');
              $("#economic-tab").removeClass('active');
              $("#process-tab").removeClass('active');
              $("#dataadd-tab").removeClass('active');

              $("#clientDiv").addClass('active show');   
              $("#generalDiv").removeClass('active show');
              $("#personalDiv").removeClass('active show');
              $("#academicDiv").removeClass('active show');
              $("#jobDiv").removeClass('active show');
              $("#additionalDiv").removeClass('active show');
              $("#economicDiv").removeClass('active show');
              $("#processDiv").removeClass('active show');
              $("#dataaddDiv").removeClass('active show');

              $("#assign-tab").removeClass('active');
	            $("#assignDiv").removeClass('active show');

              $("#guardarDatosClientes").css('display','none');
              $("#guardarDatosGenerales").css('display','none');
              $("#guardarDatosPersonales").css('display','none');
              $("#guardarDatosAcademicos").css('display','none');
              $("#guardarDatosPuesto").css('display','none');
              $("#guardarDatosAdicionales").css('display','none');
              $("#guardarDatosEconomicos").css('display','none');
              $("#guardarDatosProceso").css('display','none');
              $("#guardarDatosFinales").css('display','none');

              $("#editarDatosClientes").css('display','inline-block');
              $("#editarDatosGenerales").css('display','none');
              $("#editarDatosPersonales").css('display','none');
              $("#editarDatosAcademicos").css('display','none');
              $("#editarDatosPuesto").css('display','none');
              $("#editarDatosAdicionales").css('display','none');
              $("#editarDatosEconomicos").css('display','none');
              $("#editarDatosProceso").css('display','none');
              $("#editarDatosFinales").css('display','none');

              $("#addApplicant").css('display','none');
              
              $("#client-tab").attr('disabled',false);
              $("#general-tab").attr('disabled',false);
              $("#personal-tab").attr('disabled',false);
              $("#academic-tab").attr('disabled',false);
              $("#job-tab").attr('disabled',false);
              $("#additional-tab").attr('disabled',false);
              $("#economic-tab").attr('disabled',false);
              $("#process-tab").attr('disabled',false);
              $("#dataadd-tab").attr('disabled',false);

              if(msg.show_assign == 1){
                $("#assign-tab").css('visibility','visible');
              }
              else{
                $("#assign-tab").css('visibility','hidden');
              }

              $("#buttonStatus").css('display','block');
              if(msg.estatus_vacante == 3 || msg.estatus_vacante == 4){
                $("#buttonRecruitment").css('display','block');
                $("#buttonApplicant").css('display','block');
              }
              else{
                $("#buttonRecruitment").css('display','none');
                $("#buttonApplicant").css('display','none');
              }
              
              $("#agregarRequerimientoModal").modal("show");
              
              if(classNameG == 'ver_editar'){
                $("#cliente_id").prop("disabled",true);
                $("#editarDatosClientes").prop("disabled",true);
                $("#guardarDatosClientes").prop("disabled",true);
              }
              else{
                $("#cliente_id").prop("disabled",false);
                $("#editarDatosClientes").prop("disabled",false);
                $("#guardarDatosClientes").prop("disabled",false);
              }
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
          pregunta = '¿Quieres inactivar este requerimiento?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este requerimiento?';
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
                url: "/requestactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Requerimiento " + estado,
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

    $(document).on("change", "#cliente_id, #namePosition, #numVacant, #requestDate, #rangeAge, #days, #months, #escolaridad", function () {
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

    $(document).on("change", "#cliente_id", function () {
        let id_cliente = $("#cliente_id").val();
        
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/getinfoclient/" + id_cliente,
            success: function(msg){ 
              //console.log(msg);
              //requestactions
              $("#direccion").val(msg.direccion);
              $("#referencia").val(msg.referencia);
              $("#telefono").val(msg.telefono);
              $("#email").val(msg.email);

              
            }
        }); 
    });

    function replaceContenido(contenido)
    {
        let nuevo_contenido;

        if(contenido == "The cliente field is required.")
          nuevo_contenido = contenido.replace("The cliente field is required.", "El campo cliente es requerido.");
        
        if(contenido == "The vacante field is required.")
          nuevo_contenido = contenido.replace("The vacante field is required.", "El campo vacante es requerido.");
        
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

    let indexCert = 1;
    $(document).on("click", "#addCertificate", function () {

      let certificate = '<div class="row" style="margin-bottom: 5px;margin-right:5px;" id="delete_' + indexCert + '">' +
        '<div class="row">' +
        '<input type="text" class="form-control certificado_class" id="certificado' + indexCert + '" name="certificado[' + indexCert + ']" maxlength="100" placeholder="Certificado o curso" style="width:80%;" >' +
        '<button type="button" class="btn btn-danger btn-sm deleteCert" id="' + indexCert + '" style="width:10%;margin-left:10%;">X</button>' +
        '</div>' +
        '</div>';
      indexCert++;
      $("#areaCertificate").append(certificate);
    });

    $(document).on("click", ".deleteCert", function () {
      let id = $(this).attr('id');
      $("#delete_" + id).remove();
    });
    

    let indexIdiom = 1;
    $(document).on("click", "#addIdiom", function () {

      let idiom = '<div class="row" style="margin-bottom: 5px;margin-right:5px;" id="deleteidiom_' + indexIdiom + '">' +
        '<div class="row">' +
        '<input type="text" class="form-control idiom_class" id="idiom' + indexIdiom + '" name="idiom[' + indexIdiom + ']" maxlength="100" placeholder="Idioma" style="width:80%;">' +
        '<button type="button" class="btn btn-danger btn-sm deleteIdiom" id="' + indexIdiom + '" style="width:10%;margin-left:10%;">X</button>' +
        '</div>' +
        '</div>';
      indexIdiom++;
      $("#areaIdiom").append(idiom);
    });

    $(document).on("click", ".deleteIdiom", function () {
      let id = $(this).attr('id');
      $("#deleteidiom_" + id).remove();
    });

    function activeButtons(flag, button){
      $("#guardarDatosClientes").css('display','none');
      $("#guardarDatosGenerales").css('display','none');
      $("#guardarDatosGenerales").css('display','none');
      $("#guardarDatosPersonales").css('display','none');
      $("#guardarDatosAcademicos").css('display','none');
      $("#guardarDatosPuesto").css('display','none');
      $("#guardarDatosAdicionales").css('display','none');
      $("#guardarDatosEconomicos").css('display','none');
      $("#guardarDatosProceso").css('display','none');
      $("#guardarDatosFinales").css('display','none');

      $("#editarDatosClientes").css('display','none');
      $("#editarDatosGenerales").css('display','none');
      $("#editarDatosPersonales").css('display','none');
      $("#editarDatosAcademicos").css('display','none');
      $("#editarDatosPuesto").css('display','none');
      $("#editarDatosAdicionales").css('display','none');
      $("#editarDatosEconomicos").css('display','none');
      $("#editarDatosProceso").css('display','none');
      $("#editarDatosFinales").css('display','none');

      $("#addApplicant").css('display','none');

      if(flag == 0) $("#guardar" + button).css('display','inline-block');
      if(flag == 1) $("#editar" + button).css('display','inline-block');
    }

    //change of tabs
    $(document).on("click", "#client-tab", function () {

      $("#agregarDatosClientes").trigger("reset");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }
      
        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/clientdataget/" + idRequerimiento,
            success: function(msg){ 
              //console.log(msg);
              
              $("#idRequerimientoEdit").val(msg.id);
              $("#cliente_id").html(msg.client_select);
              $("#cliente_id").trigger("change");
              
            }
        }); 

        $("#clientDiv").addClass('active show');
        $("#client-tab").addClass('active');   
        $("#general-tab").removeClass('active');
        $("#generalDiv").removeClass('active show');
        $("#personal-tab").removeClass('active');
        $("#personalDiv").removeClass('active show');
        $("#academic-tab").removeClass('active');
        $("#academicDiv").removeClass('active show');
        $("#job-tab").removeClass('active');
        $("#assign-tab").removeClass('active');

        $("#jobDiv").removeClass('active show');
        $("#additional-tab").removeClass('active');
        $("#additionalDiv").removeClass('active show');
        $("#economic-tab").removeClass('active');
        $("#economicDiv").removeClass('active show');
        $("#process-tab").removeClass('active');
        $("#processDiv").removeClass('active show');
        $("#dataadd-tab").removeClass('active');
        $("#dataaddDiv").removeClass('active show');
        $("#assignDiv").removeClass('active show');

        $("#guardarDatosClientes").css('display','none');
        $("#guardarDatosGenerales").css('display','none');
        $("#guardarDatosPersonales").css('display','none');
        $("#guardarDatosAcademicos").css('display','none');
        $("#guardarDatosPuesto").css('display','none');
        $("#guardarDatosAdicionales").css('display','none');
        $("#guardarDatosEconomicos").css('display','none');
        $("#guardarDatosProceso").css('display','none');
        $("#guardarDatosFinales").css('display','none');

        $("#editarDatosClientes").css('display','inline-block');
        $("#editarDatosGenerales").css('display','none');
        $("#editarDatosPersonales").css('display','none');
        $("#editarDatosAcademicos").css('display','none');
        $("#editarDatosPuesto").css('display','none');
        $("#editarDatosAdicionales").css('display','none');
        $("#editarDatosEconomicos").css('display','none');
        $("#editarDatosProceso").css('display','none');
        $("#editarDatosFinales").css('display','none');

        $("#addApplicant").css('display','none');
    });


    $(document).on("click", "#general-tab", function () {
      
      $("#agregarDatosGenerales").trigger("reset");
      $("#idGeneralUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#days").css("visibility","visible");
      $("#months").css("visibility","hidden");
      $(".asignmentTime1").prop("checked", true);

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").addClass('active');
      $("#generalDiv").addClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { type: 2, "_token": "{{ csrf_token() }}" },
            url: "/validateinformation/" + idRequerimiento,
            success: function(msg){ 

              if(classNameG == 'ver_editar'){
                $("#namePosition").prop("disabled",true);
                $("#numVacant").prop("disabled",true);
                $("#requestDate").prop("disabled",true);
                $("#requestService").prop("disabled",true);
                $("#modality").prop("disabled",true);
                $("#asignmentTime").prop("disabled",true);
                $(".asignmentTime2").prop("disabled",true);
                $(".asignmentTime3").prop("disabled",true);
                $("#days").prop("disabled",true);
                $("#months").prop("disabled",true);
                $("#timeBegin").prop("disabled",true);
                $("#timeEnd").prop("disabled",true);
                $("#editarDatosGenerales").prop("disabled",true);
                $("#guardarDatosGenerales").prop("disabled",true);
              }
              else{
                $("#namePosition").prop("disabled",false);
                $("#numVacant").prop("disabled",false);
                $("#requestDate").prop("disabled",false);
                $("#requestService").prop("disabled",false);
                $("#modality").prop("disabled",false);
                $("#asignmentTime").prop("disabled",false);
                $(".asignmentTime2").prop("disabled",false);
                $(".asignmentTime3").prop("disabled",false);
                $("#days").prop("disabled",false);
                $("#months").prop("disabled",false);
                $("#timeBegin").prop("disabled",false);
                $("#timeEnd").prop("disabled",false);
                $("#editarDatosGenerales").prop("disabled",false);
                $("#guardarDatosGenerales").prop("disabled",false);
              }

              if(msg == 1){

                  $.ajax({
                        type: "GET",
                        dataType: 'JSON',
                        data: { "_token": "{{ csrf_token() }}" },
                        url: "/generaldataget/" + idRequerimiento,
                        success: function(msg){ 
                          //console.log(msg);
                          
                          $("#idGeneralUnico").val(msg.id);
                          $("#namePosition").val(msg.puesto);
                          $("#numVacant").val(msg.novacantes);
                          $("#requestDate").val(msg.fechasolicitud);
                          $("#requestService").html(msg.require_service_select);
                          $("#modality").html(msg.modalidad_select);
                          $(".asignmentTime" + msg.tiemasignacion).prop("checked", true);

                          if(msg.tiemasignacion == 1){
                            $("#days").css("visibility","visible");
                            $("#months").css("visibility","hidden");
                            $("#days").val(msg.cantidadtiempo);
                            $("#months").val("");
                          }
                          if(msg.tiemasignacion == 2){
                            $("#days").val("");
                            $("#months").val(msg.cantidadtiempo);
                            $("#months").css("visibility","visible");
                            $("#days").css("visibility","hidden");
                          }
                          if(msg.tiemasignacion == 3){
                            $("#days").val("");
                            $("#months").val("");
                            $("#days").css("visibility","hidden");
                            $("#months").css("visibility","hidden");
                          }
                          
                          $("#timeBegin").val(msg.horario_inicio);
                          $("#timeEnd").val(msg.horario_fin);
                          $("#executiveInCharge").val(msg.ejecutivoen);

                          activeButtons(1, 'DatosGenerales');
                        }
                    });
                    
              }
              else{
                  activeButtons(0, 'DatosGenerales');
              }

              
            }
        });

        
    });

    $(document).on("click", "#personal-tab", function () {

      $("#agregarDatosPersonales").trigger("reset");
      $("#idPersonalUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").addClass('active');
      $("#personalDiv").addClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type: 3, "_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){

            if(classNameG == 'ver_editar'){
                $("#rangeAge").prop("disabled",true);
                $("#sex").prop("disabled",true);
                $("#civilstate").prop("disabled",true);
                $("#residencePlace").prop("disabled",true);
                $("#editarDatosPersonales").prop("disabled",true);
                $("#guardarDatosPersonales").prop("disabled",true);
              }
              else{
                $("#rangeAge").prop("disabled",false);
                $("#sex").prop("disabled",false);
                $("#civilstate").prop("disabled",false);
                $("#residencePlace").prop("disabled",false);
                $("#editarDatosPersonales").prop("disabled",false);
                $("#guardarDatosPersonales").prop("disabled",false);
              }

            if(msg == 1){

                $.ajax({
                    type: "GET",
                    dataType: 'JSON',
                    data: { "_token": "{{ csrf_token() }}" },
                    url: "/personaldataget/" + idRequerimiento,
                    success: function(msg){ 
                      //console.log(msg);
                      $("#idPersonalUnico").val(msg.id);
                      $("#rangeAge").val(msg.rangoedad);
                      $("#sex").html(msg.sexo_select);
                      $("#civilstate").html(msg.estados_civiles_select);
                      $("#residencePlace").val(msg.lugarresidencia);

                      activeButtons(1, 'DatosPersonales');
                      
                    }
                  }); 


            }
            else{

                activeButtons(0, 'DatosPersonales');
            }

            
          }
      }); 
        
    });

    $(document).on("click", "#academic-tab", function () {

      $("#agregarDatosAcademicos").trigger("reset");
      $("#idAcademicoUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      indexCert = 0;
      let certificate = '<div class="row" style="margin-bottom: 5px;margin-right:5px;">' +
      '<input type="text" class="form-control certificado_class" id="certificado' + indexCert + '" name="certificado[' + indexCert + ']" maxlength="100" placeholder="Certificado o curso">' +
      '</div>';
      indexCert++;
      $("#areaCertificate").html("");
      $("#areaCertificate").append(certificate);

      indexIdiom = 0;
      let idiom = '<div class="row" style="margin-bottom: 5px;margin-right:5px;">' +
        '<input type="text" class="form-control idiom_class" id="idiom' + indexIdiom + '" name="idiom[' + indexIdiom + ']" maxlength="100" placeholder="Idioma">' +
        '</div>';
      indexIdiom++;
      $("#areaIdiom").html("");
      $("#areaIdiom").append(idiom);

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").addClass('active');
      $("#academicDiv").addClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type: 4, "_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){ 
            //console.log(msg);

            if(classNameG == 'ver_editar'){
              $("#escolaridad").prop("disabled",true);
              $("#addCertificate").prop("disabled",true);
              $("#addIdiom").prop("disabled",true);
              $(".deleteCert").prop("disabled",true);
              $(".certificado_class").prop("disabled",true);
              $(".idiom_class").prop("disabled",true);
              $("#editarDatosAcademicos").prop("disabled",true);
              $("#guardarDatosAcademicos").prop("disabled",true);
            }
            else{
              $("#escolaridad").prop("disabled",false);
              $("#addCertificate").prop("disabled",false);
              $("#addIdiom").prop("disabled",false);
              $(".deleteCert").prop("disabled",false);
              $(".certificado_class").prop("disabled",false);
              $(".idiom_class").prop("disabled",false);
              $("#editarDatosAcademicos").prop("disabled",false);
              $("#guardarDatosAcademicos").prop("disabled",false);
            }
            
            if(msg == 1){

              $.ajax({
                  type: "GET",
                  dataType: 'JSON',
                  data: { "_token": "{{ csrf_token() }}" },
                  url: "/academicdataget/" + idRequerimiento,
                  success: function(msg){ 
                    //console.log(msg);
                    
                    $("#idAcademicoUnico").val(msg.id);
                    $("#escolaridad").val(msg.escolaridad);
                    $("#areaCertificate").html(msg.certificado_select);
                    $("#areaIdiom").html(msg.idiom_select);

                    indexCert = msg.certificado_num;
                    indexIdiom = msg.idiom_num;
                    activeButtons(1, 'DatosAcademicos');
                    
                  }
              }); 

            }
            else{
              activeButtons(0, 'DatosAcademicos');
            }
            
          }
      }); 
        

        

        
    });

    $(document).on("click", "#job-tab", function () {

      $("#agregarDatosPuesto").trigger("reset");
      $("#idPuestoUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").addClass('active');
      $("#jobDiv").addClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { type: 5, "_token": "{{ csrf_token() }}" },
            url: "/validateinformation/" + idRequerimiento,
            success: function(msg){ 
              //console.log(msg);

            if(classNameG == 'ver_editar'){
              $("#experience").prop("disabled",true);
              $("#activities").prop("disabled",true);
              $("#technical_knowledge").prop("disabled",true);
              $("#necessary_skills").prop("disabled",true);
              $("#editarDatosPuesto").prop("disabled",true);
              $("#guardarDatosPuesto").prop("disabled",true);
            }
            else{
              $("#experience").prop("disabled",false);
              $("#activities").prop("disabled",false);
              $("#technical_knowledge").prop("disabled",false);
              $("#necessary_skills").prop("disabled",false);
              $("#editarDatosPuesto").prop("disabled",false);
              $("#guardarDatosPuesto").prop("disabled",false);
            }
              
              if(msg == 1){

                $.ajax({
                    type: "GET",
                    dataType: 'JSON',
                    data: { "_token": "{{ csrf_token() }}" },
                    url: "/jobdataget/" + idRequerimiento,
                    success: function(msg){ 
                      //console.log(msg);
                      
                      $("#idPuestoUnico").val(msg.id);
                      $("#experience").val(msg.experiencia);
                      $("#activities").val(msg.actividades);
                      $("#technical_knowledge").val(msg.conocimientos_tecnicos);
                      $("#necessary_skills").val(msg.competencias_necesarias);
                  
                      activeButtons(1, 'DatosPuesto');
                    }
                }); 

              }
              else{
                  activeButtons(0, 'DatosPuesto');
              }
          
              
            }
        }); 
      
    });

    $(document).on("click", "#additional-tab", function () {

      $("#agregarDatosAdicional").trigger("reset");
      $("#idAdicionalUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").addClass('active');
      $("#additionalDiv").addClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');
      
      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type:6, "_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){ 
            //console.log(msg);

            if(classNameG == 'ver_editar'){
              $(".desplazarse1").prop("disabled",true);
              $(".desplazarse2").prop("disabled",true);
              $(".desplazarse3").prop("disabled",true);
              $("#desplazarse_motivo").prop("disabled",true);
              $(".viajar1").prop("disabled",true);
              $(".viajar2").prop("disabled",true);
              $(".viajar3").prop("disabled",true);
              $("#viajar_motivo").prop("disabled",true);
              $(".disponibilidad_horario1").prop("disabled",true);
              $(".disponibilidad_horario2").prop("disabled",true);
              $(".disponibilidad_horario3").prop("disabled",true);
              $("#disponibilidad_horario_motivo").prop("disabled",true);
              $(".personal_cargo1").prop("disabled",true);
              $(".personal_cargo2").prop("disabled",true);
              $("#num_personas_cargo").prop("disabled",true);
              $(".equipo_computo1").prop("disabled",true);
              $(".equipo_computo2").prop("disabled",true);
              $("#persona_reporta").prop("disabled",true);
              $("#editarDatosAdicionales").prop("disabled",true);
              $("#guardarDatosAdicionales").prop("disabled",true);
            }
            else{
              $(".desplazarse1").prop("disabled",false);
              $(".desplazarse2").prop("disabled",false);
              $(".desplazarse3").prop("disabled",false);
              $("#desplazarse_motivo").prop("disabled",false);
              $(".viajar1").prop("disabled",false);
              $(".viajar2").prop("disabled",false);
              $(".viajar3").prop("disabled",false);
              $("#viajar_motivo").prop("disabled",false);
              $(".disponibilidad_horario1").prop("disabled",false);
              $(".disponibilidad_horario2").prop("disabled",false);
              $(".disponibilidad_horario3").prop("disabled",false);
              $("#disponibilidad_horario_motivo").prop("disabled",false);
              $(".personal_cargo1").prop("disabled",false);
              $(".personal_cargo2").prop("disabled",false);
              $("#num_personas_cargo").prop("disabled",false);
              $(".equipo_computo1").prop("disabled",false);
              $(".equipo_computo2").prop("disabled",false);
              $("#persona_reporta").prop("disabled",false);
              $("#editarDatosAdicionales").prop("disabled",false);
              $("#guardarDatosAdicionales").prop("disabled",false);
            }
            
            if(msg == 1){

              $.ajax({
                  type: "GET",
                  dataType: 'JSON',
                  data: { "_token": "{{ csrf_token() }}" },
                  url: "/additionaldataget/" + idRequerimiento,
                  success: function(msg){ 
                    //console.log(msg);
                    
                    $("#idAdicionalUnico").val(msg.id);
                    $(".desplazarse" + msg.desplazarse).prop("checked", true);
                    $(".viajar" + msg.viajar).prop("checked", true);
                    $(".disponibilidad_horario" + msg.disponibilidad_horario).prop("checked", true);
                    $(".personal_cargo" + msg.personal_cargo).prop("checked", true);
                    $(".equipo_computo" + msg.equipo_computo).prop("checked", true);
                    
                    $("#persona_reporta").val(msg.persona_reporta);
                    $("#desplazarse_motivo").val(msg.desplazarse_motivo);
                    $("#viajar_motivo").val(msg.viajar_motivo);
                    $("#disponibilidad_horario_motivo").val(msg.disponibilidad_horario_motivo);
                    $("#num_personas_cargo").val(msg.num_personas_cargo);

                    activeButtons(1, 'DatosAdicionales');
                  }
              }); 

            }
            else{
                activeButtons(0, 'DatosAdicionales');
            }
            
          }
      }); 

    });

    $(document).on("click", "#economic-tab", function () {

      $("#agregarDatosEconomicos").trigger("reset");
      $("#idEconomicoUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").addClass('active');
      $("#economicDiv").addClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type: 7,"_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){ 
            //console.log(msg);
            
            if(classNameG == 'ver_editar'){
              $("#esquemacontratacion").prop("disabled",true);
              $("#tiposalario").prop("disabled",true);
              $("#montominimo").prop("disabled",true);
              $("#montomaximo").prop("disabled",true);
              $("#jornadalaboral").prop("disabled",true);
              $("#prestaciones_beneficios").prop("disabled",true);
              $("#editarDatosEconomicos").prop("disabled",true);
              $("#guardarDatosEconomicos").prop("disabled",true);
            }
            else{
              $("#esquemacontratacion").prop("disabled",false);
              $("#tiposalario").prop("disabled",false);
              $("#montominimo").prop("disabled",false);
              $("#montomaximo").prop("disabled",false);
              $("#jornadalaboral").prop("disabled",false);
              $("#prestaciones_beneficios").prop("disabled",false);
              $("#editarDatosEconomicos").prop("disabled",false);
              $("#guardarDatosEconomicos").prop("disabled",false);
            }

            if(msg == 1){

              $.ajax({
                  type: "GET",
                  dataType: 'JSON',
                  data: { "_token": "{{ csrf_token() }}" },
                  url: "/economicdataget/" + idRequerimiento,
                  success: function(msg){ 
                    //console.log(msg);
                    
                    $("#idEconomicoUnico").val(msg.id);
                    $("#esquemacontratacion").val(msg.esquemacontratacion);
                    $("#tiposalario").val(msg.tiposalario);
                    $("#montominimo").val(msg.montominimo);
                    $("#montomaximo").val(msg.montomaximo);
                    $("#jornadalaboral").val(msg.jornadalaboral);
                    $("#prestaciones_beneficios").val(msg.prestaciones_beneficios);
                
                    activeButtons(1, 'DatosEconomicos');    
                  }
              }); 

            }else{
              activeButtons(0, 'DatosEconomicos');
            }
        
            
          }
      }); 
      
        

        
    });

    $(document).on("click", "#process-tab", function () {

      $("#agregarDatosProceso").trigger("reset");
      $("#idProcesoUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").addClass('active');
      $("#processDiv").addClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');

      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type:8,"_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){ 
            //console.log(msg);
            
            if(classNameG == 'ver_editar'){
              $("#duracion").prop("disabled",true);
              $("#cantidadfiltros").prop("disabled",true);
              $("#niveles_flitro").prop("disabled",true);
              $("#entrevista").prop("disabled",true);
              $("#pruebat").prop("disabled",true);
              $("#pruebap").prop("disabled",true);
              $("#referencias").prop("disabled",true);
              $("#entrevista_tecnica").prop("disabled",true);
              $("#estudio_socioeconomico").prop("disabled",true);
              $("#editarDatosProceso").prop("disabled",true);
              $("#guardarDatosProceso").prop("disabled",true);
            }
            else{
              $("#duracion").prop("disabled",false);
              $("#cantidadfiltros").prop("disabled",false);
              $("#niveles_flitro").prop("disabled",false);
              $("#entrevista").prop("disabled",false);
              $("#pruebat").prop("disabled",false);
              $("#pruebap").prop("disabled",false);
              $("#referencias").prop("disabled",false);
              $("#entrevista_tecnica").prop("disabled",false);
              $("#estudio_socioeconomico").prop("disabled",false);
              $("#editarDatosProceso").prop("disabled",false);
              $("#guardarDatosProceso").prop("disabled",false);
            }

              if(msg == 1){

                $.ajax({
                    type: "GET",
                    dataType: 'JSON',
                    data: { "_token": "{{ csrf_token() }}" },
                    url: "/processdataget/" + idRequerimiento,
                    success: function(msg){ 
                      //console.log(msg);
                      
                      $("#idProcesoUnico").val(msg.id);
                      $("#duracion").val(msg.duracion);
                      $("#cantidadfiltros").val(msg.cantidadfiltros);
                      $("#niveles_flitro").val(msg.niveles_flitro);
                      
                      if(msg.entrevista == 1){
                        $("#entrevista").prop("checked", true);
                      }
                      else{
                        $("#entrevista").prop("checked", false);
                      }

                      if(msg.pruebatecnica == 1){
                        $("#pruebat").prop("checked", true);
                      }
                      else{
                        $("#pruebat").prop("checked", false);
                      }

                      if(msg.pruebapsicometrica == 1){
                        $("#pruebap").prop("checked", true);
                      }
                      else{
                        $("#pruebap").prop("checked", false);
                      }

                      if(msg.referencias == 1){
                        $("#referencias").prop("checked", true);
                      }
                      else{
                        $("#referencias").prop("checked", false);
                      }

                      if(msg.entrevista_tecnica == 1){
                        $("#entrevista_tecnica").prop("checked", true);
                      }
                      else{
                        $("#entrevista_tecnica").prop("checked", false);
                      }

                      if(msg.estudio_socioeconomico == 1){
                        $("#estudio_socioeconomico").prop("checked", true);
                      }
                      else{
                        $("#estudio_socioeconomico").prop("checked", false);
                      }

                      activeButtons(1, 'DatosProceso');
                      
                    }
                }); 

              }
              else{
                activeButtons(0, 'DatosProceso');
              }
            
          }
      }); 
      
    });

    $(document).on("click", "#dataadd-tab", function () {

      $("#agregarDatosFinal").trigger("reset");
      $("#idFinalUnico").val("");
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").addClass('active');
      $("#dataaddDiv").addClass('active show');

      $("#assign-tab").removeClass('active');
	    $("#assignDiv").removeClass('active show');
      
      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { type: 9 ,"_token": "{{ csrf_token() }}" },
          url: "/validateinformation/" + idRequerimiento,
          success: function(msg){ 
            //console.log(msg);
            if(classNameG == 'ver_editar'){
              $("#razonnocontratacion").prop("disabled",true);
              $("#fechacontratacion").prop("disabled",true);
              $("#editarDatosFinales").prop("disabled",true);
              $("#guardarDatosFinales").prop("disabled",true);
            }
            else{
              $("#razonnocontratacion").prop("disabled",false);
              $("#fechacontratacion").prop("disabled",false);
              $("#editarDatosFinales").prop("disabled",false);
              $("#guardarDatosFinales").prop("disabled",false);
            }
            
            if(msg == 1){

              $.ajax({
                  type: "GET",
                  dataType: 'JSON',
                  data: { "_token": "{{ csrf_token() }}" },
                  url: "/finaldataget/" + idRequerimiento,
                  success: function(msg){ 
                    //console.log(msg);
                    
                    $("#idFinalUnico").val(msg.id);
                    $("#razonnocontratacion").val(msg.razonnocontratacion);
                    $("#fechacontratacion").val(msg.fechacontratacion);

                    activeButtons(1, 'DatosFinales');
                  }
              }); 
            }
            else{
              activeButtons(0, 'DatosFinales');
            }
            
          }
      }); 
        
    });

    let initTable = 0;
    let table_assign, table_delete;
    $(document).on("click", "#assign-tab", function () {

      /*$("#agregarDatosFinal").trigger("reset");
      $("#idFinalUnico").val("");*/
      let idRequerimiento = $("#idRequerimientoUnico").val().trim();

      if(idRequerimiento == ''){
        idRequerimiento = $("#idRequerimientoEdit").val().trim();
      }

      $("#clientDiv").removeClass('active show');
      $("#client-tab").removeClass('active');   
      $("#general-tab").removeClass('active');
      $("#generalDiv").removeClass('active show');
      $("#personal-tab").removeClass('active');
      $("#personalDiv").removeClass('active show');
      $("#academic-tab").removeClass('active');
      $("#academicDiv").removeClass('active show');
      $("#job-tab").removeClass('active');
      $("#jobDiv").removeClass('active show');
      $("#additional-tab").removeClass('active');
      $("#additionalDiv").removeClass('active show');
      $("#economic-tab").removeClass('active');
      $("#economicDiv").removeClass('active show');
      $("#process-tab").removeClass('active');
      $("#processDiv").removeClass('active show');
      $("#dataadd-tab").removeClass('active');
      $("#dataaddDiv").removeClass('active show');
      $("#assign-tab").removeClass('active');
      $("#assignDiv").removeClass('active show');

      $("#assign-tab").addClass('active');
	    $("#assignDiv").addClass('active show');

      $("#guardarDatosClientes").css('display','none');
      $("#guardarDatosGenerales").css('display','none');
      $("#guardarDatosGenerales").css('display','none');
      $("#guardarDatosPersonales").css('display','none');
      $("#guardarDatosAcademicos").css('display','none');
      $("#guardarDatosPuesto").css('display','none');
      $("#guardarDatosAdicionales").css('display','none');
      $("#guardarDatosEconomicos").css('display','none');
      $("#guardarDatosProceso").css('display','none');
      $("#guardarDatosFinales").css('display','none');

      $("#editarDatosClientes").css('display','none');
      $("#editarDatosGenerales").css('display','none');
      $("#editarDatosPersonales").css('display','none');
      $("#editarDatosAcademicos").css('display','none');
      $("#editarDatosPuesto").css('display','none');
      $("#editarDatosAdicionales").css('display','none');
      $("#editarDatosEconomicos").css('display','none');
      $("#editarDatosProceso").css('display','none');
      $("#editarDatosFinales").css('display','none');
      
      $("#addApplicant").css('display','inline-block');

          if(initTable == 1){
            $("#table-assign").dataTable().fnDestroy();
            $("#table-delete").dataTable().fnDestroy();
          }
          initTable = 1;

          table_assign = $('#table-assign').DataTable({
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
            "search": "Buscar candidato:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
          },
          ajax: '{{ url('addapplicant.index') }}',
          columns: [
                   { data: 'check', name: 'check' },
                   { data: 'name', name: 'name' },
                ],
          "order": []
         /* "columnDefs": [
              //{ "visible": false, "targets": 0 },
              { "orderable": false, "targets": 5 },
          ]*/
       });

       table_delete = $('#table-delete').DataTable({
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
            "search": "Buscar candidato:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
          },
          ajax: {
                url: '{{ url('deleteapplicant.index') }}',
                data: { requerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" },
                        type: 'GET'
          },
          columns: [
                   { data: 'name', name: 'name' },
                   { data: 'state', name: 'state' },
                   { data: 'delete', name: 'delete' },
                ],
          "order": []
         /* "columnDefs": [
              //{ "visible": false, "targets": 0 },
              { "orderable": false, "targets": 5 },
          ]*/
       });
        
      });

    $(document).on("click", ".exportPDF", function(){
        
        let id = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: '{{ url('vacant.getpdf') }}',
            data: { id: id, "_token": "{{ csrf_token() }}"},
            xhrFields: {
                responseType: 'blob'
            },
                success: function(response){ 
                    //console.log(response);
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "reporte_solidez.pdf";
                    link.click();
              
                },
                error: function (err) {
                /*Swal.fire({
                            icon: 'warning',
                            html:
                            '<b>¡Error inesperado!</b><br> ' +
                            'Ha ocurrido un error inesperado, favor de contactar a Soporte Técnico',
                            showCloseButton: true,
                            showCancelButton: false,
                            focusConfirm: false,
                            showConfirmButton: false
                        });*/
                }
            }); 


        
    });

    let idRequerimientoAceptar;
    $(document).on("click", ".aceptarRequerimiento", function(){
        let id = $(this).attr('id');
        let array = id.split("_");
        let idRequerimiento = array[1];
        idRequerimientoAceptar = idRequerimiento;

        Swal.fire({
        title: "¿Estás seguro de aceptar el requerimiento?",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        reverseButtons : false,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

           /* $.ajax({
                type: "GET",
                dataType: 'JSON',
                data: { idRequerimiento: idRequerimiento, status: 3, "_token": "{{ csrf_token() }}" },
                url: "/statusrequirement/",
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Requerimiento aceptado",
                    });
                    $("#buttonRecruitment").css('display','block');
                    $("#buttonApplicant").css('display','block');
*/
                    $.ajax({
                        type: "GET",
                        dataType: 'JSON',
                        data: { idRequerimiento: idRequerimiento, "_token": "{{ csrf_token() }}" },
                        url: "/getrecruitment/",
                        success: function(msg){ 

                          $("#reclutador_id").html(msg);
                          $("#agregarReclutadorModal").modal("show");
                        }
                    });
                   /* 
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
            });*/

        } else if (result.isDenied) {
            
        }
        })
        
  });

  $(document).on("click", ".rechazarRequerimiento", function(){
        let id = $(this).attr('id');
        let array = id.split("_");
        let idRequerimiento = array[1];

        Swal.fire({
        title: "¿Estás seguro de rechazar el requerimiento?",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        reverseButtons : false,
        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {

            $.ajax({
                type: "GET",
                dataType: 'JSON',
                data: { idRequerimiento: idRequerimiento, status: 2, "_token": "{{ csrf_token() }}" },
                url: "/statusrequirement/",
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Requerimiento rechazado",
                    });
                    $("#buttonRecruitment").css('display','none');
                    $("#buttonApplicant").css('display','none');
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

  $(document).on("click", "#seleccionarReclutador", function(){

    let idRequerimiento = $("#idRequerimientoEdit").val().trim();

    $.ajax({
        type: "GET",
        dataType: 'JSON',
        data: { idRequerimiento: idRequerimiento, "_token": "{{ csrf_token() }}" },
        url: "/getrecruitment/",
        success: function(msg){ 

          $("#reclutador_id").html(msg);
          $("#agregarReclutadorModal").modal("show");
        }
    });
    
  });

    $(document).on("click", "#guardarReclutador", function(){

        let reclutador_id = $("#reclutador_id").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        if(idRequerimiento == ''){
          idRequerimiento = idRequerimientoAceptar;
        }

        $("#guardarReclutador").attr("disabled",true);
        $("#cancelarReclutador").attr("disabled",true);
        $("#loadingSReclutador").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        reclutador_id: reclutador_id,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/saverecruitment",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Reclutador seleccionado.",
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
                  $("#loadingSReclutador").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#loadingSReclutador").css("visibility","hidden");
                }
            }); 
    });

    $(document).on("click", "#asignarCandidato", function(){

        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            data: { idRequerimiento: idRequerimiento, "_token": "{{ csrf_token() }}" },
            url: "/getapplicant/",
            success: function(msg){ 

              $("#candidato_sel_id").html(msg);
              $("#agregarCandidatoModal").modal("show");
            }
        });

    });
    
    $(document).on("click", "#guardarCandidato", function(){

        let candidato_id = $("#candidato_sel_id").val().trim();
        let idRequerimiento = $("#idRequerimientoEdit").val().trim();

        $("#guardarCandidato").attr("disabled",true);
        $("#cancelarCandidato").attr("disabled",true);
        $("#loadingSReclutador").css("visibility","visible");

            $.ajax({
                type: "POST",
                data: { 
                        candidato_id: candidato_id,
                        idRequerimiento: idRequerimiento,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/saveapplicant",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Candidato seleccionado.",
                      });

                      $("#agregarCandidato").trigger("reset");
                      $("#agregarCandidatoModal").modal('hide');
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

                  $("#guardarCandidato").attr("disabled",false);
                  $("#cancelarCandidato").attr("disabled",false);
                  $("#loadingSCandidato").css("visibility","hidden");
                },
                error: function (err) {
                  //console.log(err);
                    let mensaje = '';
                    let contenido;
                    $.each(err.responseJSON.errors, function (key, value) {
                        //console.log("min " +value);
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
                    $("#guardarCandidato").attr("disabled",false);
                    $("#cancelarCandidato").attr("disabled",false);
                    $("#loadingSCandidato").css("visibility","hidden");
                }
            }); 
    });

    let applicants = [];
    $(document).on("click", "#addApplicant", function(){
      /*let applicants = [];
      $.each( agregar, function( k, v ){
        applicants.push(v.id);
      });*/
      if(applicants.length < 1){
          Lobibox.notify("warning", {
            size: "mini",
            rounded: true,
            delay: 3000,
            delayIndicator: false,
            position: "center top",
            msg: "Selecciona al menos un candidato.",
          });
          
          return;
      }
      let idRequerimiento = $("#idRequerimientoEdit").val().trim();
      $("#addApplicant").attr("disabled",true);
      $("#loadingSAssign").css("visibility","visible");

      $.ajax({
                type: "POST",
                data: { 
                        idRequerimiento: idRequerimiento,
                        applicants: applicants,
                        "_token": "{{ csrf_token() }}" 
                      } ,
                dataType: 'JSON',
                url: "/addApplicantNew",
                success: function(msg){ 
                //console.log(msg);

                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Se agregaron los candidatos seleccionados",
                      });        
                      applicants = [];
                      table_assign.ajax.reload();   
                      table_delete.ajax.reload();
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

                  $("#addApplicant").attr("disabled",false);
                  $("#loadingSAssign").css("visibility","hidden");
                },
                error: function (err) {
                  $("#addApplicant").attr("disabled",false);
                  $("#loadingSAssign").css("visibility","hidden");
                }
            }); 

      //console.log(applicants);
      
    });

    $(document).on("click", ".selected-applicants", function(){
      let id = $(this).attr('id');

      let isFound = jQuery.inArray( id , applicants );
      
      if(isFound >= 0){
        applicants.splice(isFound);
      }
      else{
        applicants.push(id);
      }

      //console.log(applicants);
    });

    $(document).on("click", ".deleteApplicant", function(){
      let id = this.id;
      Swal.fire({
        title: "¿Deseas eliminar a este candidato de este proceso?",
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
                url: "/deleteApplicantDo/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Candidato eliminado del proceso.",
                    });
                    table_assign.ajax.reload();
                    table_delete.ajax.reload();
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
        });
    });
  </script>
@endpush
