<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;
use Datatables;
use Carbon\Carbon;
use App\Models\Requirement\GeneralData;
use App\Models\Requirement\PersonalData;
use App\Models\Requirement\AcademicData;
use App\Models\Requirement\AcademicIdiomsData;
use App\Models\Requirement\AcademicCertificadosData;
use App\Models\Requirement\PuestoData;
use App\Models\Requirement\AdicionalesData;
use App\Models\Requirement\EconomicaData;
use App\Models\Requirement\ProcesoData;
use App\Models\Requirement\FinalData;
use App\Models\User;
use App\Models\Client;
use App\Models\Applicant;
use App\Models\Requerimiento;
use App\Models\ServicioRequerido;
use App\Models\CandidatosProgreso;
use App\Traits\EmailTrait;

class RequestController extends Controller
{
    use EmailTrait;

    public function index()
    {
        if(auth()->user()->roles_id != 3){
            $requerimientos = DB::table('vacantes as v')
            ->selectRaw('v.id, c.nombres as nombre_cliente, v.estatus, v.estatus_vacante as estatus_vacante_in, ev.estatus as estatus_vacante_or, ev.color, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fecha, v.fecha_vacante_cubierta, dg.puesto, v.reclutador_id, u.name as namereclutador, p.perfil')
            ->join('cliente as c','c.id', '=','v.cliente_id')
            ->leftJoin('estatus_vacantes as ev','ev.id', '=','v.estatus_vacante')
            ->leftJoin('datosgenerales as dg', 'dg.vacantes_id', '=', 'v.id')
            ->leftJoin('users as u', 'u.id', '=', 'v.reclutador_id')
            ->leftJoin('perfil as p', 'p.id', '=', 'dg.perfil_id')
            ->orderBy("v.id","DESC")
            ->get();
        }
        else{
            $requerimientos = DB::table('vacantes as v')
            ->selectRaw('v.id, c.nombres as nombre_cliente, v.estatus, v.estatus_vacante as estatus_vacante_in, ev.estatus as estatus_vacante_or, ev.color, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fecha, v.fecha_vacante_cubierta, dg.puesto, v.reclutador_id, u.name as namereclutador, p.perfil')
            ->join('cliente as c','c.id', '=','v.cliente_id')
            ->leftJoin('estatus_vacantes as ev','ev.id', '=','v.estatus_vacante')
            ->leftJoin('datosgenerales as dg', 'dg.vacantes_id', '=', 'v.id')
            ->leftJoin('users as u', 'u.id', '=', 'v.reclutador_id')
            ->leftJoin('perfil as p', 'p.id', '=', 'dg.perfil_id')
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
        $perfiles = DB::table('perfil')->where("estatus","=",1)->orderBy('perfil', 'ASC')->get();
        
        if($roles[0]->permitido == 1){
            return view('vacant.index')->with(['clientes'=>$clients,
                                                'estado_civiles'=>$estado_civiles,
                                                'request_service'=>$request_service,
                                                'modalidad'=>$modalidad,
                                                'perfiles'=>$perfiles,
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
        $generalData = GeneralData::where("vacantes_id","=",$request->idRequerimiento)->get();

        if(count($generalData) < 1){
            return -1;
        }

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

            $this->sendNotification($request->reclutador_id);
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


    public function addapplicant(Request $request)
    {
        $idRequerimiento = $request->idRequerimiento;
        $generalData = GeneralData::where("vacantes_id","=",$idRequerimiento)->get();

        $applicants = DB::table('candidatos as c')
        ->selectRaw('c.idcandidato as id, c.nombres, c.apellidos, CONCAT(c.nombres," ",c.apellidos) as name, c.estatus')
        ->join("candidatos_perfiles as cp","cp.candidato_id","=","c.idcandidato")
        ->leftJoin('candidatos_proceso as cpro', function($join) use ($idRequerimiento)
        {
            $join->on('cpro.candidatos_id','=','c.idcandidato');
            $join->on('cpro.vacantes_id','=',DB::raw($idRequerimiento));
        })
        ->where('cp.perfil_id','=',$generalData[0]->perfil_id)
        ->where('cpro.id','=',null)
        ->orderBy('c.apellidos','ASC')
        ->orderBy('c.nombres','ASC')
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
        ->selectRaw('c.idcandidato as id, cp.id as iddelete, CONCAT(c.nombres," ",c.apellidos) as name, c.estatus, c.estatus_candidatos, ep.color, ep.estatus as estatus_ec, ep.estatus as estatus_candidato')
        ->join('candidatos_proceso as cp','cp.candidatos_id','=','c.idcandidato')
        ->leftJoin("estatus_proceso as ep","ep.id","=","cp.estatus")
        ->where('cp.vacantes_id','=',$requerimiento)
        ->orderBy('c.apellidos','ASC')
        ->orderBy('c.nombres','ASC')
        ->get();


        return Datatables()->of($applicants)
        ->addIndexColumn()
        ->addColumn('state', function($applicants){

            $color = $applicants->color;
            $estatus = $applicants->estatus_candidato;
           /* if($applicants->estatus_candidato == 0){
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
            }*/
                $state = '<span class="badge bg-'.$color.'-4 hp-bg-dark-'.$color.' text-'.$color.' border-'.$color.'">'.$estatus.'</span>';
        
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
