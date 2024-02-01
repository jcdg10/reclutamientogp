<?php

namespace App\Http\Controllers;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\Academic;
use App\Models\Applicant;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\CandidatosProgreso;
use App\Models\Requirement\GeneralData;
use App\Models\Requirement\ProcesoData;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    public function index()
    {

        $applicants = DB::table('candidatos as c')
        ->selectRaw('c.idcandidato as id, c.nombres, c.apellidos, c.edad, c.perfil, 
        FORMAT(c.pretensiones,2) as pretensiones, c.estatus, ec.estatus as estatus_candidatos_r, 
        ec.color, v.cliente_id, dg.puesto as vacante_proceso, dg2.puesto as vacante_ocupada')
        ->join('estatus_candidatos as ec','ec.id', '=','c.estatus_candidatos')
        ->leftJoin('candidatos_proceso as cp', function($join)
        {
            $join->on('cp.candidatos_id', '=','c.idcandidato');
            $join->on('cp.estatus','=',DB::raw(2));
        })
        ->leftJoin('candidatos_proceso as cp_c', function($join)
        {
            $join->on('cp_c.candidatos_id', '=','c.idcandidato');
            $join->on('cp_c.estatus','=',DB::raw(0));
        })
        ->leftJoin('vacantes as v','cp.vacantes_id', '=','v.id')
        ->leftJoin('datosgenerales as dg','cp.vacantes_id', '=','dg.vacantes_id')
        ->leftJoin('datosgenerales as dg2','cp_c.vacantes_id', '=','dg2.vacantes_id')
        ->orderBy("c.idcandidato","DESC")
        ->get();
        
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 3)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                  ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;

        return Datatables()->of($applicants)
        ->addIndexColumn()
        ->addColumn('estatus_candidatos', function($applicants){

            $state = '<div class="badge bg-'.$applicants->color.'-4 hp-bg-dark-'.$applicants->color.' text-'.$applicants->color.' border-'.$applicants->color.'">'.$applicants->estatus_candidatos_r.'</div>';
    
            return $state;
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
        ->addColumn('requirement', function($applicants){

            $requirement = 'Sin asignación';
            if($applicants->vacante_ocupada != '' && $applicants->vacante_ocupada != null){
                if($applicants->cliente_id == null || $applicants->cliente_id == '' ){
                    $requirement = 'Sin asignación';
                }
                if(($applicants->cliente_id != null || $applicants->cliente_id != '') &&
                   ($applicants->vacante_proceso == null || $applicants->vacante_proceso == '')){
                    $requirement = 'Requerimiento sin nombre';
                }
                if($applicants->vacante_ocupada != null || $applicants->vacante_ocupada != ''){
                    $requirement = $applicants->vacante_ocupada;
                }
            }
            elseif($applicants->vacante_proceso != '' && $applicants->vacante_proceso != null){
                if($applicants->cliente_id == null || $applicants->cliente_id == '' ){
                    $requirement = 'Sin asignación';
                }
                if(($applicants->cliente_id != null || $applicants->cliente_id != '') &&
                   ($applicants->vacante_proceso == null || $applicants->vacante_proceso == '')){
                    $requirement = 'Requerimiento sin nombre';
                }
                if($applicants->vacante_proceso != null || $applicants->vacante_proceso != ''){
                    $requirement = $applicants->vacante_proceso;
                }
            }

            
        
            return $requirement;
        })
        ->addColumn('action', function($applicants){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                            if($GLOBALS["editar"] == 1){
                                $btn .= '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$applicants->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                            }

                            if($GLOBALS["eliminar"] == 1){
                                if($applicants->estatus == 1){
                                    $btn.='<input type="checkbox" id="switch_'.$applicants->id.'" /><label class="desactivar" id="lbl_'.$applicants->id.'" for="switch_'.$applicants->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                                }
                                if($applicants->estatus == 0){
                                    $btn.='<input type="checkbox" id="switch_'.$applicants->id.'" checked /><label class="activar" id="lbl_'.$applicants->id.'" for="switch_'.$applicants->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
                                }
                            }

                            $btn.=  '</span>';
            }
        
            return $btn;
        })
        ->rawColumns(['estatus_candidatos','requirement','state','action'])
        ->make(true);    

        //return Datatables::of($users)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplicant()
    {
        $escolaridad = DB::table('escolaridad')->get();
        $ciudades = DB::table('city')->get();
        $especialidades = DB::table('especialidad')->get();
        $estatus_candidatos = DB::table('estatus_candidatos')->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 3)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                ->orWhere('permiso', '=', 2)
                ->orWhere('permiso', '=', 5);
        })
        ->get();
        
        if($roles[0]->permitido == 1){
            return view('applicant.index')->with(['roles'=>$roles,
                                                'escolaridad'=>$escolaridad, 'ciudades'=>$ciudades, 
                                                'especialidades'=>$especialidades,
                                                'estatus_candidatos'=>$estatus_candidatos]);
        }
        else{
            
            return redirect('/');
        }
        
    }

    public function store(Request $request)
    {   
        //if(auth()->user()->responsible == 1){
            $validated = $request->validate([
                'names' => ['required',
                            'string',
                            'max:45'
                            ],
                'lastnames' => ['required',
                            'string',
                            'max:45'
                            ],
                'age' => ['required',
                            'integer'
                            ],
                'phone' => ['required',
                            'max:10'
                            ],
                'correo' => ['required',
                            'email',
                            'unique:candidatos',
                            'max:80'
                            ],
                'city' => ['required',
                            'max:45'
                            ],
                'pretensions' => ['required'],
                'profile' => ['required',
                            'string',
                            'max:45'
                            ],
                'specialty' => ['required'
                            ],
                'applicant_status' => ['required'
                            ],
            ]);
            
            $applicant = new Applicant();
            $applicant->nombres = $request->names;
            $applicant->apellidos = $request->lastnames;
            $applicant->edad = $request->age;
            $applicant->telefono = $request->phone;
            $applicant->correo = $request->correo;
            $applicant->ciudad = $request->city;
            $applicant->pretensiones = $request->pretensions;
            $applicant->perfil = $request->profile;
            $applicant->especialidad = $request->specialty;
            $applicant->estatus_candidatos = $request->applicant_status;
            $applicant->fechaalta = Carbon::now();
            $applicant->fechamod = Carbon::now();
            $applicant->estatus = 1;
            
            if($applicant->save()){
                //echo $request->name.' - '.$request->email.' - '.$request->password;
                /*$notification = new Notification();
                $notification->catalogue_notifications_id = 1;
                $notification->date = date('Y-m-d H:i:s');
                $notification->users_id = DB::getPdo()->lastInsertId();
                $notification->save();

                event(new NotificationEvent("1",$request->franchise));

                event(new NotificationFranchiseEvent("1",$request->franchise));*/
                
                //$men = $this->sendWelcome($request->name, $request->email, $password);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applicant = Applicant::findOrFail($id);

        $especialidades = DB::table('especialidad')->where("estatus","=",1)
                            ->orWhere("id","=",$applicant->especialidad)->get();
        $ciudades = DB::table('city')->where("estatus","=",1)
                            ->orWhere("id","=",$applicant->ciudad)->get();

        $especialidadSelect = "<option value=''>Selecciona una especialidad</option>";
        foreach($especialidades as $e){
            $especialidadSelect .= "<option value='".$e->id."' ";

            if($e->id == $applicant->especialidad){
                $especialidadSelect .= " selected ";
            }
            
            $especialidadSelect .= ">".$e->especialidad."</option>";
        }
        $applicant->especialidadSelect = $especialidadSelect;

        $ciudadSelect = "<option value=''>Selecciona una especialidad</option>";
        foreach($ciudades as $c){
            $ciudadSelect .= "<option value='".$c->id."' ";

            if($c->id == $applicant->ciudad){
                $ciudadSelect .= " selected ";
            }
            
            $ciudadSelect .= ">".$c->nombre."</option>";
        }
        $applicant->ciudadSelect = $ciudadSelect;

        $request = new \Illuminate\Http\Request();
        $request->replace(['id' => $id]);
        $estatus = $this->processapplicantdataget($request);
        $final = $estatus->getData();
        $applicant->estatus_op = $final->estatus_op;

        if(auth()->user()->id == $final->reclutador){
            $applicant->reclutador = 1;
        }
        else{
            $applicant->reclutador = 0;
        }
        

        return response()->json(
            $applicant
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
        //if(auth()->user()->responsible == 1){    
            $validated = $request->validate([
                'names' => ['required',
                            'string',
                            'max:45'
                            ],
                'lastnames' => ['required',
                            'string',
                            'max:45'
                            ],
                'age' => ['required',
                            'integer'
                            ],
                'phone' => ['required',
                            'max:10'
                            ],
                'correo' => ['required',
                            'email',
                            'unique:candidatos,correo,'.$id.',idcandidato',
                            'max:80'
                            ],
                'city' => ['required'
                            ],
                'pretensions' => ['required'],
                'profile' => ['required',
                            'string',
                            'max:45'
                            ],
                'specialty' => ['required'
                            ],
                'applicant_status' => ['required'
                        ],
            ]);

            $applicant = Applicant::findOrFail($id);
            $applicant->nombres = $request->names;
            $applicant->apellidos = $request->lastnames;
            $applicant->edad = $request->age;
            $applicant->telefono = $request->phone;
            $applicant->correo = $request->correo;
            $applicant->ciudad = $request->city;
            $applicant->pretensiones = $request->pretensions;
            $applicant->perfil = $request->profile;
            $applicant->especialidad = $request->specialty;
            $applicant->estatus_candidatos = $request->applicant_status;
            $applicant->fechamod = Carbon::now();

            if($applicant->update()){
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $applicant = Applicant::findOrFail($id);

            if($applicant->estatus == 1){
                $applicant->estatus = 0;
            }
            else{
                $applicant->estatus = 1;
            }
            

            if($applicant->update()){
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

    public function addExperience(Request $request)
    {   
        //if(auth()->user()->responsible == 1){
            $validated = $request->validate([
                'puesto' => ['required',
                            'string',
                            'max:80'
                            ],
                'empresa' => ['required',
                            'string',
                            'max:80'
                            ],
                'fechaini' => ['required']
            ]);

            $experience = new Experience();
            $experience->puesto = $request->puesto;
            $experience->empresa = $request->empresa;
            $experience->detalles_puesto = $request->detalles_puesto;
            $experience->fechaini = $request->fechaini;
            $experience->fechafin = $request->fechafin;
            $experience->puesto_actual = $request->puestoactual;
            $experience->candidato_id = $request->candidato_id;
            
            if($experience->save()){
                //echo $request->name.' - '.$request->email.' - '.$request->password;
                /*$notification = new Notification();
                $notification->catalogue_notifications_id = 1;
                $notification->date = date('Y-m-d H:i:s');
                $notification->users_id = DB::getPdo()->lastInsertId();
                $notification->save();

                event(new NotificationEvent("1",$request->franchise));

                event(new NotificationFranchiseEvent("1",$request->franchise));*/
                
                //$men = $this->sendWelcome($request->name, $request->email, $password);
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

    public function editExperience(Request $request, $id)
    {   
        //if(auth()->user()->responsible == 1){    
            $validated = $request->validate([
                'puesto' => ['required',
                            'string',
                            'max:80'
                            ],
                'empresa' => ['required',
                            'string',
                            'max:80'
                            ],
                'fechaini' => ['required']
            ]);

            $experience = Experience::findOrFail($id);
            $experience->puesto = $request->puesto;
            $experience->empresa = $request->empresa;
            $experience->detalles_puesto = $request->detalles_puesto;
            $experience->fechaini = $request->fechaini;
            $experience->fechafin = $request->fechafin;
            $experience->puesto_actual = $request->puestoactual;

            if($experience->update()){
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

    public function getApplicantExperience(Request $request)
    {
        $experience = Experience::where('candidato_id','=',$request->id)->get();
        
        $table_experience = '<table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Puesto</th>
                                        <th>Empresa</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if(count($experience) > 0){
            foreach($experience as $e){
                $table_experience .= '<tr id="table_'.$e->id.'">
                                        <td>'.$e->puesto.'</td>
                                        <td>'.$e->empresa.'</td>
                                        <td>
                                            <svg id="'.$e->id.'" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit editExperience"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            <svg id="'.$e->id.'" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-delete deleteExperience"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path><line x1="18" y1="9" x2="12" y2="15"></line><line x1="12" y1="9" x2="18" y2="15"></line></svg>
                                        </td>
                                    </tr>';
            }
        }
        else{
            $table_experience .= '<tr align="center">
                                        <td colspan="3">No hay ningún registro</td>
                                  </tr>';
        }

        $table_experience .= '   </tbody>
                             </table>';

        return response()->json(
            $table_experience
        );
    }

    public function getExperience($id)
    {
        $experience = Experience::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        return response()->json(
            $experience
        );
    }

    public function deleteExperience($id)
    {
        try{
            $experience = Experience::findOrFail($id);

            if($experience->delete()){
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

    public function addAcademico(Request $request)
    {   
        $validated = $request->validate([
            'escolaridad' => ['required'],
            'institucion' => ['required',
                        'string',
                        'max:80'
                        ],
            'titulo_carrera' => ['required',
                        'string',
                        'max:120'
                        ],
            'anioini' => ['required'],
            'aniofin' => ['required']
        ]);

        $academic = new Academic();
        $academic->escolaridad_id = $request->escolaridad;
        $academic->institucion = $request->institucion;
        $academic->titulo_carrera = $request->titulo_carrera;
        $academic->anioini = $request->anioini;
        $academic->aniofin = $request->aniofin;
        $academic->estudio = $request->estudio;
        $academic->candidato_id = $request->candidato_id;
        
        if($academic->save()){
            //echo $request->name.' - '.$request->email.' - '.$request->password;
            /*$notification = new Notification();
            $notification->catalogue_notifications_id = 1;
            $notification->date = date('Y-m-d H:i:s');
            $notification->users_id = DB::getPdo()->lastInsertId();
            $notification->save();

            event(new NotificationEvent("1",$request->franchise));

            event(new NotificationFranchiseEvent("1",$request->franchise));*/
            
            //$men = $this->sendWelcome($request->name, $request->email, $password);
            return "1";
        }
        else{
            return "0";
        }
            
    }

    public function editAcademico(Request $request, $id)
    {   
        //if(auth()->user()->responsible == 1){
            $validated = $request->validate([
                'escolaridad' => ['required'],
                'institucion' => ['required',
                            'string',
                            'max:80'
                            ],
                'titulo_carrera' => ['required',
                            'string',
                            'max:120'
                            ],
                'anioini' => ['required'],
                'aniofin' => ['required']
            ]);

            $academic = Academic::findOrFail($id);
            $academic->escolaridad_id = $request->escolaridad;
            $academic->institucion = $request->institucion;
            $academic->titulo_carrera = $request->titulo_carrera;
            $academic->anioini = $request->anioini;
            $academic->aniofin = $request->aniofin;
            $academic->estudio = $request->estudio;
            
            if($academic->update()){
                //echo $request->name.' - '.$request->email.' - '.$request->password;
                /*$notification = new Notification();
                $notification->catalogue_notifications_id = 1;
                $notification->date = date('Y-m-d H:i:s');
                $notification->users_id = DB::getPdo()->lastInsertId();
                $notification->save();

                event(new NotificationEvent("1",$request->franchise));

                event(new NotificationFranchiseEvent("1",$request->franchise));*/
                
                //$men = $this->sendWelcome($request->name, $request->email, $password);
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

    public function getAcademic(Request $request)
    {
        $academic = DB::table('reqacademico as ra')
        ->selectRaw('ra.id, e.nivel, ra.institucion, ra.anioini, ra.aniofin')
        ->join('escolaridad as e', 'e.id', '=', 'ra.escolaridad_id')
        ->where('ra.candidato_id','=',$request->id)
        ->get();
        
        $table_academic = '<table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nivel</th>
                                        <th>Institución</th>
                                        <th>Año inicio</th>
                                        <th>Año fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

        if(count($academic) > 0){
            foreach($academic as $a){
                $table_academic .= '<tr id="table_'.$a->id.'">
                                        <td>'.$a->nivel.'</td>
                                        <td>'.$a->institucion.'</td>
                                        <td>'.$a->anioini.'</td>
                                        <td>'.$a->aniofin.'</td>
                                        <td>
                                            <svg id="'.$a->id.'" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit editAcademico"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            <svg id="'.$a->id.'" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-delete deleteAcademico"><path d="M21 4H8l-7 8 7 8h13a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path><line x1="18" y1="9" x2="12" y2="15"></line><line x1="12" y1="9" x2="18" y2="15"></line></svg>
                                        </td>
                                    </tr>';
            }
        }
        else{
            $table_academic .= '<tr align="center">
                                        <td colspan="5">No hay ningún registro</td>
                                  </tr>';
        }

        $table_academic .= '   </tbody>
                             </table>';

        return response()->json(
            $table_academic
        );
    }

    public function getEspecificAcademic($id)
    {
        $academic = Academic::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/
        $escolaridad = DB::table('escolaridad')->get();

        $select_escolaridad = '<option value="">Selecciona un nivel</option>';
        foreach($escolaridad as $e){
            $select_escolaridad .= '<option value="'.$e->id.'" ';
            
            if($e->id == $academic->escolaridad_id){
                $select_escolaridad .= ' selected';
            }
            
            $select_escolaridad .= '>'.$e->nivel.'</option>';
        }

        $academic->select_escolaridad = $select_escolaridad;

        return response()->json(
            $academic
        );
    }

    public function deleteAcademico($id)
    {
        try{
            $academic = Academic::findOrFail($id);

            if($academic->delete()){
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

    public function processapplicantdataget(Request $request)
    {   
        //0  contratado
        //1  descartado
        //2  en proceso
        $info = DB::table('candidatos_proceso')
            ->where("candidatos_id","=",$request->id)
            //->where("estatus","=",2)
            ->orderBy("id","DESC")
            ->get();

        if(isset($info[0]->vacantes_id)){

            $processData = ProcesoData::where("vacantes_id", "=", $info[0]->vacantes_id)->first();

            $vacantData = DB::table('vacantes')
                ->selectRaw('reclutador_id')
                ->where("id", "=", $info[0]->vacantes_id)
                ->get();

            if($processData == null){
                $processData = new ProcesoData();
                $processData->estatus_op = 5;
                $processData->reclutador = $vacantData[0]->reclutador_id;
            }
            else{
                $processData->estatus_op = 1;
                $generalData = DB::table('datosgenerales as dg')
                ->selectRaw('dg.puesto, u.name')
                ->join('users as u','u.id', '=','dg.ejecutivoen')
                ->where("vacantes_id", "=", $info[0]->vacantes_id)
                ->get();

                $info_candidatos_vacante = DB::table('candidatos_proceso')
                ->selectRaw('id, entrevista as entrevistaCV, pruebatecnica as pruebatecnicaCV, pruebapsicometrica as pruebapsicometricaCV, referencias as referenciasCV, entrevista_tecnica as entrevista_tecnicaCV, estudio_socioeconomico as estudio_socioeconomicoCV, estatus')
                ->where("id","=",$info[0]->id)
                //->where("candidatos_id","=",$request->id)
                //->where("vacantes_id","=",$info[0]->vacantes_id)
                //->where("estatus","=",2)
                ->get();
    //print_r($processData);
                if(isset($info_candidatos_vacante[0]->id)){
                    $processData->estatus_candidato_vacante = 1;
                    $processData->entrevistaCV = $info_candidatos_vacante[0]->entrevistaCV;
                    $processData->pruebatecnicaCV = $info_candidatos_vacante[0]->pruebatecnicaCV;
                    $processData->pruebapsicometricaCV = $info_candidatos_vacante[0]->pruebapsicometricaCV;
                    $processData->referenciasCV = $info_candidatos_vacante[0]->referenciasCV;
                    $processData->entrevista_tecnicaCV = $info_candidatos_vacante[0]->entrevista_tecnicaCV;
                    $processData->estudio_socioeconomicoCV = $info_candidatos_vacante[0]->estudio_socioeconomicoCV;
                    $processData->estatus = $info_candidatos_vacante[0]->estatus;
                }
                else{
                    $processData->estatus_candidato_vacante = 0;
                }

                if(isset($generalData[0]->puesto)){
                    $processData->nombre_puesto = $generalData[0]->puesto;
                    //$processData->nombre_responsable = $info[0]->vacantes_id;
                }
                else{
                    $processData->nombre_puesto = "";
                }

                $processData->reclutador = $vacantData[0]->reclutador_id;
            }

        }
        else{
            $processData = new ProcesoData();
            $processData->estatus_op = 0;
            $processData->estatus_candidato_vacante = 0;
            $processData->reclutador = "";
        }

        

        return response()->json(
            $processData
        );
        
    }

    public function addCandidatoVacante(Request $request)
    {   
            $info = DB::table('candidatos_proceso')
            ->where("candidatos_id","=",$request->candidato_id)
            ->where("vacantes_id","=",$request->vacante_id)
            ->where("estatus","=",2)
            ->get();

            //0  contratado
            //1  descartado
            //2  en cartera
            //3  en cartera descartado
            if($request->estatus_candidato == 2){
                $estatus_proceso = 2;
            }
            if($request->estatus_candidato == 3){
                $estatus_proceso = 0;
            }
            if($request->estatus_candidato == 4){
                $estatus_proceso = 1;
            }
            if($request->estatus_candidato == 5){
                $estatus_proceso = 3;
            }

            if(isset($info[0]->id)){
                $candidatos_proceso = CandidatosProgreso::findOrFail($info[0]->id);
                $candidatos_proceso->candidatos_id = $request->candidato_id;
                $candidatos_proceso->vacantes_id = $request->vacante_id;
                $candidatos_proceso->entrevista = $request->entrevista;
                $candidatos_proceso->pruebatecnica = $request->prueba_tecnica;
                $candidatos_proceso->pruebapsicometrica = $request->prueba_psicometrica;
                $candidatos_proceso->referencias = $request->referencia;
                $candidatos_proceso->entrevista_tecnica = $request->entrevista_tecnica;
                $candidatos_proceso->estudio_socioeconomico = $request->estudio_socioeconomico;
                $candidatos_proceso->estatus = $estatus_proceso;

                $applicant = Applicant::findOrFail($request->candidato_id);
                $applicant->estatus_candidatos = $request->estatus_candidato;
                $applicant->update();
                
                if($candidatos_proceso->update()){
                    return "1";
                }
                else{
                    return "0";
                }
            }
            else{
                $candidatos_proceso = new CandidatosProgreso();
                $candidatos_proceso->candidatos_id = $request->candidato_id;
                $candidatos_proceso->vacantes_id = $request->vacante_id;
                $candidatos_proceso->entrevista = $request->entrevista;
                $candidatos_proceso->pruebatecnica = $request->prueba_tecnica;
                $candidatos_proceso->pruebapsicometrica = $request->prueba_psicometrica;
                $candidatos_proceso->referencias = $request->referencia;
                $candidatos_proceso->entrevista_tecnica = $request->entrevista_tecnica;
                $candidatos_proceso->estudio_socioeconomico = $request->estudio_socioeconomico;
                $candidatos_proceso->estatus = $request->estatus_candidato;

                if($request->estatus_candidato == 1)
                {
                    $applicant = Applicant::findOrFail($request->candidato_id);
                    $applicant->estatus_candidatos = 3;
                    $applicant->update();
                }
                
                if($candidatos_proceso->save()){
                    return "1";
                }
                else{
                    return "0";
                }
            }

    }
}
