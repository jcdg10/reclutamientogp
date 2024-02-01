<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Datatables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\ServicioRequerido;
use App\Models\CandidatosProgreso;
use App\Models\Requirement\FinalData;
use App\Models\Requirement\PuestoData;
use App\Models\Requirement\GeneralData;
use App\Models\Requirement\ProcesoData;
use App\Models\Requirement\AcademicData;
use App\Models\Requirement\PersonalData;
use App\Models\Requirement\EconomicaData;
use Illuminate\Support\Facades\Validator;
use App\Models\Requirement\AdicionalesData;
use App\Models\Requirement\AcademicIdiomsData;
use App\Models\Requirement\AcademicCertificadosData;

class RequestController extends Controller
{
    public function index()
    {
        if(auth()->user()->roles_id != 3){
            $requerimientos = DB::table('vacantes as v')
            ->selectRaw('v.id, c.nombres as nombre_cliente, v.estatus, v.estatus_vacante as estatus_vacante_in, ev.estatus as estatus_vacante_or, ev.color, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fecha, v.fecha_vacante_cubierta, dg.puesto, v.reclutador_id, u.name as namereclutador')
            ->join('cliente as c','c.id', '=','v.cliente_id')
            ->leftJoin('estatus_vacantes as ev','ev.id', '=','v.estatus_vacante')
            ->leftJoin('datosgenerales as dg', 'dg.vacantes_id', '=', 'v.id')
            ->leftJoin('users as u', 'u.id', '=', 'v.reclutador_id')
            ->orderBy("v.id","DESC")
            ->get();
        }
        else{
            $requerimientos = DB::table('vacantes as v')
            ->selectRaw('v.id, c.nombres as nombre_cliente, v.estatus, v.estatus_vacante as estatus_vacante_in, ev.estatus as estatus_vacante_or, ev.color, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fecha, v.fecha_vacante_cubierta, dg.puesto, v.reclutador_id, u.name as namereclutador')
            ->join('cliente as c','c.id', '=','v.cliente_id')
            ->leftJoin('estatus_vacantes as ev','ev.id', '=','v.estatus_vacante')
            ->leftJoin('datosgenerales as dg', 'dg.vacantes_id', '=', 'v.id')
            ->leftJoin('users as u', 'u.id', '=', 'v.reclutador_id')
            ->where('v.reclutador_id','=',auth()->user()->id)
            ->where('v.estatus_vacante','<>',2)
            ->orderBy("v.id","DESC")
            ->get();
        }

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 4)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                  ->orWhere('permiso', '=', 4)
                  ->orWhere('permiso', '=', 6);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;
        $GLOBALS["validar"] = $roles[2]->permitido;


        return Datatables()->of($requerimientos)
        ->addIndexColumn()
        ->addColumn('state', function($requerimientos){

            if($requerimientos->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($requerimientos->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('estatus_vacante', function($requerimientos){

            if(auth()->user()->roles_id == 4){
                if($requerimientos->estatus_vacante_in == 1){
                    $state = '<div class="badge bg-'.$requerimientos->color.'-4 hp-bg-dark-'.$requerimientos->color.' text-'.$requerimientos->color.' border-'.$requerimientos->color.'">Nuevo requerimiento</div>';
                }
                else{
                    $state = '<div class="badge bg-'.$requerimientos->color.'-4 hp-bg-dark-'.$requerimientos->color.' text-'.$requerimientos->color.' border-'.$requerimientos->color.'">'.$requerimientos->estatus_vacante_or.'</div>';
                }
                
            }
            else{
                $state = '<div class="badge bg-'.$requerimientos->color.'-4 hp-bg-dark-'.$requerimientos->color.' text-'.$requerimientos->color.' border-'.$requerimientos->color.'">'.$requerimientos->estatus_vacante_or.'</div>';
            }
            
    
            return $state;
        })
        ->addColumn('action', function($requerimientos){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';

            if(auth()->user()->roles_id == 3){
                $btn .=  '<img src="'.url('img/eye.svg').'"  class="ver_editar imgEdit toggle" id="'.$requerimientos->id.'" data-toggle="tooltip" data-placement="top" title="Ver" style="margin-right:9px;" />';
            }

            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1 ||
            (($requerimientos->estatus_vacante_in == 3 || $requerimientos->estatus_vacante_in == 4) 
            && ($requerimientos->reclutador_id != NULL || $requerimientos->reclutador_id != ''))){

                                    if(($requerimientos->estatus_vacante_in == 3 || $requerimientos->estatus_vacante_in == 4) 
                                    && ($requerimientos->reclutador_id != NULL || $requerimientos->reclutador_id != '')){
                                        $btn.= '<span class="exportPDF" id="'.$requerimientos->id.'" style="position:relative; right:6px;" ><img src="'.url('img/pdf.png').'" class="imgEdit toggle" data-toggle="tooltip" data-placement="top" title="PDF" /></span>';
                                    }
                                    
                                    if($GLOBALS["editar"] == 1){
                                        $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$requerimientos->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                                    }

                                    if($GLOBALS["eliminar"] == 1){
                                        if($requerimientos->estatus == 1){
                                            $btn.='<input type="checkbox" id="switch_'.$requerimientos->id.'" /><label class="desactivar" id="lbl_'.$requerimientos->id.'" for="switch_'.$requerimientos->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar" >Toggle</label>';
                                        }
                                        if($requerimientos->estatus == 0){
                                            $btn.='<input type="checkbox" id="switch_'.$requerimientos->id.'" checked /><label class="activar" id="lbl_'.$requerimientos->id.'" for="switch_'.$requerimientos->id.'" data-toggle="tooltip" data-placement="top" title="Activar" >Toggle</label>';
                                        }
                                    }

                                    if($GLOBALS["validar"] == 1){ 
                                        $disabled = "";
                                        if($requerimientos->estatus_vacante_in != 3 && $requerimientos->estatus_vacante_in != 2){
                                            
                                            $btn .= '<span style="position: relative; left: 10px;"><button type="button" class="btn btn-success aceptarRequerimiento" style="padding:0.1rem 0.4rem !important;margin-right:2px;" id="aceptar_'.$requerimientos->id.'" data-toggle="tooltip" data-placement="top" title="Aceptar" '.$disabled.'>✓</button>
                                            <button type="button" class="btn btn-danger rechazarRequerimiento" style="padding:0.1rem 0.37rem !important;" id="rechazar_'.$requerimientos->id.'" data-toggle="tooltip" data-placement="top" title="Rechazar" >✕</button></span>';
                                        }
                                    
                                    }

                                $btn.=  '</span>';
            }
        
            return $btn;
        })
        ->rawColumns(['estatus_vacante','state','action'])
        ->make(true);    

        //return Datatables::of($users)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRequest()
    {
        $roles = DB::table('permisos')
            ->where('rol_id','=', auth()->user()->roles_id)
            ->where('modulo_id','=', 4)
            ->where(function ($query) {
                $query->where('permiso', '=', 1)
                    ->orWhere('permiso', '=', 2);
            })
            ->get();

        $clients = Client::orderBy('nombres','ASC')
        ->get()->where('estatus','=','1');
        $estado_civiles = DB::table('estados_civiles')->get();
        $request_service = ServicioRequerido::orderBy('servicio','ASC')->get()
        ->where('estatus','=','1');
        $modalidad = DB::table('modalidad')->get();
        
        if($roles[0]->permitido == 1){
            return view('vacant.index')->with(['clientes'=>$clients,
                                                'estado_civiles'=>$estado_civiles,
                                                'request_service'=>$request_service,
                                                'modalidad'=>$modalidad,
                                                'roles'=>$roles]);
        }
        else{
            return redirect('/');
        }
        
    }

    public function store(Request $request)
    {   
        //if(auth()->user()->responsible == 1){
            $validated = $request->validate([
                'cliente' => ['required'
                            ]
            ]);

            $requerimiento = new Requerimiento();
            $requerimiento->cliente_id = $request->cliente;
            $requerimiento->fechaalta = Carbon::now();
            $requerimiento->fechamod = Carbon::now();
            $requerimiento->estatus = 1;
            $requerimiento->estatus_vacante = 1;
            
            if($requerimiento->save()){
                $array[0] = 1;
                $array[1] = $requerimiento->id;
                return $array;
            }
            else{
                $array[0] = 0;
                return $array;
            }
        /*}
        else{
            return 2;
        }*/
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requerimiento = Requerimiento::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/
        $client = Client::orderBy('nombres','ASC')
        ->get()->where('estatus','=','1');

        $clientes = "<option value=''>Selecciona un cliente</option>";
        foreach($client as $c){
            $clientes .= "<option value='".$c->id."' ";

            if($c->id == $requerimiento->cliente_id){
                $clientes .= "selected";
            }
            
            $clientes .= ">".$c->nombres."</option>";
        }

        $requerimiento->client_select = $clientes;

        return response()->json(
            $requerimiento
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {     
        $validated = $request->validate([
            'cliente' => ['required'
                        ]
        ]);

        $requerimiento = Requerimiento::findOrFail($id);
        $requerimiento->vacante = $request->vacante;
        $requerimiento->cliente_id = $request->cliente;
        $requerimiento->detalle_vacante = $request->detalle_vacante;
        $requerimiento->fechamod = Carbon::now();

        if($requerimiento->estatus_vacante == 2){
            $requerimiento->estatus_vacante = 1;
        }

        if($requerimiento->update()){
            return "1";
        }
        else{
            return "0";
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $requerimiento = Requerimiento::findOrFail($id);

            if($requerimiento->estatus == 1){
                $requerimiento->estatus = 0;
            }
            else{
                $requerimiento->estatus = 1;
            }
            

            if($requerimiento->update()){
                echo "1";
            }
            else{
                echo "0";            
            }
        }
        catch(Exception $e){
            Log::error($e);
            echo "0";
        }
    }


    public function getInfoClient($id)
    {

        $client = Client::findOrFail($id);

        $estado_f = DB::table('estados_federales')->where("id","=",$client->estado_id)
            ->get();

            

        $num_ext = " ";
        if($client->num_ext != ""){
            $num_ext = " ".$client->num_ext;
        }

        $estado = " ";
        foreach($estado_f as $ef){
            if($ef->estado != ""){
                $estado = ", ".$ef->estado;
            }
        }
        

        $client->direccion = $client->calle." ".$client->num_int.$num_ext." ".$client->ciudad.$estado." ".$client->codigo_postal;

        return response()->json(
            $client
        );
    }

    public function generalData(Request $request)
    {   
        $validated = $request->validate([
            'position' => ['required',
                        'max:100'
            ],
            'numVacant' => ['required'
            ],
            'requestDate' => ['required'
            ],
        ]);

        if($request->idGeneralUnico == ''){
            $generaldata = new GeneralData();
            $generaldata->vacantes_id = $request->idRequerimiento;
            $generaldata->ejecutivoen = $request->executiveInCharge;
        }
        else{
            $generaldata = GeneralData::findOrFail($request->idGeneralUnico);
        }

        
        $generaldata->puesto = $request->position;
        $generaldata->novacantes = $request->numVacant;
        $generaldata->fechasolicitud = $request->requestDate;
        $generaldata->serviciore = $request->requestService;
        $generaldata->tiemasignacion = $request->asignmentTime;
        $generaldata->cantidadtiempo = $request->time;
        $generaldata->modalidad = $request->modality;
        $generaldata->horario_inicio = $request->timeBegin;
        $generaldata->horario_fin = $request->timeEnd;
        
        if($generaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function personalData(Request $request)
    {   
        $validated = $request->validate([
            'rangeAge' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPersonal == ''){
            $personaldata = new PersonalData();
            $personaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $personaldata = PersonalData::findOrFail($request->idPersonal);
        }
        
        $personaldata->rangoedad = $request->rangeAge;
        $personaldata->sexo = $request->sex;
        $personaldata->estadocivil = $request->civilstate;
        $personaldata->lugarresidencia = $request->residencePlace;
        
        if($personaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function academicData(Request $request)
    {   
            
        $validated = $request->validate([
            'escolaridad' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idAcademico == ''){
            $academicdata = new AcademicData();
            $academicdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $academicdata = AcademicData::findOrFail($request->idAcademico);
        }
        
        $academicdata->escolaridad = $request->escolaridad;
        

        if($academicdata->save()){

            if($request->idAcademico == ''){
                $idAcademico = $academicdata->id;
            }
            else{
                $idAcademico = $request->idAcademico;

                $result=AcademicCertificadosData::where('datosacademicos_id','=',$request->idAcademico)->delete();
                $result2=AcademicIdiomsData::where('datosacademicos_id','=',$request->idAcademico)->delete();
            }


            foreach($request->certificado as $cert){

                if(trim($cert) != ''){
                    $certificate = new AcademicCertificadosData();
                    $certificate->certificado = $cert;
                    $certificate->datosacademicos_id = $idAcademico;
                    $certificate->save();
                }
                
            }

            foreach($request->idiom as $idiom){

                if(trim($idiom) != ''){
                    $idioma = new AcademicIdiomsData();
                    $idioma->idioma = $idiom;
                    $idioma->datosacademicos_id = $idAcademico;
                    $idioma->save();
                }
                
            }

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
    }


    public function jobData(Request $request)
    {   
        $validated = $request->validate([
            'experience' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPuesto == ''){
            $jobdata = new PuestoData();
            $jobdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $jobdata = PuestoData::findOrFail($request->idPuesto);
        }
        
        $jobdata->experiencia = $request->experience;
        $jobdata->actividades = $request->activities;
        $jobdata->conocimientos_tecnicos = $request->technical_knowledge;
        $jobdata->competencias_necesarias = $request->necessary_skills;
        
        if($jobdata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function additionalData(Request $request)
    {   
        if($request->desplazarse == 3){
            $desplazarse_motivo = $request->desplazarse_motivo; 
        }
        else{
            $desplazarse_motivo = '';
        }

        if($request->viajar == 3){
            $viajar_motivo = $request->viajar_motivo; 
        }
        else{
            $viajar_motivo = '';
        }

        if($request->disponibilidad_horario == 3){
            $disponibilidad_horario_motivo = $request->disponibilidad_horario_motivo; 
        }
        else{
            $disponibilidad_horario_motivo = '';
        }

        if($request->personal_cargo == 1){
            $num_personas_cargo = $request->num_personas_cargo; 
        }
        else{
            $num_personas_cargo = 0;
        }
        
        if($request->idAdicional == ''){
            $additionaldata = new AdicionalesData();
            $additionaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $additionaldata = AdicionalesData::findOrFail($request->idAdicional);
        }
        
        $additionaldata->desplazarse = $request->desplazarse;
        $additionaldata->desplazarse_motivo = $desplazarse_motivo;
        $additionaldata->viajar = $request->viajar;
        $additionaldata->viajar_motivo = $viajar_motivo;
        $additionaldata->disponibilidad_horario = $request->disponibilidad_horario;
        $additionaldata->disponibilidad_horario_motivo = $disponibilidad_horario_motivo;
        $additionaldata->personal_cargo = $request->personal_cargo;
        $additionaldata->num_personas_cargo = $num_personas_cargo;
        $additionaldata->persona_reporta = $request->persona_reporta;
        $additionaldata->equipo_computo = $request->equipo_computo;

        if($additionaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function economicData(Request $request)
    {   
        $validated = $request->validate([
            'esquemacontratacion' => ['required',
                        'max:100'
            ],
            'montominimo' => ['required'],
            'montomaximo' => ['required']
        ]);

        if($request->idEconomico == ''){
            $economicdata = new EconomicaData();
        }
        else{
            $economicdata = EconomicaData::findOrFail($request->idEconomico);
        }

        $montominimo = str_replace("$", "", $request->montominimo);
        $montominimo = str_replace(",", "", $montominimo);
        $montomaximo = str_replace("$", "", $request->montomaximo);
        $montomaximo = str_replace(",", "", $montomaximo);
        
        $economicdata->esquemacontratacion = $request->esquemacontratacion;
        $economicdata->tiposalario = $request->tiposalario;
        $economicdata->montominimo = $montominimo;
        $economicdata->montomaximo = $montomaximo;
        $economicdata->jornadalaboral = $request->jornadalaboral;
        $economicdata->prestaciones_beneficios = $request->prestaciones_beneficios;

        if($request->idEconomico == ''){
            $economicdata->vacantes_id = $request->idRequerimiento;
        }

        if($economicdata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function processData(Request $request)
    {   
        $validated = $request->validate([
            'duracion' => ['required',
                        'max:100'
            ],
        ]);

        if($request->idProceso == ''){
            $processdata = new ProcesoData();
        }
        else{
            $processdata = ProcesoData::findOrFail($request->idProceso);
        }            
        
        $processdata->duracion = $request->duracion;
        $processdata->cantidadfiltros = $request->cantidadfiltros;
        $processdata->niveles_flitro = $request->niveles_flitro;
        $processdata->entrevista = $request->entrevista;
        $processdata->pruebatecnica = $request->pruebat;
        $processdata->pruebapsicometrica = $request->pruebap;
        $processdata->referencias = $request->referencias;
        $processdata->entrevista_tecnica = $request->entrevista_tecnica;
        $processdata->estudio_socioeconomico = $request->estudio_socioeconomico;

        if($request->idProceso == ''){
            $processdata->vacantes_id = $request->idRequerimiento;
        }

        if($processdata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function finalData(Request $request)
    {   
        if($request->idFinal == ''){
            $finaldata = new FinalData();
        }
        else{
            $finaldata = FinalData::findOrFail($request->idFinal);
        }
        
        $finaldata->razonnocontratacion = $request->razonnocontratacion;
        $finaldata->fechacontratacion = $request->fechacontratacion;
        if($request->idFinal == ''){
            $finaldata->vacantes_id = $request->idRequerimiento;
        }

        if($finaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function clientDataGet($id)
    {
        $requerimiento = Requerimiento::findOrFail($id);
        
        $client = Client::orderBy('nombres','ASC')
        ->where('estatus','=','1')->orWhere('id','=',$requerimiento->cliente_id)->get();

        if($requerimiento->reclutador_id == auth()->user()->id){
            $requerimiento->show_assign = 1;
        }
        else{
            $requerimiento->show_assign = 0;
        }

        $clientes = "<option value=''>Selecciona un cliente</option>";
        foreach($client as $c){
            $clientes .= "<option value='".$c->id."' ";

            if($c->id == $requerimiento->cliente_id){
                $clientes .= "selected";
            }
            
            $clientes .= ">".$c->nombres."</option>";
        }

        $requerimiento->client_select = $clientes;

        return response()->json(
            $requerimiento
        );
    }

    public function clientDataEdit(Request $request)
    {   
        //if(auth()->user()->responsible == 1){    
            $validated = $request->validate([
                'cliente' => ['required'
                            ]
            ]);

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            $requerimiento->cliente_id = $request->cliente;
            $requerimiento->fechamod = Carbon::now();

            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
            }

            if($requerimiento->update()){
                return "1";
            }
            else{
                return "0";
            }
        /*}
        else{
            return 2;
        }*/
        
        
    }

    public function generalDataGet($id)
    {   
        $generalData = GeneralData::where("vacantes_id", "=", $id)->firstOrFail();

        $request_service = ServicioRequerido::orderBy('servicio','ASC')
        ->where('estatus','=','1')->orWhere("id","=",$generalData->serviciore)->get();
        $modalidad = DB::table('modalidad')->get();

        $request_servicec = "";
        foreach($request_service as $rs){
            $request_servicec .= "<option value='".$rs->id."' ";

            if($rs->id == $generalData->serviciore){
                $request_servicec .= "selected";
            }
            
            $request_servicec .= ">".$rs->servicio."</option>";
        }

        $generalData->require_service_select = $request_servicec;

        $modalidad_c = "";
        foreach($modalidad as $m){
            $modalidad_c .= "<option value='".$m->id."' ";

            if($m->id == $generalData->modalidad){
                $modalidad_c .= "selected";
            }
            
            $modalidad_c .= ">".$m->modalidad."</option>";
        }
        $generalData->modalidad_select = $modalidad_c;

        $executive = User::where("id","=",$generalData->ejecutivoen)->firstOrFail();
        $generalData->ejecutivoen = $executive->name;

        return response()->json(
            $generalData
        );
        
        
    }

    public function generalDataEdit(Request $request)
    {   

        $validated = $request->validate([
            'position' => ['required',
                        'max:100'
            ],
            'numVacant' => ['required'
            ],
            'requestDate' => ['required'
            ],
        ]);

        if($request->idGeneralUnico == ''){
            $generaldata = new GeneralData();
            $generaldata->vacantes_id = $request->idRequerimiento;
            $generaldata->ejecutivoen = $request->executiveInCharge;
        }
        else{
            $generaldata = GeneralData::findOrFail($request->idGeneralUnico);
        }

        
        $generaldata->puesto = $request->position;
        $generaldata->novacantes = $request->numVacant;
        $generaldata->fechasolicitud = $request->requestDate;
        $generaldata->serviciore = $request->requestService;
        $generaldata->tiemasignacion = $request->asignmentTime;
        $generaldata->cantidadtiempo = $request->time;
        $generaldata->modalidad = $request->modality;
        $generaldata->horario_inicio = $request->timeBegin;
        $generaldata->horario_fin = $request->timeEnd;

                

        
        if($generaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }


    public function personalDataGet($id)
    {   
        $personalData = PersonalData::where("vacantes_id", "=", $id)->firstOrFail();

        $estado_civiles = DB::table('estados_civiles')->get();

        $estado_civiles_c = "";
        foreach($estado_civiles as $ec){
            $estado_civiles_c .= "<option value='".$ec->id."' ";

            if($ec->id == $personalData->estadocivil){
                $estado_civiles_c .= "selected";
            }
            
            $estado_civiles_c .= ">".$ec->estados_civiles."</option>";
        }

        $personalData->estados_civiles_select = $estado_civiles_c; 

        if($personalData->sexo == 1){
            $sexo = '<option value="1" selected>Femenino</option>';
        }
        else{
            $sexo = '<option value="1">Femenino</option>';
        }

        if($personalData->sexo == 2){
            $sexo .= '<option value="2" selected>Masculino</option>';
        }
        else{
            $sexo .= '<option value="2">Masculino</option>';
        }

        if($personalData->sexo == 3){
            $sexo .= '<option value="3" selected>Indiferente</option>';
        }
        else{
            $sexo .= '<option value="3">Indiferente</option>';
        }
    
        $personalData->sexo_select = $sexo;

        return response()->json(
            $personalData
        );
        
        
    }

    public function personalDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'rangeAge' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPersonal == ''){
            $personaldata = new PersonalData();
            $personaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $personaldata = PersonalData::findOrFail($request->idPersonal);
        }
        
        $personaldata->rangoedad = $request->rangeAge;
        $personaldata->sexo = $request->sex;
        $personaldata->estadocivil = $request->civilstate;
        $personaldata->lugarresidencia = $request->residencePlace;
        
        if($personaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function academicDataGet($id)
    {   
        $academicData = AcademicData::where("vacantes_id", "=", $id)->firstOrFail();

        $academicCertificadosData = AcademicCertificadosData::where("datosacademicos_id", "=", $academicData->id)->get();
        
        $academicIdiomsData = AcademicIdiomsData::where("datosacademicos_id", "=", $academicData->id)->get();

        $cert = 0;
        $certificado_c = '';
        if(count($academicCertificadosData) > 0){
            foreach($academicCertificadosData as $acd){

                if($cert == 0){
                    $certificado_c .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" >
                        <input type="text" class="form-control certificado_class" id="certificado'.$cert.'" name="certificado['.$cert.']" maxlength="100" placeholder="Certificado o curso" value="'.$acd->certificado.'">
                    </div>';
                }
                else{
                    $certificado_c .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" id="delete_'.$cert.'" >
                        <div class="row">
                            <input type="text" class="form-control certificado_class" id="certificado'.$cert.'" name="certificado['.$cert.']" maxlength="100" placeholder="Certificado o curso" value="'.$acd->certificado.'" style="width:80%;">
                            <button type="button" class="btn btn-danger btn-sm deleteCert" id="'.$cert.'" style="width:10%;margin-left:10%;">X</button>
                        </div>
                    </div>';
                }
                $cert++;

            }
        }
        $academicData->certificado_select = $certificado_c;
        $academicData->certificado_num = $cert;

        $idi = 0;
        $idioms = '';
        if(count($academicIdiomsData) > 0){
            foreach($academicIdiomsData as $aid){

                if($idi == 0){
                    $idioms .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;">
                        <input type="text" class="form-control idiom_class" id="idiom'.$idi.'" name="idiom['.$idi.']" maxlength="100" placeholder="Idioma" value="'.$aid->idioma.'">
                    </div>';
                }
                else{
                    $idioms .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" id="deleteidiom_'.$idi.'">
                        <div class="row">
                            <input type="text" class="form-control idiom_class" id="idiom'.$idi.'" name="idiom['.$idi.']" maxlength="100" placeholder="Idioma" value="'.$aid->idioma.'" style="width:80%;">
                            <button type="button" class="btn btn-danger btn-sm deleteIdiom" id="'.$idi.'" style="width:10%;margin-left:10%;">X</button>
                        </div>
                    </div>';
                }
                
                $idi++;
            }
        }
        $academicData->idiom_select = $idioms;
        $academicData->idiom_num = $idi;

        return response()->json(
            $academicData
        );
        
        
    }

    //falta
    public function academicDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'escolaridad' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idAcademico == ''){
            $academicdata = new AcademicData();
            $academicdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $academicdata = AcademicData::findOrFail($request->idAcademico);
        }
        
        $academicdata->escolaridad = $request->escolaridad;
        

        if($academicdata->save()){

            if($request->idAcademico == ''){
                $idAcademico = $academicdata->id;
            }
            else{
                $idAcademico = $request->idAcademico;

                $result=AcademicCertificadosData::where('datosacademicos_id','=',$request->idAcademico)->delete();
                $result2=AcademicIdiomsData::where('datosacademicos_id','=',$request->idAcademico)->delete();
            }


            foreach($request->certificado as $cert){

                if(trim($cert) != ''){
                    $certificate = new AcademicCertificadosData();
                    $certificate->certificado = $cert;
                    $certificate->datosacademicos_id = $idAcademico;
                    $certificate->save();
                }
                
            }

            foreach($request->idiom as $idiom){

                if(trim($idiom) != ''){
                    $idioma = new AcademicIdiomsData();
                    $idioma->idioma = $idiom;
                    $idioma->datosacademicos_id = $idAcademico;
                    $idioma->save();
                }
                
            }

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function jobDataGet($id)
    {   
        $jobData = PuestoData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $jobData
        );
        
        
    }

    public function jobDataEdit(Request $request)
    {   
            $validated = $request->validate([
                'experience' => ['required',
                            'max:100'
                ]
            ]);

            if($request->idPuesto == ''){
                $jobdata = new PuestoData();
                $jobdata->vacantes_id = $request->idRequerimiento;
            }
            else{
                $jobdata = PuestoData::findOrFail($request->idPuesto);
            }
            
            $jobdata->experiencia = $request->experience;
            $jobdata->actividades = $request->activities;
            $jobdata->conocimientos_tecnicos = $request->technical_knowledge;
            $jobdata->competencias_necesarias = $request->necessary_skills;
            
            if($jobdata->save()){

                $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
                if($requerimiento->estatus_vacante == 2){
                    $requerimiento->estatus_vacante = 1;
                    $requerimiento->update();
                }

                return 1;
            }
            else{
                return 0;
            }
            
    }

    public function additionalDataGet($id)
    {   
        $additionalData = AdicionalesData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $additionalData
        );
        
        
    }

    public function additionalDataEdit(Request $request)
    {   
            if($request->desplazarse == 3){
                $desplazarse_motivo = $request->desplazarse_motivo; 
            }
            else{
                $desplazarse_motivo = '';
            }

            if($request->viajar == 3){
                $viajar_motivo = $request->viajar_motivo; 
            }
            else{
                $viajar_motivo = '';
            }

            if($request->disponibilidad_horario == 3){
                $disponibilidad_horario_motivo = $request->disponibilidad_horario_motivo; 
            }
            else{
                $disponibilidad_horario_motivo = '';
            }

            if($request->personal_cargo == 1){
                $num_personas_cargo = $request->num_personas_cargo; 
            }
            else{
                $num_personas_cargo = 0;
            }
            
            if($request->idAdicional == ''){
                $additionaldata = new AdicionalesData();
                $additionaldata->vacantes_id = $request->idRequerimiento;
            }
            else{
                $additionaldata = AdicionalesData::findOrFail($request->idAdicional);
            }
            
            $additionaldata->desplazarse = $request->desplazarse;
            $additionaldata->desplazarse_motivo = $desplazarse_motivo;
            $additionaldata->viajar = $request->viajar;
            $additionaldata->viajar_motivo = $viajar_motivo;
            $additionaldata->disponibilidad_horario = $request->disponibilidad_horario;
            $additionaldata->disponibilidad_horario_motivo = $disponibilidad_horario_motivo;
            $additionaldata->personal_cargo = $request->personal_cargo;
            $additionaldata->num_personas_cargo = $num_personas_cargo;
            $additionaldata->persona_reporta = $request->persona_reporta;
            $additionaldata->equipo_computo = $request->equipo_computo;

            if($additionaldata->save()){

                $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
                if($requerimiento->estatus_vacante == 2){
                    $requerimiento->estatus_vacante = 1;
                    $requerimiento->update();
                }

                return 1;
            }
            else{
                return 0;
            }
            
    }

    public function economicDataGet($id)
    {   
        $economicData = EconomicaData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $economicData
        );
        
        
    }

    public function economicDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'esquemacontratacion' => ['required',
                        'max:100'
            ],
            'montominimo' => ['required'],
            'montomaximo' => ['required']
        ]);

        if($request->idEconomico == ''){
            $economicdata = new EconomicaData();
        }
        else{
            $economicdata = EconomicaData::findOrFail($request->idEconomico);
        }

        $montominimo = str_replace("$", "", $request->montominimo);
        $montominimo = str_replace(",", "", $montominimo);
        $montomaximo = str_replace("$", "", $request->montomaximo);
        $montomaximo = str_replace(",", "", $montomaximo);
        
        $economicdata->esquemacontratacion = $request->esquemacontratacion;
        $economicdata->tiposalario = $request->tiposalario;
        $economicdata->montominimo = $montominimo;
        $economicdata->montomaximo = $montomaximo;
        $economicdata->jornadalaboral = $request->jornadalaboral;
        $economicdata->prestaciones_beneficios = $request->prestaciones_beneficios;

        if($request->idEconomico == ''){
            $economicdata->vacantes_id = $request->idRequerimiento;
        }

        if($economicdata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function processDataGet($id)
    {   
        $processData = ProcesoData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $processData
        );
        
        
    }

    public function processDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'duracion' => ['required',
                        'max:100'
            ],
        ]);

        if($request->idProceso == ''){
            $processdata = new ProcesoData();
        }
        else{
            $processdata = ProcesoData::findOrFail($request->idProceso);
        }            
        
        $processdata->duracion = $request->duracion;
        $processdata->cantidadfiltros = $request->cantidadfiltros;
        $processdata->niveles_flitro = $request->niveles_flitro;
        $processdata->entrevista = $request->entrevista;
        $processdata->pruebatecnica = $request->pruebat;
        $processdata->pruebapsicometrica = $request->pruebap;
        $processdata->referencias = $request->referencias;
        $processdata->entrevista_tecnica = $request->entrevista_tecnica;
        $processdata->estudio_socioeconomico = $request->estudio_socioeconomico;

        if($request->idProceso == ''){
            $processdata->vacantes_id = $request->idRequerimiento;
        }

        if($processdata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function finalDataGet($id)
    {   
        $finalData = FinalData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $finalData
        );
        
        
    }

    public function finalDataEdit(Request $request)
    {   

        if($request->idFinal == ''){
            $finaldata = new FinalData();
        }
        else{
            $finaldata = FinalData::findOrFail($request->idFinal);
        }
        
        $finaldata->razonnocontratacion = $request->razonnocontratacion;
        $finaldata->fechacontratacion = $request->fechacontratacion;
        if($request->idFinal == ''){
            $finaldata->vacantes_id = $request->idRequerimiento;
        }

        if($finaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
        
    }

    public function getPdf(Request $request)
    {

        $clienteData = DB::table('vacantes as v')
            ->selectRaw('c.*, ef.estado')
            ->leftJoin('cliente as c', 'v.cliente_id', '=', 'c.id')
            ->leftJoin('estados_federales as ef', 'c.estado_id', '=', 'ef.id')
            ->where("v.id","=",$request->id)
            ->get();

        $generalData = DB::table('datosgenerales as dg')
            ->selectRaw('dg.puesto, dg.novacantes, DATE_FORMAT(dg.fechasolicitud, "%d-%m-%Y") as fecha, sr.servicio, dg.tiemasignacion, dg.cantidadtiempo,m.modalidad, dg.horario_inicio, dg.horario_fin,u.name as executive_name ')
            ->leftJoin('servicio_requerido as sr', 'dg.serviciore', '=', 'sr.id')
            ->leftJoin('modalidad as m', 'dg.modalidad', '=', 'm.id')
            ->leftJoin('users as u', 'dg.ejecutivoen', '=', 'u.id')
            ->where("dg.vacantes_id","=",$request->id)
            ->get();
        
        $personalData = DB::table('datospersonal as dp')
            ->selectRaw('dp.rangoedad, dp.sexo, ec.estados_civiles, dp.lugarresidencia')
            ->leftJoin('estados_civiles as ec', 'dp.estadocivil', '=', 'ec.id')
            ->where("dp.vacantes_id","=",$request->id)
            ->get();

        $puestoData = DB::table('datospuesto as dp')
            ->selectRaw('dp.experiencia, dp.actividades, dp.conocimientos_tecnicos, dp.competencias_necesarias')
            ->where("dp.vacantes_id","=",$request->id)
            ->get();

        //Academic data
        $academicData = AcademicData::where("vacantes_id", "=", $request->id)->firstOrFail();

        $academicCertificadosData = AcademicCertificadosData::where("datosacademicos_id", "=", $academicData->id)->get();
        
        $academicIdiomsData = AcademicIdiomsData::where("datosacademicos_id", "=", $academicData->id)->get();

        $certificado_c = '';
        if(count($academicCertificadosData) > 0){
            foreach($academicCertificadosData as $acd){

                    $certificado_c .= $acd->certificado.'<br>';
            }
        }
        $academicData->certificado_select = $certificado_c;
    
        $idioms = '';
        if(count($academicIdiomsData) > 0){
            foreach($academicIdiomsData as $aid){

                    $idioms .= $aid->idioma.'<br>';
            }
        }
        $academicData->idiom_select = $idioms;

        $adicionalData = DB::table('datosadicionales as da')->where("da.vacantes_id","=",$request->id)->get();

        $economicaData = DB::table('datoseconomicos as de')->where("de.vacantes_id","=",$request->id)->get();

        $procesoData = DB::table('datosproceso as dp')->where("dp.vacantes_id","=",$request->id)->get();

        $finalData = DB::table('datosfinales as df')
        ->selectRaw('df.razonnocontratacion, DATE_FORMAT(df.fechacontratacion, "%d-%m-%Y") as fechacontratacion')
        ->where("df.vacantes_id","=",$request->id)
        ->get();

        $data["title"] = "PRUEBA";
        $array[0] = "PRUEBA";
        $fileName =  rand().'_'.time().'.'. 'pdf' ;
        $pdf = PDF::loadView('pdf.requerimiento', 
                        ['data' => $data, 
                         'clienteData' => $clienteData,
                         'generalData' => $generalData,
                         'personalData' => $personalData,
                         'academicData' => $academicData,
                         'puestoData' => $puestoData,
                         'adicionalData' => $adicionalData,
                         'economicaData' => $economicaData,
                         'procesoData' => $procesoData,
                         'finalData' => $finalData])
        ->save(storage_path('app/public/pdf/') . $fileName);

        //dd($simulations);
        $pdfDownload = storage_path('app/public/pdf/') . $fileName;
        return response()->download($pdfDownload)->deleteFileAfterSend(true);
    }

    public function statusRequirement(Request $request)
    {   

        $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
        $requerimiento->estatus_vacante = $request->status;

        if($requerimiento->update()){
            return "1";
        }
        else{
            return "0";
        }
        
    }

    public function getRecruitment(Request $request)
    {   
        $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);

        $reclutador = DB::table('users')->orderBy('name','ASC')
            ->where('roles_id','=','3')->where('status','=','1')->get();

        $reclu_select = '';
        foreach($reclutador as $r){

            $reclu_select .= "<option value='".$r->id."' ";
            
            if($requerimiento->reclutador_id == $r->id){
                $reclu_select .= "selected";
            }

            $reclu_select .=">".$r->name."</option>";
        }

        return response()->json(
            $reclu_select
        );
        
    }

    public function getApplicant(Request $request)
    {   
        $candidato_sel = DB::table('candidatos_proceso')
            ->where('vacantes_id','=',$request->idRequerimiento)
            ->where('estatus','=',2)
            ->get();
        
        if(count($candidato_sel) > 0){
            $id_candidato = $candidato_sel[0]->candidatos_id;
        }
        else{
            $id_candidato = 0;
        }

        $candidatos = DB::table('candidatos')
            ->orderBy('apellidos','ASC')
            ->orderBy('nombres','ASC')
            ->where('estatus','=','1')
            ->get();

        $candi_select = '';
        foreach($candidatos as $c){

            $candi_select .= "<option value='".$c->idcandidato."' ";
            
            if($id_candidato == $c->idcandidato){
                $candi_select .= "selected";
            }

            $candi_select .=">".$c->nombres." ".$c->apellidos."</option>";
        }

        return response()->json(
            $candi_select
        );
        
    }

    public function saveRecruitment(Request $request)
    {   
        $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
        $requerimiento->estatus_vacante = 3;
        $requerimiento->reclutador_id = $request->reclutador_id;

        if($requerimiento->update()){
            return "1";
        }
        else{
            return "0";
        }
        
        
    }

    public function saveApplicant(Request $request)
    {   

        $existe = DB::table('candidatos_proceso')
            ->where('vacantes_id','=',$request->idRequerimiento)
            //->where('candidatos_id','=',$request->candidato_id)
            ->where('estatus','=',2)
            ->get();
        
        if(count($existe) > 0){
            $requerimiento = CandidatosProgreso::findOrFail($existe[0]->id);
            $requerimiento->candidatos_id = $request->candidato_id;
            $result = $requerimiento->update();
        }
        else{
            $requerimiento = new CandidatosProgreso();
            $requerimiento->candidatos_id = $request->candidato_id;
            $requerimiento->vacantes_id = $request->idRequerimiento;
            $result = $requerimiento->save();
        }
        

        if($result){
            return "1";
        }
        else{
            return "0";
        }
        
        
    }

    public function validateInformation($id, Request $request)
    {
        $type = $request->type;

        if($type == 2){
            $result = GeneralData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 3){
            $result = PersonalData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 4){
            $result = AcademicData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 5){
            $result = PuestoData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 6){
            $result = AdicionalesData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 7){
            $result = EconomicaData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 8){
            $result = ProcesoData::where("vacantes_id", "=", $id)->get();
        }
        if($type == 9){
            $result = FinalData::where("vacantes_id", "=", $id)->get();
        }

        if(count($result) > 0){
            return 1;
        }
        else{
            return 0;
        }
    }


    public function addapplicant()
    {
        $applicants = DB::table('candidatos')
        ->selectRaw('idcandidato as id, nombres, apellidos, CONCAT(nombres," ",apellidos) as name, estatus')
        ->where('estatus_candidatos','=',5)
        ->orderBy('apellidos','ASC')
        ->orderBy('nombres','ASC')
        ->get();


        return Datatables()->of($applicants)
        ->addIndexColumn()
        ->addColumn('check', function($applicants){

                $check = '<input class="form-check-input selected-applicants" type="checkbox" value="" id="applicant_'.$applicants->id.'">';

            return $check;
        })
        ->addColumn('state', function($applicants){

            if($applicants->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($applicants->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->rawColumns(['check','state'])
        ->make(true);    

    }

    public function deleteapplicant(Request $request)
    {
        $requerimiento = $request->requerimiento;
        $applicants = DB::table('candidatos as c')
        ->selectRaw('c.idcandidato as id, cp.id as iddelete, CONCAT(c.nombres," ",c.apellidos) as name, c.estatus, c.estatus_candidatos, ec.color, ec.estatus as estatus_ec, cp.estatus as estatus_candidato')
        ->join('candidatos_proceso as cp','cp.candidatos_id','=','c.idcandidato')
        ->leftJoin('estatus_candidatos as ec','ec.id','=','c.estatus_candidatos')
        ->where('cp.vacantes_id','=',$requerimiento)
        ->orderBy('c.apellidos','ASC')
        ->orderBy('c.nombres','ASC')
        ->get();


        return Datatables()->of($applicants)
        ->addIndexColumn()
        ->addColumn('state', function($applicants){

            $color = "";
            $estatus = "";
            if($applicants->estatus_candidato == 0){
                $color = "success";
                $estatus = "Contratado";
            }
            if($applicants->estatus_candidato == 1){
                $color = "danger";
                $estatus = "Descartado";
            }
            if($applicants->estatus_candidato == 2 || $applicants->estatus_candidato == 3){
                $color = "primary";
                $estatus = "En cartera";
            }
                $state = '<div class="badge bg-'.$color.'-4 hp-bg-dark-'.$color.' text-'.$color.' border-'.$color.'">'.$estatus.'</div>';
        
            return $state;
        })
        ->addColumn('delete', function($applicants){

            if($applicants->estatus_candidato != 0){
                $delete = '<img src="'.url('img/trash.svg').'" style="width:18px;" class="deleteApplicant operaciones" id="'.$applicants->iddelete.'" />';
            }
            else{
                $delete = '';
            }
            
            return $delete;
        })
        ->rawColumns(['delete','state'])
        ->make(true);    

    }

    public function addApplicantNew(Request $request)
    {   
        //print_r($request->applicants);

        foreach($request->applicants as $ap){
            $getId = explode("_",$ap);
            $id = $getId[1];

            $existe = DB::table('candidatos_proceso')
            ->where('vacantes_id','=',$request->idRequerimiento)
            ->where('candidatos_id','=',$id)
            ->where("estatus","=",0)
            ->get();
        
            if(count($existe) < 1){
                $requerimiento = new CandidatosProgreso();
                $requerimiento->candidatos_id = $id;
                $requerimiento->vacantes_id = $request->idRequerimiento;
                $requerimiento->save();

                $applicantUpd = Applicant::findOrFail($id);
                $applicantUpd->estatus_candidatos = 2;
                $applicantUpd->update();
            }
        }
        return "1";
        
    }

    public function deleteApplicantDo($id)
    {   
        $applicant_process = DB::table('candidatos_proceso')
        ->where('id','=',$id)
        ->get();
        
        $applicantUpd = Applicant::findOrFail($applicant_process[0]->candidatos_id);
        $applicantUpd->estatus_candidatos = 5;
        $applicantUpd->update();

        $requerimiento = CandidatosProgreso::findOrFail($id);
        $requerimiento->delete();

        return "1";
        
    }
    
	
}
