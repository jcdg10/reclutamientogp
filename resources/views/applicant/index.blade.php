@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Candidatos</li>
  </ol>
</nav>

<div class="row">

  <h2>Candidatos</h2>
  <div class="row">
    <div class="col-lg-12">
      <?php if($roles[1]->permitido == 1){ ?>
        <button class="btn btn-primary float-end" id="generarCandidatoNuevo" data-bs-toggle="modal" data-bs-target="#agregarCandidatoModal">Agregar candidato</button>
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
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Edad</th>
                    <th>Perfil</th>
                    <th>Pretensiones</th>
                    <th>Estatus candidato</th>
                    <th>Requerimiento</th>
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
<div class="modal fade" id="agregarCandidatoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarCandidato" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Candidato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            
          <div class="col-md-6">
              <div class="mb-3">
                <label for="names" class="form-label">Nombres</label>
                <input type="text" class="form-control alpha-only" id="names" name="names" maxlength="45" required placeholder="Nombres">
                <div class="invalid-feedback" id="invalid-names-required">Los nombres son requeridos</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="lastnames" class="form-label">Apellidos</label>
                <input type="text" class="form-control alpha-only" id="lastnames" name="lastnames" maxlength="45" required placeholder="Apellidos">
                <div class="invalid-feedback" id="invalid-lastnames-required">Los apellidos son requeridos</div>
              </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="age" class="form-label">Edad</label>
              <input type="number" class="form-control" id="age" name="age" placeholder="Edad">
              <div class="invalid-feedback" id="invalid-age-required">La edad es requerida</div>
            </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control numeric-only" id="phone" name="phone" maxlength="10" required placeholder="Teléfono">
            <div class="invalid-feedback" id="invalid-phone-required">El teléfono es requerido</div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="text" class="form-control email-only" id="email" name="email" maxlength="80" required placeholder="Correo">
            <div class="invalid-feedback" id="invalid-email-required">El correo es requerido</div>
            <div class="invalid-feedback" id="invalid-email-valid-required">Ingresa un correo válido</div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="mb-3">
            <label for="city" class="form-label">Ciudad</label>
            <select class="form-select" id="city" name="city">
              <option value="">Selecciona una ciudad</option>
              @foreach ($ciudades as $c)
                @if ($c->estatus == 1)
                  <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endif
              @endforeach
            </select>
            <div class="invalid-feedback" id="invalid-city-required">La ciudad es requerida</div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="mb-3">
            <label for="pretensions" class="form-label">Pretensiones</label>
            <input type="text" class="form-control decimalesClass" id="pretensions" name="pretensions" maxlength="12" required placeholder="Pretensiones">
            <div class="invalid-feedback" id="invalid-pretensions-required">Las pretensiones son requeridas</div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="mb-3">
            <label for="profile" class="form-label">Perfil</label>
            <input type="text" class="form-control alpha-only" id="profile" name="profile" placeholder="Perfil">
            <div class="invalid-feedback" id="invalid-profile-required">El perfil es requerido</div>
          </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="specialty" class="form-label">Especialidad</label>
          <select class="form-control" id="specialty" name="specialty">
            <option value="">Selecciona una especialidad</option>
            @foreach ($especialidades as $e)
              @if ($e->estatus == 1)
                <option value="{{ $e->id }}">{{ $e->especialidad }}</option>
              @endif
            @endforeach
          </select>
          <div class="invalid-feedback" id="invalid-specialty-required">La especialidad es requerida</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="city" class="form-label">Estatus</label>
          <select class="form-select" id="estatus_candidatos" name="estatus_candidatos">
            <option value="">Selecciona un estatus</option>
            @foreach ($estatus_candidatos as $e)
                <option value="{{ $e->id }}">{{ $e->estatus }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback" id="invalid-estatus_candidatos-required">El estatus es requerido</div>
        </div>
      </div>
      <div class="col-md-6">
          <label for="name">Foto:</label>
          <input type="file" id="profile_photo" name="profile_photo" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg, image/jiff, image/svg+xml"/>
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
        <button type="button"class="btn btn-secondary" id="cancelarCandidato" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarCandidato">Guardar</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Editar Modal -->
<div class="modal fade" id="modificarCandidatoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="modificarCandidatoForm" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Candidato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <ul class="nav nav-tabs mb-12" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#infoDiv" type="button" role="tab" aria-controls="infoDiv" aria-selected="false">Información</button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="academico-tab" data-bs-toggle="tab" data-bs-target="#academicoDiv" type="button" role="tab" aria-controls="academicoDiv" aria-selected="true">Académico</button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link" id="experiencia-tab" data-bs-toggle="tab" data-bs-target="#experienciaDiv" type="button" role="tab" aria-controls="experienciaDiv" aria-selected="true">Experiencia</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="proceso-tab" data-bs-toggle="tab" data-bs-target="#procesoDiv" type="button" role="tab" aria-controls="procesoDiv" aria-selected="true">Proceso</button>
            </li>
          </ul>
          
          <div class="tab-content" id="myTabContent">
            <!-- BEGINNING TAB INFORMACION -->
            <div class="tab-pane fade" id="infoDiv" role="tabpanel" aria-labelledby="home-tab">
                <p class="hp-p1-body mb-0">

                  <br>
                  <div class="row">
                    
                          <div class="col-md-6">
                              <div class="mb-3">
                                <label for="names" class="form-label">Nombres</label>
                                <input type="text" class="form-control alpha-only" id="namesEdit" name="namesEdit" maxlength="45" required placeholder="Nombres">
                                <div class="invalid-feedback" id="invalid-namesEdit-required">Los nombres son requeridos</div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="mb-3">
                                <label for="lastnames" class="form-label">Apellidos</label>
                                <input type="text" class="form-control alpha-only" id="lastnamesEdit" name="lastnamesEdit" maxlength="45" required placeholder="Apellidos">
                                <div class="invalid-feedback" id="invalid-lastnamesEdit-required">Los apellidos son requeridos</div>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label for="age" class="form-label">Edad</label>
                              <input type="number" class="form-control" id="ageEdit" name="ageEdit" placeholder="Edad">
                              <div class="invalid-feedback" id="invalid-ageEdit-required">La edad es requerida</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control numeric-only" id="phoneEdit" name="phoneEdit" maxlength="10" required placeholder="Teléfono">
                            <div class="invalid-feedback" id="invalid-phoneEdit-required">El teléfono es requerido</div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="text" class="form-control email-only" id="emailEdit" name="emailEdit" maxlength="80" required placeholder="Correo">
                            <div class="invalid-feedback" id="invalid-emailEdit-required">El correo es requerido</div>
                            <div class="invalid-feedback" id="invalid-emailEdit-valid-required">Ingresa un correo válido</div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="city" class="form-label">Ciudad</label>
                            <select class="form-select" id="cityEdit" name="cityEdit">
                            </select>
                            <div class="invalid-feedback" id="invalid-cityEdit-required">La ciudad es requerida</div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="pretensions" class="form-label">Pretensiones</label>
                            <input type="text" class="form-control decimalesClass" id="pretensionsEdit" name="pretensionsEdit" maxlength="12" required placeholder="Pretensiones">
                            <div class="invalid-feedback" id="invalid-pretensionsEdit-required">Las pretensiones son requeridas</div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="profile" class="form-label">Perfil</label>
                            <input type="text" class="form-control alpha-only" id="profileEdit" name="profileEdit" placeholder="Perfil">
                            <div class="invalid-feedback" id="invalid-profileEdit-required">El perfil es requerido</div>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="specialty" class="form-label">Especialidad</label>
                          <select class="form-control" id="specialtyEdit" name="specialtyEdit">
                          </select>
                          <div class="invalid-feedback" id="invalid-specialtyEdit-required">La especialidad es requerida</div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="city" class="form-label">Estatus</label>
                          <select class="form-select" id="estatus_candidatosEdit" name="estatus_candidatosEdit">
                            <option value="">Selecciona un estatus</option>
                            @foreach ($estatus_candidatos as $e)
                                <option value="{{ $e->id }}">{{ $e->estatus }}</option>
                            @endforeach
                          </select>
                          <div class="invalid-feedback" id="invalid-estatus_candidatosEdit-required">El estatus es requerido</div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label for="name">Foto:</label>
                        <input type="file" id="profile_photo_edit" name="profile_photo_edit" class="form-control" accept="image/png, image/gif, image/jpeg, image/jpg, image/jiff, image/svg+xml"/>
                      </div>
                      <div class="col-md-6" id="applicant_files">
                        <div class="row">
                          <div class="col-md-8">
                            <label for="name">Documentación:</label>
                            <input type="file" id="file_app" name="file_app" class="form-control" />
                            <div class="invalid-feedback" id="invalid-file_app-required">El archivo es requerido</div>
                          </div>
                          <div class="col-md-4">
                            <button class="btn btn-success" id="add-file" type="button" style="margin-top:20px;">Agregar</button>
                          </div>
                        </div>
                      </div>
                        <div class="row mt-2 text-center">
                          <div class="col-md-6" id="img_profile_photo">
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <label for="name"><b>Documentación:</b></label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12" id="applicant_files_list">
                              </div>
                            </div>
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
              </p>
            </div>
            <!-- END TAB INFORMACION -->

            <!-- BEGINNING TAB Academico -->
            <div class="tab-pane fade" id="academicoDiv" role="tabpanel" aria-labelledby="academico-tab">
              <p class="hp-p1-body mb-0">
                <br>
                <div class="table-responsive" id="table-academico">
                    
                </div>
          
          
              </p>
            </div>

            <!-- END TAB academico -->

            
            <!-- BEGINNING TAB Experiencia -->
            <div class="tab-pane fade" id="experienciaDiv" role="tabpanel" aria-labelledby="experiencia-tab">
              <p class="hp-p1-body mb-0">
                <br>
                <div class="table-responsive" id="table-experience">
                    
                </div>
          
          
              </p>
            </div>

            <!-- END TAB Experiencia -->


            <!-- BEGINNING TAB PROCESO -->
            <div class="tab-pane fade" id="procesoDiv" role="tabpanel" aria-labelledby="proceso-tab">
              <span id="hideProcesoDiv">
              <p class="hp-p1-body mb-0">

                <form action="#" method="POST" id="agregarDatosProceso">

                  <input type="hidden" id="idProcesoUnico" name="idProcesoUnico" />
                    <div class="row" style="margin-top: 10px;">
                      <div class="col-md-12">
                          <div class="mb-3">
                            <label for="namePosition" class="form-label">Nombre del puesto</label>
                            <input type="text" class="form-control" id="namePosition" name="namePosition" readonly>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                              <label for="duracion" class="form-label">Duración estimada del proceso</label>
                              <input type="text" class="form-control" id="duracion" name="duracion" maxlength="100" readonly>
                              <div class="invalid-feedback" id="invalid-duracion-required">La duración es requerida</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                              <label for="cantidadfiltros" class="form-label">Cantidad de filtros a realizar</label>
                              <input type="number" class="form-control" id="cantidadfiltros" name="cantidadfiltros"readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="mb-3">
                            <label for="niveles_flitro" class="form-label">Niveles que participan en el filtro</label>
                            <input type="text" class="form-control" id="niveles_flitro" name="niveles_flitro" readonly>
                          </div>
                      </div>
                      <div class="col-md-6">
                        &nbsp;
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="mb-3">
                            <label for="proceso" class="form-label">Indicar si el candidato cumplió con las especificaciones y niveles del proceso:</label>
                            <div class="row" >
                              <div class="col-12" id="field1">
                                  <div class="col-3">
                                    <label class="radio">Entrevista filtro</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="entrevista1" name="entrevista" class="classentrevista" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="entrevista2" name="entrevista" class="classentrevista" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>                           
                              </div>
                              <div class="col-12" id="field2">
                                  <div class="col-3">
                                    <label class="radio">Prueba técnica</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="pruebat1" name="pruebat" class="classpruebat" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="pruebat2" name="pruebat" class="classpruebat" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>
                              </div>
                              <div class="col-12" id="field3">
                                  <div class="col-3">
                                    <label class="radio">Pruebas psicométricas</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="pruebap1" name="pruebap" class="classpruebap" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="pruebap2" name="pruebap" class="classpruebap" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>
                              </div>
                              <div class="col-12" id="field4">
                                  <div class="col-3">
                                    <label class="radio">Referencias</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="referencias1" name="referencias" class="classreferencias" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="referencias2" name="referencias" class="classreferencias" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>
                              </div>
                              <div class="col-12" id="field5">
                                  <div class="col-3">
                                    <label class="radio">Entrevista técnica</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="entrevista_tecnica1" name="entrevista_tecnica" class="classentrevista_tecnica" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="entrevista_tecnica2" name="entrevista_tecnica" class="classentrevista_tecnica" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>
                              </div>
                              <div class="col-12" id="field6">
                                  <div class="col-3">
                                    <label class="radio">Estudio socioeconómico</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="estudio_socioeconomico1" name="estudio_socioeconomico" class="classestudio_socioeconomico" value="1">
                                    <label for="entrevista">Sí</label>
                                  </div>
                                  <div class="col-1">
                                    <input type="radio" id="estudio_socioeconomico2" name="estudio_socioeconomico" class="classestudio_socioeconomico" value="0">
                                    <label for="entrevista">No</label>   
                                  </div>
                                  <div class="col-7"></div>
                              </div>
                            </div>
                            
                            <div class="row mt-4">
                              <div class="col-12">
                                <label class="radio">Estado del candidato <span id="nameCandidato"></span></label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12 text center">
                                <select class="form-select" id="estatus_candidato" name="estatus_candidato" style="width:50%;">
                                  @foreach ($estatus_candidatos as $e)
                                      <option value="{{ $e->id }}">{{ $e->estatus }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <!--<div class="col-3">
                                <input type="radio" id="estatus_candidato_1" name="estatus_candidato" class="classestatus_candidato" value="1">
                                <label for="estatus_candidato">Contratar</label> 
                              </div>
                              <div class="col-3">
                                <input type="radio" id="estatus_candidato_0" name="estatus_candidato" class="classestatus_candidato" value="0">
                                <label for="estatus_candidato">Rechazar</label> 
                              </div>
                              <div class="col-3">
                                <input type="radio" id="estatus_candidato_2" name="estatus_candidato" class="classestatus_candidato" value="2">
                                <label for="estatus_candidato">Pendiente</label> 
                              </div>-->
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
            </span>
          </div>
          <!-- END TAB INFORMACION -->

          </div>

        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="idAplicanteEdit" id="idAplicanteEdit" />
        <input type="hidden" name="idVacanteEdit" id="idVacanteEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarCandidatoEdit" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarCandidato">Guardar</button>
        <button type="button" class="btn btn-primary me-2" id="generarAcademicoNuevo">Agregar estudios</button>
        <button type="button" class="btn btn-primary me-2" id="generarExperienciaNuevo">Agregar experiencia</button>
        <button type="button" class="btn btn-primary me-2" id="generarProcesoNuevo">Guardar proceso</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Agregar Modal Experiencia -->
<div class="modal fade" id="agregarExperienciaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarExperiencia">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Experiencia profesional</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="puesto" class="form-label">Puesto</label>
                <input type="text" class="form-control alpha-only" id="puesto" name="puesto" maxlength="80" required placeholder="Puesto">
                <div class="invalid-feedback" id="invalid-puesto-required">El puesto es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="empresa" class="form-label">Empresa</label>
                <input type="text" class="form-control alpha-only" id="empresa" name="empresa" maxlength="80" required placeholder="Empresa">
                <div class="invalid-feedback" id="invalid-empresa-required">La empresa es requerido</div>
              </div>
          </div>
          <div class="col-md-12">
              <div class="mb-3">
                <label for="detalles_puesto" class="form-label">Actividades y logros</label>
                <textarea id="detalles_puesto" name="detalles_puesto" rows="4" cols="50" class="form-control"></textarea>
              </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="fechaini" class="form-label">Fecha inicio</label>
              <input type="date" class="form-control" id="fechaini" name="fechaini">
              <div class="invalid-feedback" id="invalid-fechaini-required">La fecha de inicio es requerida</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
              <label for="fechafin" class="form-label">Fecha fin</label>
              <input type="date" class="form-control" id="fechafin" name="fechafin">
              <div class="invalid-feedback" id="invalid-fechafin-required">La fecha de termino es requerida</div>
              <div class="invalid-feedback" id="invalid-fechafin-invalid">La fecha de termino no puede ser mayor que la de inicio</div>
            </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">&nbsp;</label>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="puesto_actual">
            <label class="form-check-label" for="puesto_actual">
              Puesto actual
            </label>
          </div>
      </div>

          <div class="row">
            <div class="col-lg-12 invalid-feedback showErrorsExperiencia"><br>
              Completa los campos que se te piden
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregarExperiencia" style="display: none;">
            </div>
          </div>
          <div class="text-center" id="loadingSExperiencia" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <button type="button"class="btn btn-secondary" id="cancelarExperiencia" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarExperiencia">Guardar experiencia</button>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Editar Modal Experiencia -->
<div class="modal fade" id="editarExperienciaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="editarExperiencia">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Editar Experiencia profesional</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-6">
              <div class="mb-3">
                <label for="puestoEdit" class="form-label">Puesto</label>
                <input type="text" class="form-control alpha-only" id="puestoEdit" name="puestoEdit" maxlength="80" required placeholder="Puesto">
                <div class="invalid-feedback" id="invalid-puestoEdit-required">El puesto es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="empresaEdit" class="form-label">Empresa</label>
                <input type="text" class="form-control alpha-only" id="empresaEdit" name="empresaEdit" maxlength="80" required placeholder="Empresa">
                <div class="invalid-feedback" id="invalid-empresaEdit-required">La empresa es requerido</div>
              </div>
          </div>
          <div class="col-md-12">
              <div class="mb-3">
                <label for="detalles_puestoEdit" class="form-label">Actividades y logros</label>
                <textarea id="detalles_puestoEdit" name="detalles_puestoEdit" rows="4" cols="50" class="form-control"></textarea>
              </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="fechainiEdit" class="form-label">Fecha inicio</label>
              <input type="date" class="form-control" id="fechainiEdit" name="fechainiEdit">
              <div class="invalid-feedback" id="invalid-fechainiEdit-required">La fecha de inicio es requerida</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
              <label for="fechafinEdit" class="form-label">Fecha fin</label>
              <input type="date" class="form-control" id="fechafinEdit" name="fechafinEdit">
              <div class="invalid-feedback" id="invalid-fechafinEdit-required">La fecha de termino es requerida</div>
              <div class="invalid-feedback" id="invalid-fechafinEdit-invalid">La fecha de termino no puede ser mayor que la de inicio</div>
            </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">&nbsp;</label>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="puesto_actualEdit">
            <label class="form-check-label" for="puesto_actualEdit">
              Puesto actual
            </label>
          </div>
      </div>

          <div class="row">
            <div class="col-lg-12 invalid-feedback showErrorsExperienciaEdit"><br>
              Completa los campos que se te piden
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresEditarExperiencia" style="display: none;">
            </div>
          </div>
          <div class="text-center" id="loadingSExperienciaEdit" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="idExperienciaEdit" id="idExperienciaEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarExperienciaEdit" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarExperiencia">Modificar experiencia</button>
      </div>
    </div>
    </form>
  </div>
</div>


<!-- Agregar Modal Academico -->
<div class="modal fade" id="agregarAcademicoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="agregarAcademico">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Educación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="escolaridad" class="form-label">Nivel</label>
                <select class="form-select" id="escolaridad" name="escolaridad">
                  <option value="">Selecciona un nivel</option>
                    @foreach ($escolaridad as $e)
                        <option value="{{ $e->id }}">{{ $e->nivel }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="invalid-escolaridad-required">El nivel es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="institucion" class="form-label">Institución</label>
                <input type="text" class="form-control alphaNumeric-only" id="institucion" name="institucion" maxlength="80" required placeholder="Institución">
                <div class="invalid-feedback" id="invalid-institucion-required">La institución es requerida</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="titulo_carrera" class="form-label">Título o carrera</label>
                <input type="text" class="form-control alpha-only" id="titulo_carrera" name="titulo_carrera" maxlength="120" required placeholder="Título o carrera">
                <div class="invalid-feedback" id="invalid-titulo_carrera-required">El título o carrera es requerido</div>
              </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label for="anioini" class="form-label">Año inicio</label>
              <input type="number" class="form-control" id="anioini" name="anioini">
              <div class="invalid-feedback" id="invalid-anioini-required">El año de inicio es requerido</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
              <label for="aniofin" class="form-label">Año fin</label>
              <input type="number" class="form-control" id="aniofin" name="aniofin">
              <div class="invalid-feedback" id="invalid-aniofin-required">El año de fin es requerido</div>
            </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">&nbsp;</label>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="estudio">
            <label class="form-check-label" for="estudio">
              En curso
            </label>
          </div>
      </div>

          <div class="row">
            <div class="col-lg-12 invalid-feedback showErrorsAcademico"><br>
              Completa los campos que se te piden
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresAgregarAcademico" style="display: none;">
            </div>
          </div>
          <div class="text-center" id="loadingSAcademico" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <button type="button"class="btn btn-secondary" id="cancelarAcademico" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="guardarAcademico">Guardar estudio</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Edit Modal Academico -->
<div class="modal fade" id="editAcademicoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="#" method="POST" id="editAcademicoForm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Modificar Educación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
              <div class="mb-3">
                <label for="escolaridadEdit" class="form-label">Nivel</label>
                <select class="form-select" id="escolaridadEdit" name="escolaridadEdit">
                </select>
                <div class="invalid-feedback" id="invalid-escolaridadEdit-required">El nivel es requerido</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="institucionEdit" class="form-label">Institución</label>
                <input type="text" class="form-control alphaNumeric-only" id="institucionEdit" name="institucionEdit" maxlength="80" required placeholder="Institución">
                <div class="invalid-feedback" id="invalid-institucionEdit-required">La institución es requerida</div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="mb-3">
                <label for="titulo_carreraEdit" class="form-label">Título o carrera</label>
                <input type="text" class="form-control alpha-only" id="titulo_carreraEdit" name="titulo_carreraEdit" maxlength="120" required placeholder="Título o carrera">
                <div class="invalid-feedback" id="invalid-titulo_carreraEdit-required">El título o carrera es requerido</div>
              </div>
          </div>

          <div class="col-md-4">
            <div class="mb-3">
              <label for="anioini" class="form-label">Año inicio</label>
              <input type="number" class="form-control" id="anioiniEdit" name="anioiniEdit">
              <div class="invalid-feedback" id="invalid-anioiniEdit-required">El año de inicio es requerido</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
              <label for="aniofinEdit" class="form-label">Año fin</label>
              <input type="number" class="form-control" id="aniofinEdit" name="aniofinEdit">
              <div class="invalid-feedback" id="invalid-aniofinEdit-required">El año de fin es requerido</div>
            </div>
        </div>
        <div class="col-md-4">
          <label class="form-label">&nbsp;</label>
          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="estudioEdit">
            <label class="form-check-label" for="estudioEdit">
              En curso
            </label>
          </div>
      </div>

          <div class="row">
            <div class="col-lg-12 invalid-feedback showErrorsAcademicoEdit"><br>
              Completa los campos que se te piden
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 alert alert-danger alert-dismissible fade show" id="erroresEditAcademico" style="display: none;">
            </div>
          </div>
          <div class="text-center" id="loadingSAcademicoEdit" style="visibility: hidden;">
            <div class="spinner-border hp-border-color-dark-40 text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        

        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="idAcademicoEdit" name="idAcademicoEdit" />
        <button type="button"class="btn btn-secondary" id="cancelarAcademicoEdit" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary me-2" id="modificarAcademico">Modificar estudio</button>
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
                    title: 'Candidatos',
                    exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    customize: function (doc) {
                                doc.defaultStyle.fontSize = 8; //2, 3, 4,etc
                                doc.styles.tableHeader.fontSize = 12; //2, 3, 4, etc
                                doc.content[1].table.widths = [ '5%', '17%', '17%',
                                                                '10%','12%', '17%', '10%', '12%'];
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-dark',
                    text: 'Excel',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    title: 'Candidatos'
                }
          ],
          ajax: '{{ url('applicant.index') }}',
          columns: [
                   { data: 'id', name: 'id' },
                   { data: 'nombres', name: 'names' },
                   { data: 'apellidos', name: 'lastnames' },
                   { data: 'edad', name: 'age' },
                   { data: 'perfil', name: 'profile' },
                   { data: 'pretensiones', name: 'pretensions' },
                   { data: 'estatus_candidatos', name: 'estatus_candidatos' },
                   { data: 'requirement', name: 'requirement' },
                   { data: 'action', name: 'action' },
                ],
          "order": [],
          "columnDefs": [
              //{ "visible": false, "targets": 0 },
              { "orderable": false, "targets": 7 },
          ]
       });
    });

  let errores = 0;
  $("#guardarCandidato").click(function(){

        let names = $("#names").val().trim();
        let lastnames = $("#lastnames").val().trim();
        let age = $("#age").val().trim();
        let phone = $("#phone").val().trim();
        let email = $("#email").val().trim();
        let city = $("#city").val().trim();
        let pretensions = $("#pretensions").val().trim();
        let profile = $("#profile").val().trim();
        let specialty = $("#specialty").val().trim();
        let applicant_status = $("#estatus_candidatos").val().trim();

        //validar name
        if(names == '' || names == null){
            $("#invalid-names-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-names-required").removeClass("showFeedback");
        }

        //validar lastnames
        if(lastnames == '' || lastnames == null){
            $("#invalid-lastnames-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-lastnames-required").removeClass("showFeedback");
        }

        //validar age
        if(age == '' || age == null){
            $("#invalid-age-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-age-required").removeClass("showFeedback");
        }

        //validar phone
        if(phone == '' || phone == null){
            $("#invalid-phone-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-phone-required").removeClass("showFeedback");
        }

        //validar email
        if(email == '' || email == null){
            $("#invalid-email-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-email-required").removeClass("showFeedback");
        }

        if(!isEmail(email)){
            $("#invalid-email-valid-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-email-valid-required").removeClass("showFeedback");
        }

        //validar city
        if(city == '' || city == null){
            $("#invalid-city-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-city-required").removeClass("showFeedback");
        }

        //validar pretensions
        if(pretensions == '' || pretensions == null){
            $("#invalid-pretensions-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-pretensions-required").removeClass("showFeedback");
        }

        //validar profile
        if(profile == '' || profile == null){
            $("#invalid-profile-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-profile-required").removeClass("showFeedback");
        }

        //validar specialty
        if(specialty == '' || specialty == null){
            $("#invalid-specialty-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-specialty-required").removeClass("showFeedback");
        }

        //validar applicant_status
        if(applicant_status == '' || applicant_status == null){
            $("#invalid-estatus_candidatos-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-estatus_candidatos-required").removeClass("showFeedback");
        }

        if(errores > 0){
            errores = 0;
            $(".showErrors").css("display","flex");
            setTimeout(function(){
                $(".showErrors").css("display","none");
            }, 5000);
            return;
        }

        $("#guardarCandidato").attr("disabled",true);
        $("#cancelarCandidato").attr("disabled",true);
        $("#loadingS").css("visibility","visible");

        let formData = new FormData();
        formData.append('names', names);
        formData.append('lastnames', lastnames);
        formData.append('age', age);
        formData.append('phone', phone);
        formData.append('correo', email);
        formData.append('city', city);
        formData.append('pretensions', pretensions);
        formData.append('profile', profile);
        formData.append('specialty', specialty);
        formData.append('applicant_status', applicant_status);
        formData.append('profile_photo', $('#profile_photo')[0].files[0]);
        formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                type: "POST",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                url: "/applicantactions",
                success: function(msg){ 
                //console.log(msg);
                  if(msg == '1'){

                      Lobibox.notify("success", {
                      size: "mini",
                      rounded: true,
                      delay: 3000,
                      delayIndicator: false,
                      position: "center top",
                      msg: "Candidato agregado.",
                      });
                      table.ajax.reload();
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
                    $("#guardarCandidato").attr("disabled",false);
                    $("#cancelarCandidato").attr("disabled",false);
                    $("#loadingS").css("visibility","hidden");
                }
            }); 
    });

    let erroresEdit = 0;
    $("#modificarCandidato").click(function(){
      
      let idAplicante = $("#idAplicanteEdit").val().trim();
      let names = $("#namesEdit").val().trim();
      let lastnames = $("#lastnamesEdit").val().trim();
      let age = $("#ageEdit").val().trim();
      let phone = $("#phoneEdit").val().trim();
      let email = $("#emailEdit").val().trim();
      let city = $("#cityEdit").val().trim();
      let pretensions = $("#pretensionsEdit").val().trim();
      let profile = $("#profileEdit").val().trim();
      let specialty = $("#specialtyEdit").val().trim();
      let applicant_status = $("#estatus_candidatosEdit").val().trim();

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

      //validar age
      if(age == '' || age == null){
          $("#invalid-age-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-age-required").removeClass("showFeedback");
      }

      //validar phone
      if(phone == '' || phone == null){
          $("#invalid-phone-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-phone-required").removeClass("showFeedback");
      }

      //validar email
      if(email == '' || email == null){
          $("#invalid-email-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-email-required").removeClass("showFeedback");
      }

      if(!isEmail(email)){
          $("#invalid-email-valid-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-email-valid-required").removeClass("showFeedback");
      }

      //validar city
      if(city == '' || city == null){
          $("#invalid-city-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-city-required").removeClass("showFeedback");
      }

      //validar pretensions
      if(pretensions == '' || pretensions == null){
          $("#invalid-pretensions-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-pretensions-required").removeClass("showFeedback");
      }

      //validar profile
      if(profile == '' || profile == null){
          $("#invalid-profile-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-profile-required").removeClass("showFeedback");
      }

      //validar specialty
      if(specialty == '' || specialty == null){
          $("#invalid-specialty-required").addClass("showFeedback");
          erroresEdit++;
      }
      else{
          $("#invalid-specialty-required").removeClass("showFeedback");
      }

      //validar applicant_status
      if(applicant_status == '' || applicant_status == null){
            $("#invalid-estatus_candidatosEdit-required").addClass("showFeedback");
            errores++;
        }
        else{
            $("#invalid-estatus_candidatosEdit-required").removeClass("showFeedback");
        }

      if(erroresEdit > 0){
          erroresEdit = 0;
          $(".showErrorsEdit").css("display","flex");
          setTimeout(function(){
              $(".showErrorsEdit").css("display","none");
          }, 5000);
          return;
      }

      $("#modificarCandidato").attr("disabled",true);
      $("#cancelarCandidatoEdit").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

      let formData = new FormData();
      formData.append('names', names);
      formData.append('lastnames', lastnames);
      formData.append('age', age);
      formData.append('phone', phone);
      formData.append('correo', email);
      formData.append('city', city);
      formData.append('pretensions', pretensions);
      formData.append('profile', profile);
      formData.append('specialty', specialty);
      formData.append('applicant_status', applicant_status);
      if( $('#profile_photo_edit').val() != ''){
        formData.append('profile_photo', $('#profile_photo_edit')[0].files[0]);
      }
      formData.append("_token", "{{ csrf_token() }}");

          $.ajax({
              type: "POST",
              data: formData,
              cache:false,
              contentType:  false,
              processData: false,
              url: "/applicantedit/" + idAplicante,
              success: function(msg){ 
                if(msg == '1'){

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: "Candidato modificado",
                  });
                  table.ajax.reload();
                  $("#modificarCandidatoForm").trigger("reset");
                  $("#modificarCandidatoModal").modal('hide');
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

                $("#modificarCandidato").attr("disabled",false);
                $("#cancelarCandidatoEdit").attr("disabled",false);
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

                  $("#modificarCandidato").attr("disabled",false);
                  $("#cancelarCandidatoEdit").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });


    $(document).on("click", ".editar", function(){
      let id = this.id;

      $("#modificarCandidatoForm").trigger("reset");
      $("#erroresAgregarEditar").css('display','none');

      $("#info-tab").addClass('active');   
      $("#experiencia-tab").removeClass('active');
      $("#academico-tab").removeClass('active');
      $("#proceso-tab").removeClass('active');

      $("#infoDiv").addClass('active show');   
      $("#experienciaDiv").removeClass('active show');
      $("#academicoDiv").removeClass('active show');
      $("#procesoDiv").removeClass('active show');

      $("#generarAcademicoNuevo").css('display','none');

        $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/applicantactions/" + id,
            success: function(msg){ 
              //console.log(msg);
              
              $("#idAplicanteEdit").val(msg.idcandidato);
              $("#namesEdit").val(msg.nombres);
              $("#lastnamesEdit").val(msg.apellidos);
              $("#ageEdit").val(msg.edad);
              $("#phoneEdit").val(msg.telefono);
              $("#emailEdit").val(msg.correo);
              $("#cityEdit").html(msg.ciudadSelect);
              $("#pretensionsEdit").val(msg.pretensiones);
              $("#profileEdit").val(msg.perfil);
              $("#specialtyEdit").html(msg.especialidadSelect);
              $("#estatus_candidatosEdit").val(msg.estatus_candidatos);
              
              
              $("#modificarCandidato").css('display','inline-flex');   
              $("#generarExperienciaNuevo").css('display','none');
              $("#generarProcesoNuevo").css('display','none'); 
              $("#generarAcademicoNuevo").css('display','none');

              $("#img_profile_photo").html("<img src='" + msg.route_image +"' class='rounded' style='height:150px; width:auto;' />");

              if(msg.estatus_op == 0 || msg.estatus_op == 5){
                $("#proceso-tab").css("visibility","hidden");
              }
              if(msg.estatus_op == 1){
                if(msg.reclutador == 1){
                  $("#proceso-tab").css("visibility","visible");
                }
                else{
                  $("#proceso-tab").css("visibility","hidden");
                }
                
              }
              getFiles(id);
              
              $("#modificarCandidatoModal").modal("show");
              
            }
        }); 
      
    });

    $("#add-file").click(function(){
      
      let file_app = $("#file_app").val().trim();

      if(file_app == '' || file_app == null){
          $("#invalid-file_app-required").addClass("showFeedback");
          return;
      }
      else{
          $("#invalid-file_app-required").removeClass("showFeedback");
      }

      $("#add-file").attr("disabled",true);
      $("#loadingSEdit").css("visibility","visible");

      let idAplicante = $("#idAplicanteEdit").val().trim();
      let name_file = $("#file_app").val().trim();
      let formData = new FormData();
      formData.append('idAplicante', idAplicante);
      formData.append('file_app', $('#file_app')[0].files[0]);
      formData.append("_token", "{{ csrf_token() }}");

          $.ajax({
              type: "POST",
              data: formData,
              cache:false,
              contentType:  false,
              processData: false,
              url: "/applicantaddfile",
              success: function(msg){ 
                if(msg == '1' || msg == '2'){

                  let message = 'Documento agregado';
                  if( msg == '2') message = 'Documento modificado';

                  Lobibox.notify("success", {
                    size: "mini",
                    rounded: true,
                    delay: 3000,
                    delayIndicator: false,
                    position: "center top",
                    msg: message,
                  });

                  if( msg == '1'){
                    getFiles(idAplicante);
                  }

                  $("#add-file").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
                  $("#file_app").val("");

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

                $("#add-file").attr("disabled",false);
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

                  $("#add-file").attr("disabled",false);
                  $("#loadingSEdit").css("visibility","hidden");
              }
          }); 

    });

    function getFiles(idApplicant){
      
      $.ajax({
            type: "GET",
            dataType: 'JSON',
            data: { "_token": "{{ csrf_token() }}" },
            url: "/getfilesbyapplicant/" + idApplicant,
            success: function(msg){ 
              //console.log(msg);
              
              $("#applicant_files_list").html(msg.info);
              
            }
        }); 
    }

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
          pregunta = '¿Quieres inactivar este candidato?';
          estado = 'desactivado';
        }
        else{
          pregunta = '¿Quieres activar este candidato?';
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
                url: "/applicantactions/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Candidato " + estado,
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

  $(document).on("click", ".delete_file", function(){
        let id = this.id;
        let idAplicante = $("#idAplicanteEdit").val().trim();

        Swal.fire({
        title: '¿Quieres eliminar este documento?',
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
                url: "/deletefile/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Documento eliminado",
                    });
                    getFiles(idAplicante);
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
            
        }
        })
        
  });

    $(document).on("change", "#names, #lastnames, #age, #phone, #city, #pretensions, #profile, #specialty, #estatus_candidatos, #namesEdit, #lastnamesEdit, #ageEdit, #codeEdit, #phoneEdit, #cityEdit, #pretensionsEdit, #profileEdit, #specialtyEdit, #puesto, #empresa, #fechaini,#fechafin,  #puestoEdit, #empresaEdit, #fechainiEdit, #fechafinEdit, #escolaridad, #institucion, #titulo_carrera, #anioini, #aniofin, #estudio, #escolaridadEdit, #institucionEdit, #titulo_carreraEdit, #anioiniEdit, #aniofinEdit, #estudioEdit, #estatus_candidatosEdit", function () {
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

    
    $(document).on("change", "#fechaini,#fechafin", function () {
        
        let puestoactual;

        if(document.getElementById('puesto_actual').checked) {
            puestoactual = 1;
        } else {
            puestoactual = 0;
        }

        let fechaini = $("#fechaini").val().trim();
        let fechafin = $("#fechafin").val().trim();

        if(puestoactual == 0){
          if(fechafin == '' || fechafin == null){
              $("#invalid-fechafin-required").addClass("showFeedback");
          }
          else{
              $("#invalid-fechafin-required").removeClass("showFeedback");
          }

          if(new Date(fechafin) < new Date(fechaini))
          {
              $("#invalid-fechafin-invalid").addClass("showFeedback");
          }
          else{
              $("#invalid-fechafin-invalid").removeClass("showFeedback");
          }
        }

    });


    $(document).on("change", "#fechainiEdit, #fechafinEdit", function () {
        
        let puestoactual;

        if(document.getElementById('puesto_actualEdit').checked) {
            puestoactual = 1;
        } else {
            puestoactual = 0;
        }

        let fechaini = $("#fechainiEdit").val().trim();
        let fechafin = $("#fechafinEdit").val().trim();

        if(puestoactual == 0){
          if(fechafin == '' || fechafin == null){
              $("#invalid-fechafinEdit-required").addClass("showFeedback");
          }
          else{
              $("#invalid-fechafinEdit-required").removeClass("showFeedback");
          }

          if(new Date(fechafin) < new Date(fechaini))
          {
              $("#invalid-fechafinEdit-invalid").addClass("showFeedback");
          }
          else{
              $("#invalid-fechafinEdit-invalid").removeClass("showFeedback");
          }
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
        
        if(contenido == "The age field is required.")
          nuevo_contenido = contenido.replace("The age field is required.", "El campo edad es requerido.");
          
        if(contenido == "The code field is required.")
          nuevo_contenido = contenido.replace("The code field is required.", "El campo código es requerido.");

        if(contenido == "The phone field is required.")
          nuevo_contenido = contenido.replace("The phone field is required.", "El campo teléfono es requerido.");

        if(contenido == "The correo field is required.")
          nuevo_contenido = contenido.replace("The correo field is required.", "El campo correo es requerido.");
        
        if(contenido == "The city field is required.")
          nuevo_contenido = contenido.replace("The city field is required.", "El campo ciudad es requerido.");
        
        if(contenido == "The pretensions field is required.")
          nuevo_contenido = contenido.replace("The pretensions field is required.", "El campo pretensiones es requerido.");
          
        if(contenido == "The profile field is required.")
          nuevo_contenido = contenido.replace("The profile field is required.", "El campo perfil es requerido.");

        if(contenido == "The specialty field is required.")
          nuevo_contenido = contenido.replace("The specialty field is required.", "El campo especialidad es requerido.");
        
        if(contenido == "The correo must be a valid email address.")
          nuevo_contenido = contenido.replace("The correo must be a valid email address.", "El campo correo debe ser un correo válido.");

        if(contenido == "The correo has already been taken.")
          nuevo_contenido = contenido.replace("The correo has already been taken.", "El campo correo ya fue ingresado con otro candidato.");

        /*MESSAGES OF EXPERIENCE*/
        if(contenido == "The empresa field is required.")
          nuevo_contenido = contenido.replace("The empresa field is required.", "El campo empresa es requerido.");
        
        if(contenido == "The fechaini field is required.")
          nuevo_contenido = contenido.replace("The fechaini field is required.", "El campo fecha de inicio es requerido.");

        if(contenido == "The puesto field is required.")
          nuevo_contenido = contenido.replace("The puesto field is required.", "El campo puesto es requerido.");
        

        /*MESSAGES OF ACADEMIC*/
        if(contenido == "The aniofin field is required.")
          nuevo_contenido = contenido.replace("The aniofin field is required.", "El campo año fin es requerido.");
        
        if(contenido == "The anioini field is required.")
          nuevo_contenido = contenido.replace("The anioini field is required.", "El campo año inicio de inicio es requerido.");

        if(contenido == "The escolaridad field is required.")
          nuevo_contenido = contenido.replace("The escolaridad field is required.", "El campo escolaridad es requerido.");
        
        if(contenido == "The institucion field is required.")
          nuevo_contenido = contenido.replace("The institucion field is required.", "El campo institución es requerido.");
        
        if(contenido == "The titulo carrera field is required.")
          nuevo_contenido = contenido.replace("The titulo carrera field is required.", "El campo título o carrera es requerido.");

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

    let erroresExperiencia = 0;
    $("#guardarExperiencia").click(function(){

          let idAplicante = $("#idAplicanteEdit").val().trim();
          let puesto = $("#puesto").val().trim();
          let empresa = $("#empresa").val().trim();
          let detalles_puesto = $("#detalles_puesto").val().trim();
          let fechaini = $("#fechaini").val().trim();
          let fechafin = $("#fechafin").val().trim();
          let puestoactual;

          if(document.getElementById('puesto_actual').checked) {
              puestoactual = 1;
          } else {
              puestoactual = 0;
          }
         
          //validar puesto
          if(puesto == '' || puesto == null){
              $("#invalid-puesto-required").addClass("showFeedback");
              erroresExperiencia++;
          }
          else{
              $("#invalid-puesto-required").removeClass("showFeedback");
          }

          //validar empresa
          if(empresa == '' || empresa == null){
              $("#invalid-empresa-required").addClass("showFeedback");
              erroresExperiencia++;
          }
          else{
              $("#invalid-empresa-required").removeClass("showFeedback");
          }

          //validar age
          if(fechaini == '' || fechaini == null){
              $("#invalid-fechaini-required").addClass("showFeedback");
              erroresExperiencia++;
          }
          else{
              $("#invalid-fechaini-required").removeClass("showFeedback");
          }

          if(puestoactual == 0){
            if(fechafin == '' || fechafin == null){
                $("#invalid-fechafin-required").addClass("showFeedback");
                erroresExperiencia++;
            }
            else{
                $("#invalid-fechafin-required").removeClass("showFeedback");
            }

            if(new Date(fechafin) < new Date(fechaini))
            {
                $("#invalid-fechafin-invalid").addClass("showFeedback");
                erroresExperiencia++;
            }
            else{
                $("#invalid-fechafin-invalid").removeClass("showFeedback");
            }
          }
          else{
            fechafin = '';
          }

          if(erroresExperiencia > 0){
            erroresExperiencia = 0;
              $(".showErrorsExperiencia").css("display","flex");
              setTimeout(function(){
                  $(".showErrorsExperiencia").css("display","none");
              }, 5000);
              return;
          }

          $("#guardarExperiencia").attr("disabled",true);
          $("#cancelarExperiencia").attr("disabled",true);
          $("#loadingSExperiencia").css("visibility","visible");


              $.ajax({
                  type: "POST",
                  data: { puesto : puesto,
                          empresa : empresa,
                          detalles_puesto : detalles_puesto,
                          fechaini : fechaini,
                          fechafin : fechafin,
                          puestoactual : puestoactual,
                          candidato_id: idAplicante,
                          "_token": "{{ csrf_token() }}" },
                  dataType: 'JSON',
                  url: "/applicantexperience",
                  success: function(msg){ 
                  //console.log(msg);
                    if(msg == '1'){

                        Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Información agregada.",
                        });
                        table.ajax.reload();
                        $("#agregarExperiencia").trigger("reset");
                        $("#agregarExperienciaModal").modal('hide');

                        cargarExperience(idAplicante);
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

                    $("#guardarExperiencia").attr("disabled",false);
                    $("#cancelarExperiencia").attr("disabled",false);
                    $("#loadingSExperiencia").css("visibility","hidden");
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
                      mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaExperiencia">' +
                      '<span aria-hidden="true">&times;</span>' +
                      '</button>';
                      $("#erroresAgregarExperiencia").html(mensaje);
                      $("#erroresAgregarExperiencia").css("display","flex");
                      $("#guardarExperiencia").attr("disabled",false);
                      $("#cancelarExperiencia").attr("disabled",false);
                      $("#loadingSExperiencia").css("visibility","hidden");
                  }
              }); 
      });
    
      let erroresExperienciaEdit = 0;
      $("#modificarExperiencia").click(function(){

            let idExperiencia = $("#idExperienciaEdit").val().trim();
            let puesto = $("#puestoEdit").val().trim();
            let empresa = $("#empresaEdit").val().trim();
            let detalles_puesto = $("#detalles_puestoEdit").val().trim();
            let fechaini = $("#fechainiEdit").val().trim();
            let fechafin = $("#fechafinEdit").val().trim();
            let puestoactual;

            if(document.getElementById('puesto_actualEdit').checked) {
                puestoactual = 1;
            } else {
                puestoactual = 0;
            }
          
            //validar puesto
            if(puesto == '' || puesto == null){
                $("#invalid-puestoEdit-required").addClass("showFeedback");
                erroresExperienciaEdit++;
            }
            else{
                $("#invalid-puestoEdit-required").removeClass("showFeedback");
            }

            //validar empresa
            if(empresa == '' || empresa == null){
                $("#invalid-empresaEdit-required").addClass("showFeedback");
                erroresExperienciaEdit++;
            }
            else{
                $("#invalid-empresaEdit-required").removeClass("showFeedback");
            }

            //validar age
            if(fechaini == '' || fechaini == null){
                $("#invalid-fechainiEdit-required").addClass("showFeedback");
                erroresExperienciaEdit++;
            }
            else{
                $("#invalid-fechainiEdit-required").removeClass("showFeedback");
            }

            if(puestoactual == 0){
              if(fechafin == '' || fechafin == null){
                  $("#invalid-fechafinEdit-required").addClass("showFeedback");
                  erroresExperienciaEdit++;
              }
              else{
                  $("#invalid-fechafinEdit-required").removeClass("showFeedback");
              }

              if(new Date(fechafin) < new Date(fechaini))
              {
                  $("#invalid-fechafinEdit-invalid").addClass("showFeedback");
                  erroresExperienciaEdit++;
              }
              else{
                  $("#invalid-fechafinEdit-invalid").removeClass("showFeedback");
              }
            }
            else{
              fechafin = '';
            }
            
            if(erroresExperienciaEdit > 0){
              erroresExperienciaEdit = 0;
                $(".showErrorsExperienciaEdit").css("display","flex");
                setTimeout(function(){
                    $(".showErrorsExperienciaEdit").css("display","none");
                }, 5000);
                return;
            }

            $("#modificarExperiencia").attr("disabled",true);
            $("#cancelarExperienciaEdit").attr("disabled",true);
            $("#loadingSExperienciaEdit").css("visibility","visible");


                $.ajax({
                    type: "POST",
                    data: { puesto : puesto,
                            empresa : empresa,
                            detalles_puesto : detalles_puesto,
                            fechaini : fechaini,
                            fechafin : fechafin,
                            puestoactual : puestoactual,
                            "_token": "{{ csrf_token() }}" },
                    dataType: 'JSON',
                    url: "/applicantexperience/" + idExperiencia,
                    success: function(msg){ 
                    //console.log(msg);
                      if(msg == '1'){

                          Lobibox.notify("success", {
                          size: "mini",
                          rounded: true,
                          delay: 3000,
                          delayIndicator: false,
                          position: "center top",
                          msg: "Información modificada.",
                          });
                          table.ajax.reload();
                          $("#editarExperiencia").trigger("reset");
                          $("#editarExperienciaModal").modal('hide');

                          let idAplicante = $("#idAplicanteEdit").val().trim();
                          cargarExperience(idAplicante); 
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
                      
                      $("#modificarExperiencia").attr("disabled",false);
                      $("#cancelarExperienciaEdit").attr("disabled",false);
                      $("#loadingSExperienciaEdit").css("visibility","hidden");
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
                        mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaExperienciaEditar">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>';
                        $("#erroresEditarExperiencia").html(mensaje);
                        $("#erroresEditarExperiencia").css("display","flex");
                        $("#modificarExperiencia").attr("disabled",false);
                        $("#cancelarExperienciaEdit").attr("disabled",false);
                        $("#loadingSExperienciaEdit").css("visibility","hidden");
                    }
                }); 
        });
    
      let erroresAcademico = 0;
      $("#guardarAcademico").click(function(){

            let idAplicante = $("#idAplicanteEdit").val().trim();
            let escolaridad = $("#escolaridad").val();
            let institucion = $("#institucion").val().trim();
            let titulo_carrera = $("#titulo_carrera").val().trim();
            let anioini = $("#anioini").val().trim();
            let aniofin = $("#aniofin").val().trim();
            let estudio;

            if(document.getElementById('estudio').checked) {
                estudio = 1;
            } else {
                estudio = 0;
            }
          
            //validar escolaridad
            if(escolaridad == '' || escolaridad == null){
                $("#invalid-escolaridad-required").addClass("showFeedback");
                erroresAcademico++;
            }
            else{
                $("#invalid-escolaridad-required").removeClass("showFeedback");
            }

            //validar institucion
            if(institucion == '' || institucion == null){
                $("#invalid-institucion-required").addClass("showFeedback");
                erroresAcademico++;
            }
            else{
                $("#invalid-institucion-required").removeClass("showFeedback");
            }

            //validar titulo carrera
            if(titulo_carrera == '' || titulo_carrera == null){
                $("#invalid-titulo_carrera-required").addClass("showFeedback");
                erroresAcademico++;
            }
            else{
                $("#invalid-titulo_carrera-required").removeClass("showFeedback");
            }

            //validar anioini
            if(anioini == '' || anioini == null){
                $("#invalid-anioini-required").addClass("showFeedback");
                erroresAcademico++;
            }
            else{
                $("#invalid-anioini-required").removeClass("showFeedback");
            }

            //validar aniofin
            if(aniofin == '' || aniofin == null){
                $("#invalid-aniofin-required").addClass("showFeedback");
                erroresAcademico++;
            }
            else{
                $("#invalid-aniofin-required").removeClass("showFeedback");
            }            

            if(erroresAcademico > 0){
              erroresAcademico = 0;
                $(".showErrorsAcademico").css("display","flex");
                setTimeout(function(){
                    $(".showErrorsAcademico").css("display","none");
                }, 5000);
                return;
            }

            $("#guardarAcademico").attr("disabled",true);
            $("#cancelarAcademico").attr("disabled",true);
            $("#loadingSAcademico").css("visibility","visible");


                $.ajax({
                    type: "POST",
                    data: { escolaridad : escolaridad,
                            institucion : institucion,
                            titulo_carrera : titulo_carrera,
                            anioini : anioini,
                            aniofin : aniofin,
                            estudio : estudio,
                            candidato_id: idAplicante,
                            "_token": "{{ csrf_token() }}" },
                    dataType: 'JSON',
                    url: "/applicantacademico",
                    success: function(msg){ 
                    //console.log(msg);
                      if(msg == '1'){

                          Lobibox.notify("success", {
                          size: "mini",
                          rounded: true,
                          delay: 3000,
                          delayIndicator: false,
                          position: "center top",
                          msg: "Información academica agregada.",
                          });
                          table.ajax.reload();
                          $("#agregarAcademico").trigger("reset");
                          $("#agregarAcademicoModal").modal('hide');

                          cargarAcademico(idAplicante);
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

                      $("#guardarAcademico").attr("disabled",false);
                      $("#cancelarAcademico").attr("disabled",false);
                      $("#loadingSAcademico").css("visibility","hidden");
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
                        mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaAcademico">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>';
                        $("#erroresAgregarAcademico").html(mensaje);
                        $("#erroresAgregarAcademico").css("display","flex");
                        $("#guardarAcademico").attr("disabled",false);
                        $("#cancelarAcademico").attr("disabled",false);
                        $("#loadingSAcademico").css("visibility","hidden");
                    }
                }); 
        });
    

    let erroresAcademicoEdit = 0;
    $("#modificarAcademico").click(function(){

          let idAplicante = $("#idAplicanteEdit").val().trim();
          let idAcademico = $("#idAcademicoEdit").val().trim();
          let escolaridad = $("#escolaridadEdit").val();
          let institucion = $("#institucionEdit").val().trim();
          let titulo_carrera = $("#titulo_carreraEdit").val().trim();
          let anioini = $("#anioiniEdit").val().trim();
          let aniofin = $("#aniofinEdit").val().trim();
          let estudio;

          if(document.getElementById('estudioEdit').checked) {
              estudio = 1;
          } else {
              estudio = 0;
          }
        
          //validar escolaridad
          if(escolaridad == '' || escolaridad == null){
              $("#invalid-escolaridadEdit-required").addClass("showFeedback");
              erroresAcademicoEdit++;
          }
          else{
              $("#invalid-escolaridadEdit-required").removeClass("showFeedback");
          }

          //validar institucion
          if(institucion == '' || institucion == null){
              $("#invalid-institucionEdit-required").addClass("showFeedback");
              erroresAcademicoEdit++;
          }
          else{
              $("#invalid-institucionEdit-required").removeClass("showFeedback");
          }

          //validar titulo carrera
          if(titulo_carrera == '' || titulo_carrera == null){
              $("#invalid-titulo_carreraEdit-required").addClass("showFeedback");
              erroresAcademicoEdit++;
          }
          else{
              $("#invalid-titulo_carreraEdit-required").removeClass("showFeedback");
          }

          //validar anioini
          if(anioini == '' || anioini == null){
              $("#invalid-anioiniEdit-required").addClass("showFeedback");
              erroresAcademicoEdit++;
          }
          else{
              $("#invalid-anioiniEdit-required").removeClass("showFeedback");
          }

          //validar aniofin
          if(aniofin == '' || aniofin == null){
              $("#invalid-aniofinEdit-required").addClass("showFeedback");
              erroresAcademicoEdit++;
          }
          else{
              $("#invalid-aniofinEdit-required").removeClass("showFeedback");
          }            

          if(erroresAcademicoEdit > 0){
            erroresAcademicoEdit = 0;
              $(".showErrorsAcademicoEdit").css("display","flex");
              setTimeout(function(){
                  $(".showErrorsAcademicoEdit").css("display","none");
              }, 5000);
              return;
          }

          $("#modificarAcademico").attr("disabled",true);
          $("#cancelarAcademicoEdit").attr("disabled",true);
          $("#loadingSAcademicoEdit").css("visibility","visible");


              $.ajax({
                  type: "POST",
                  data: { escolaridad : escolaridad,
                          institucion : institucion,
                          titulo_carrera : titulo_carrera,
                          anioini : anioini,
                          aniofin : aniofin,
                          estudio : estudio,
                          candidato_id: idAplicante,
                          "_token": "{{ csrf_token() }}" },
                  dataType: 'JSON',
                  url: "/applicantacademico/" + idAcademico,
                  success: function(msg){ 
                  //console.log(msg);
                    if(msg == '1'){

                        Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Información academica modificada.",
                        });
                        table.ajax.reload();
                        $("#editAcademicoForm").trigger("reset");
                        $("#editAcademicoModal").modal('hide');

                        cargarAcademico(idAplicante);
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

                    $("#modificarAcademico").attr("disabled",false);
                    $("#cancelarAcademicoEdit").attr("disabled",false);
                    $("#loadingSAcademicoEdit").css("visibility","hidden");
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
                      mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaAcademicoEdit">' +
                      '<span aria-hidden="true">&times;</span>' +
                      '</button>';
                      $("#erroresEditAcademico").html(mensaje);
                      $("#erroresEditAcademico").css("display","flex");
                      $("#modificarAcademico").attr("disabled",false);
                      $("#cancelarAcademicoEdit").attr("disabled",false);
                      $("#loadingSAcademicoEdit").css("visibility","hidden");
                  }
              }); 
      });
      
    $(document).on("click", "#generarAcademicoNuevo", function () {
      $("#agregarAcademicoModal").modal("show");
    });

    $(document).on("click", "#generarExperienciaNuevo", function () {
      $("#agregarExperienciaModal").modal("show");
    });

    $(document).on("click", "#info-tab", function () {
      $("#modificarCandidato").css('display','inline-flex');   
      $("#generarExperienciaNuevo").css('display','none'); 
      $("#generarAcademicoNuevo").css('display','none');
      $("#generarProcesoNuevo").css('display','none');
    });

    
    $(document).on("click", "#academico-tab", function () {
      $("#modificarCandidato").css('display','none');   
      $("#generarExperienciaNuevo").css('display','none');
      $("#generarAcademicoNuevo").css('display','inline-flex');
      $("#generarProcesoNuevo").css('display','none');

      let id = $("#idAplicanteEdit").val().trim();
      cargarAcademico(id);
        
    });

    $(document).on("click", "#experiencia-tab", function () {
      $("#modificarCandidato").css('display','none');   
      $("#generarExperienciaNuevo").css('display','inline-flex');
      $("#generarAcademicoNuevo").css('display','none');
      $("#generarProcesoNuevo").css('display','none');

      let id = $("#idAplicanteEdit").val().trim();
      cargarExperience(id);
        
    });

    $(document).on("click", "#proceso-tab", function () {
      $("#modificarCandidato").css('display','none');   
      $("#generarExperienciaNuevo").css('display','none');
      $("#generarAcademicoNuevo").css('display','none');
      $("#generarProcesoNuevo").css('display','inline-flex');

      let id = $("#idAplicanteEdit").val().trim();
      cargarProceso(id);
        
    });

    function cargarAcademico(id){
      $.ajax({
            type: "POST",
            dataType: 'JSON',
            data: { id: id, "_token": "{{ csrf_token() }}" },
            url: "applicant.getApplicantAcademic",
            success: function(msg){ 
              //console.log(msg);
              
              $("#table-academico").html(msg);
            
            }
        });
    }

    function cargarExperience(id){
      $.ajax({
            type: "POST",
            dataType: 'JSON',
            data: { id: id, "_token": "{{ csrf_token() }}" },
            url: "applicant.getApplicantExperience",
            success: function(msg){ 
              //console.log(msg);
              
              $("#table-experience").html(msg);
            
            }
        });
    }

    let field1, field2, field3, field4, field5, field6;
    function cargarProceso(id){
      $("#hideProcesoDiv").css("visibility",'hidden');
      $.ajax({
            type: "POST",
            dataType: 'JSON',
            data: { id: id, "_token": "{{ csrf_token() }}" },
            url: "processapplicantdataget",
            success: function(msg){ 
              //console.log(msg);
              
              if(msg.estatus_op == 1){
                    $("#namePosition").val(msg.nombre_puesto);
                    $("#duracion").val(msg.duracion);
                    $("#cantidadfiltros").val(msg.cantidadfiltros);
                    $("#niveles_flitro").val(msg.niveles_flitro);
                    $("#idVacanteEdit").val(msg.vacantes_id);

                    if(msg.entrevista == 1){
                      $("#field1").css("display", "flex");
                      field1 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.entrevistaCV == 1){
                          $("#entrevista1").prop("checked", true);
                        }
                        else{
                          $("#entrevista2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field1").css("display", "none");
                      field1 = 0;
                      $("#entrevista1").prop("checked", false);
                      $("#entrevista2").prop("checked", false);
                    }

                    if(msg.pruebatecnica == 1){
                      $("#field2").css("display", "flex");
                      field2 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.pruebatecnicaCV == 1){
                          $("#pruebat1").prop("checked", true);
                        }
                        else{
                          $("#pruebat2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field2").css("display", "none");
                      field2 = 0;
                      $("#pruebat1").prop("checked", false);
                      $("#pruebat2").prop("checked", false);
                    }

                    if(msg.pruebapsicometrica == 1){
                      $("#field3").css("display", "flex");
                      field3 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.pruebapsicometricaCV == 1){
                          $("#pruebap1").prop("checked", true);
                        }
                        else{
                          $("#pruebap2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field3").css("display", "none");
                      field3 = 0;

                      $("#pruebap1").prop("checked", false);
                      $("#pruebap2").prop("checked", false);
                    }

                    if(msg.referencias == 1){
                      $("#field4").css("display", "flex");
                      field4 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.referenciasCV == 1){
                          $("#referencias1").prop("checked", true);
                        }
                        else{
                          $("#referencias2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field4").css("display", "none");
                      field4 = 0;

                      $("#referencias1").prop("checked", false);
                      $("#referencias2").prop("checked", false);
                    }

                    if(msg.entrevista_tecnica == 1){
                      $("#field5").css("display", "flex");
                      field5 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.entrevista_tecnicaCV == 1){
                          $("#entrevista_tecnica1").prop("checked", true);
                        }
                        else{
                          $("#entrevista_tecnica2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field5").css("display", "none");
                      field5 = 0;

                      $("#entrevista_tecnica1").prop("checked", false);
                      $("#entrevista_tecnica2").prop("checked", false);
                    }

                    if(msg.estudio_socioeconomico == 1){
                      $("#field6").css("display", "flex");
                      field6 = 1;

                      if(msg.estatus_candidato_vacante == 1){
                        if(msg.estudio_socioeconomicoCV == 1){
                          $("#estudio_socioeconomico1").prop("checked", true);
                        }
                        else{
                          $("#estudio_socioeconomico2").prop("checked", true);
                        }
                      }
                    }
                    else{
                      $("#field6").css("display", "none");
                      field6 = 0;

                      $("#estudio_socioeconomico1").prop("checked", false);
                      $("#estudio_socioeconomico2").prop("checked", false);
                    }

                    let true_estatus;
                    if(msg.estatus == 1){ true_estatus = 4; }
                    if(msg.estatus == 2){ true_estatus = 2; }
                    if(msg.estatus == 0){ true_estatus = 3; }
                    if(msg.estatus == 3){ true_estatus = 5; }
                    $("#estatus_candidato").val(true_estatus);


                    if(msg.estatus != 2){
                      $(".classentrevista").prop("disabled", true);
                      $(".classpruebat").prop("disabled", true);
                      $(".classpruebap").prop("disabled", true);
                      $(".classreferencias").prop("disabled", true);
                      $(".classestudio_socioeconomico").prop("disabled", true);
                      $(".classentrevista_tecnica").prop("disabled", true);
                      $("#estatus_candidato").prop("disabled", true);
                    }
                    else{
                      $(".classentrevista").prop("disabled", false);
                      $(".classpruebat").prop("disabled", false);
                      $(".classpruebap").prop("disabled", false);
                      $(".classreferencias").prop("disabled", false);
                      $(".classestudio_socioeconomico").prop("disabled", false);
                      $(".classentrevista_tecnica").prop("disabled", false);
                      $("#estatus_candidato").prop("disabled", false);
                    }

                    $("#hideProcesoDiv").css("visibility",'visible');
              }
              if(msg.estatus_op == 5){
                Swal.fire({
                  icon: 'warning',
                  html:
                    '<b>Alerta</b><br> ' +
                    'No se han dado de alta los datos del proceso para la vacante asignada.',
                  showCloseButton: true,
                  showCancelButton: false,
                  focusConfirm: false,
                  showConfirmButton: false
                });
                $( "#info-tab" ).trigger( "click" );
              }
              if(msg.estatus_op == 0){
                Swal.fire({
                  icon: 'warning',
                  html:
                    '<b>Alerta</b><br> ' +
                    'Este candidato no tiene asignado ningún proceso de reclutamiento.',
                  showCloseButton: true,
                  showCancelButton: false,
                  focusConfirm: false,
                  showConfirmButton: false
                });
                $( "#info-tab" ).trigger( "click" );
              }
            
            }
        });
    }

    $("#generarProcesoNuevo").click(function(){

      let idAplicante = $("#idAplicanteEdit").val().trim();
      let entrevista = 0, prueba_tecnica = 0, prueba_psicometrica = 0;
      let referencia = 0, entrevista_tecnica = 0, estudio_socioeconomico = 0;
      let vacante_id = $("#idVacanteEdit").val().trim();    

      if(field1 == 1){
        if(document.getElementById('entrevista1').checked) {
            entrevista = 1;
        } else {
            estudio = 0;
        }
      }

      if(field2 == 1){
        if(document.getElementById('pruebat1').checked) {
            prueba_tecnica = 1;
        } else {
            prueba_tecnica = 0;
        }
      }

      if(field3 == 1){
        if(document.getElementById('pruebap1').checked) {
            prueba_psicometrica = 1;
        } else {
            prueba_psicometrica = 0;
        }
      }

      if(field4 == 1){
        if(document.getElementById('referencias1').checked) {
            referencia = 1;
        } else {
            referencia = 0;
        }
      }

      if(field5 == 1){
        if(document.getElementById('entrevista_tecnica1').checked) {
            entrevista_tecnica = 1;
        } else {
            entrevista_tecnica = 0;
        }
      }

      if(field6 == 1){
        if(document.getElementById('estudio_socioeconomico1').checked) {
            estudio_socioeconomico = 1;
        } else {
            estudio_socioeconomico = 0;
        }
      }

      let estatus_candidato = $("#estatus_candidato").val();

      if(estatus_candidato == '' || estatus_candidato == null){
          Lobibox.notify("warning", {
            size: "mini",
            rounded: true,
            delay: 3000,
            delayIndicator: false,
            position: "center top",
            msg: "Selecciona el estatus del candidato.",
          });

          return;
      }

      Swal.fire({
          title: 'Se cambiará el estatus de este candidato, ¿Quieres proceder?',
          showCancelButton: true,
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Aceptar',
          reverseButtons : true,
        }).then((result) => {

        if (result.isConfirmed) {

          $("#generarProcesoNuevo").attr("disabled",true);
          $("#cancelarCandidatoEdit").attr("disabled",true);
          $("#loadingSProcess").css("visibility","visible");

          saveApplicant(entrevista, prueba_tecnica, prueba_psicometrica,
                      referencia, entrevista_tecnica, estudio_socioeconomico,
                      estatus_candidato, vacante_id, idAplicante);

            

          } else if (result.isDenied) {
              
          }
        });


      
/*
      let estatus_candidato;
      if(document.getElementById('estatus_candidato_0').checked) estatus_candidato = 0;
      if(document.getElementById('estatus_candidato_1').checked) estatus_candidato = 1;
      if(document.getElementById('estatus_candidato_2').checked) estatus_candidato = 2;

      if(document.getElementById('estatus_candidato_0').checked) {

            Swal.fire({
              title: 'Al rechazar este candidato, quedará libre para aplicar a otros requerimientos, ¿Quieres proceder?',
              showCancelButton: true,
              cancelButtonText: 'Cancelar',
              confirmButtonText: 'Aceptar',
              reverseButtons : true,
            }).then((result) => {

            if (result.isConfirmed) {


              saveApplicant(entrevista, prueba_tecnica, prueba_psicometrica,
                         referencia, entrevista_tecnica, estudio_socioeconomico,
                         estatus_candidato, vacante_id, idAplicante);

                

              } else if (result.isDenied) {
                  
              }
            });
      } 
      else{

        saveApplicant(entrevista, prueba_tecnica, prueba_psicometrica,
                         referencia, entrevista_tecnica, estudio_socioeconomico,
                         estatus_candidato, vacante_id, idAplicante);
            
      }*/

  });

  function saveApplicant(entrevista, prueba_tecnica, prueba_psicometrica,
                         referencia, entrevista_tecnica, estudio_socioeconomico,
                         estatus_candidato, vacante_id, idAplicante){
      
      $.ajax({
          type: "GET",
          data: { entrevista: entrevista, 
                  prueba_tecnica: prueba_tecnica, 
                  prueba_psicometrica: prueba_psicometrica,
                  referencia: referencia, 
                  entrevista_tecnica: entrevista_tecnica, 
                  estudio_socioeconomico: estudio_socioeconomico,
                  estatus_candidato: estatus_candidato,
                  vacante_id: vacante_id,
                  candidato_id: idAplicante,
                  "_token": "{{ csrf_token() }}" },
          dataType: 'JSON',
          url: "/addcandidatovacante/",
          success: function(msg){ 
          //console.log(msg);
            if(msg == '1'){

                Lobibox.notify("success", {
                size: "mini",
                rounded: true,
                delay: 3000,
                delayIndicator: false,
                position: "center top",
                msg: "Información del proceso guardada.",
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

            $("#generarProcesoNuevo").attr("disabled",false);
            $("#cancelarCandidatoEdit").attr("disabled",false);
            $("#loadingSProcess").css("visibility","hidden");
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
              mensaje = mensaje + '<button type="button" class="close without-btn" data-dismiss="alert" aria-label="Close" id="cerrarAlertaAcademicoEdit">' +
              '<span aria-hidden="true">&times;</span>' +
              '</button>';
              /*$("#erroresEditAcademico").html(mensaje);
              $("#erroresEditAcademico").css("display","flex");*/
              $("#generarProcesoNuevo").attr("disabled",false);
              $("#cancelarCandidatoEdit").attr("disabled",false);
              $("#loadingSProcess").css("visibility","hidden");
          }
      }); 
      

  }

    $(document).on("click", ".editExperience", function () {
      let id = this.id;
      
      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { "_token": "{{ csrf_token() }}" },
          url: "/applicantexperience/" + id,
          success: function(msg){ 
            //console.log(msg);
            
            $("#idExperienciaEdit").val(msg.id);
            $("#puestoEdit").val(msg.puesto);
            $("#empresaEdit").val(msg.empresa);
            $("#detalles_puestoEdit").val(msg.detalles_puesto);
            $("#fechainiEdit").val(msg.fechaini);
            $("#fechafinEdit").val(msg.fechafin);

            if(msg.puesto_actual == 0){
              $('#puesto_actualEdit').prop('checked', false);
            }
            if(msg.puesto_actual == 1){
              $('#puesto_actualEdit').prop('checked', true);
            }
            
            $("#editarExperienciaModal").modal("show");
            
          }
      }); 
    });
    
    $(document).on("click", ".deleteExperience", function () {
        let id = this.id;

        Swal.fire({
        title: '¿Quieres eliminar esta experiencia?',
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
                url: "/applicantexperience/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Experiencia eliminada.",
                    });
                    $('#table_' + id).remove();
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

    $(document).on("click", ".editAcademico", function () {
      let id = this.id;
      
      $.ajax({
          type: "GET",
          dataType: 'JSON',
          data: { "_token": "{{ csrf_token() }}" },
          url: "/applicantacademico/" + id,
          success: function(msg){ 
            //console.log(msg);
            
            $("#idAcademicoEdit").val(msg.id);
            $("#escolaridadEdit").html(msg.select_escolaridad);
            $("#institucionEdit").val(msg.institucion);
            $("#titulo_carreraEdit").val(msg.titulo_carrera);
            $("#anioiniEdit").val(msg.anioini);
            $("#aniofinEdit").val(msg.aniofin);

            if(msg.estudio == 0){
              $('#estudioEdit').prop('checked', false);
            }
            if(msg.estudio == 1){
              $('#estudioEdit').prop('checked', true);
            }
            
            $("#editAcademicoModal").modal("show");
            
          }
      }); 
    });


    $(document).on("click", ".deleteAcademico", function () {
        let id = this.id;

        Swal.fire({
        title: '¿Quieres eliminar este estudio?',
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
                url: "/applicantacademico/" + id,
                success: function(msg){ 
                if(msg == '1'){
                    Lobibox.notify("success", {
                        size: "mini",
                        rounded: true,
                        delay: 3000,
                        delayIndicator: false,
                        position: "center top",
                        msg: "Estudio eliminado.",
                    });
                    $('#table_' + id).remove();
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

    $(document).on("click", "#cerrarAlerta", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#generarUsuarioNuevo", function () {
      $("#erroresAgregar").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaEditar", function () {
      $("#erroresAgregarEditar").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaExperiencia", function () {
      $("#erroresAgregarExperiencia").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaExperienciaEditar", function () {
      $("#erroresEditarExperiencia").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaAcademico", function () {
      $("#erroresAgregarAcademico").css('display','none');
    });

    $(document).on("click", "#cerrarAlertaAcademicoEdit", function () {
      $("#erroresEditAcademico").css('display','none');
    });

    $(document).ready(function(){
        $('#code,#codeEdit').keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });
    });
  </script>
@endpush
