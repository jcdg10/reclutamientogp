<?php

namespace App\Http\Controllers;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\Academic;
use App\Models\Applicant;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Models\CandidatoPerfil;
use App\Models\CandidatosProgreso;
use App\Models\CandidatoDocumentacion;
use App\Models\Requirement\GeneralData;
use App\Models\Requirement\ProcesoData;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    public function index()
    {
        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect();

        $applicants = DB::table('candidatos as c')
        ->selectRaw('c.idcandidato as id, c.nombres, c.apellidos, c.edad, 
        FORMAT(c.pretensiones,2) as pretensiones, c.estatus, ec.estatus as estatus_candidatos_r, 
        ec.color, v.cliente_id,
        group_concat(DISTINCT CONCAT(per.perfil) 
        ORDER BY per.perfil
        SEPARATOR ", ") as perfil,
        group_concat(DISTINCT CONCAT(dg.puesto) 
        ORDER BY dg.puesto
        SEPARATOR ", ") as vacante_proceso')
        ->join('estatus_candidatos as ec','ec.id', '=','c.estatus_candidatos')
        ->leftJoin('candidatos_perfiles as cper','c.idcandidato', '=','cper.candidato_id')
        ->leftJoin('perfil as per','cper.perfil_id', '=','per.id')
        ->leftJoin('candidatos_proceso as cp', function($join)
        {
            $join->on('cp.candidatos_id', '=','c.idcandidato');
            $join->on('cp.estatus','=',DB::raw(2));
        })
        ->leftJoin('vacantes as v','cp.vacantes_id', '=','v.id')
        ->leftJoin('datosgenerales as dg','cp.vacantes_id', '=','dg.vacantes_id')
        ->orderBy("c.idcandidato","DESC")
        ->groupBy(
        'c.idcandidato','c.nombres','c.apellidos','c.edad',
        'c.pretensiones', 'c.estatus', 'ec.estatus', 
        'ec.color')
        ->get();     
        //, 'v.cliente_id'
        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect();
        
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
            if($applicants->vacante_proceso != '' && $applicants->vacante_proceso != null){
                $requirement = $applicants->vacante_proceso;
            }
            /*if($applicants->vacante_ocupada != '' && $applicants->vacante_ocupada != null){
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
            }*/

            
        
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
        $perfiles = DB::table('perfil')->where("estatus","=",1)->orderBy('perfil', 'ASC')->get();
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
                                                'perfiles'=>$perfiles,
                                                'estatus_candidatos'=>$estatus_candidatos]);
        }
        else{
            
            return redirect('/');
        }
        
    }

    public function store(Request $request)
    {   
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
        $applicant->especialidad = $request->specialty;
        $applicant->estatus_candidatos = $request->applicant_status;
        $applicant->fechaalta = Carbon::now();
        $applicant->fechamod = Carbon::now();
        $applicant->estatus = 1;

        if($request->hasFile('profile_photo')){
            $photoName = time() . '_'. uniqid() . '.' . $request->profile_photo->extension();
            $applicant->foto_perfil = $photoName;
        }
        
        if($applicant->save()){
            $lastInsertedId = DB::getPdo()->lastInsertId();
            //adding profile photo to the applicant if exist
            if($request->hasFile('profile_photo')){
                $directory = storage_path('app/public/candidatos/' . $lastInsertedId);

                if(!file_exists($directory)) { 
                    mkdir($directory);
                }

                $file = $request->file('profile_photo');
                $file->move(storage_path('app/public/candidatos/'.$lastInsertedId),$photoName);
            }

            $array_profiles = explode(",",$request->array_profiles);
            foreach($array_profiles as $profiles){
                $candidatoPerfil = new CandidatoPerfil(); 
                $candidatoPerfil->perfil_id = $profiles;
                $candidatoPerfil->candidato_id = $lastInsertedId;
                $candidatoPerfil->save();           
            }
        
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

        if($applicant->foto_perfil != '')
            $applicant->route_image = asset('storage/candidatos/'.$id."/".$applicant->foto_perfil);
        else
            $applicant->route_image = asset('storage/candidatos/no_image.jpg');

        $data_perfiles = $this->getPerfiles($id);
        $info_perfiles = $data_perfiles[0];
        $ids_perfiles = $data_perfiles[1];
        $applicant->info_perfiles = $info_perfiles;
        $applicant->ids_perfiles = $ids_perfiles;

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
            $applicant->especialidad = $request->specialty;
            $applicant->estatus_candidatos = $request->applicant_status;
            $applicant->fechamod = Carbon::now();

            if($request->hasFile('profile_photo')){
                $photoName = time() . '_'. uniqid() . '.' . $request->profile_photo->extension();
                $directory = storage_path('app/public/candidatos/'.$id);

                if($applicant->foto_perfil != '')
                    unlink($directory."/".$applicant->foto_perfil);
                
                $applicant->foto_perfil = $photoName;

                if(!file_exists($directory)) { 
                    mkdir($directory);
                }

                $file = $request->file('profile_photo');
                $file->move(storage_path('app/public/candidatos/'.$id),$photoName);
            }

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

    public function addfile(Request $request)
    {    
        $nameFile = $request->file_app->getClientOriginalName();
        $id = $request->idAplicante;
        $files = CandidatoDocumentacion::where("candidato_id","=",$id)
        ->where("documento","=",$nameFile)->get();
        $exist = count($files);

        $directory = storage_path('app/public/candidatos/'.$id);

        if(!file_exists($directory)) { 
            mkdir($directory);
        }

        $file = $request->file('file_app');
        $file->move(storage_path('app/public/candidatos/'.$id),$nameFile);

        if($exist == 0){

            $candidatodocumentacion = new CandidatoDocumentacion();
            $candidatodocumentacion->candidato_id = $id;
            $candidatodocumentacion->documento = $nameFile;

            if($candidatodocumentacion->save()){
                return "1";
            }
            else{
                return "0";
            }
        }
        else{
            $candidatodocumentacion = CandidatoDocumentacion::findOrFail($files[0]->id);
            $candidatodocumentacion->documento = $nameFile;

            if($candidatodocumentacion->update()){
                return "2";
            }
            else{
                return "0";
            }
        }
        
    }

    public function getfiles(Request $request, $id)
    {    
        $files = CandidatoDocumentacion::where("candidato_id","=",$id)->get();
        $exist = count($files);

        if($exist == 0){

            return response()->json([
                "info" => "<div class='text-center mt-4'><div class='row' style='display:block;'>No hay documentos.</div></div>"
            ]);
        }
        else{
            $archivos = "<div class='text-center mt-3'>";
            foreach($files as $f){
                $archivos .= "<div class='row' style='display:block;'>";
                $archivos .= "<a href='".asset('storage/candidatos/'.$id.'/'.$f->documento)."' download>";
                $archivos .= $f->documento;
                $archivos .= "</a> <span class='delete_file' id='".$f->id."' style='font-weight:600; color: red;cursor: pointer;'>X</span>";
                $archivos .= "</div>";
            }
            $archivos .= "</div>";

            return response()->json([
                "info" => $archivos
            ]);
        }
        
    }

    public function deletefiles($id)
    { 
        $files = CandidatoDocumentacion::findOrFail($id);
        if($files->delete()){
    
            $file = storage_path('app/public/candidatos/'.$files->candidato_id.'/'.$files->documento);
            unlink($file);
            
            return '1';
        }
        else{
            return '0';
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

    public function processapplicantdatagetall(Request $request)
    {   
        //0  contratado
        //1  descartado
        //2  en proceso
        $info = DB::table('candidatos_proceso as cp')
        ->selectRaw('cp.id, dg.puesto, ec.estatus, ec.color')
            ->join("datosgenerales as dg","cp.vacantes_id","=","dg.vacantes_id")
            ->join("estatus_proceso as ec","ec.id","=","cp.estatus")
            ->where("cp.candidatos_id","=",$request->id)
            ->orderBy("cp.id","DESC")
            ->get();

        if(isset($info[0]->id)){

            //print_r($info);
            $table_info = "<table class='procesoTable ms-4'>
            <tr style='font-weight:600;'>
            <td>Requerimiento</td>
            <td>Estatus</td>
            <td>Acciones</td>
            </tr>";
            foreach($info as $in){
                $table_info .= "<tr>";

                $table_info .= "<td>".$in->puesto."</td>";
                $table_info .= "<td><span class='badge bg-".$in->color."-4 hp-bg-dark-".$in->color." text-".$in->color." border-".$in->color."' >".$in->estatus."</span></td>";
                $table_info .= '<td><img src="'.url('img/eye.svg').'" class="ver_proceso imgEdit toggle" id="'.$in->id.'" data-toggle="tooltip" data-placement="top" title="" style="margin-right:9px;" data-bs-original-title="Ver" aria-label="Ver"></td>';
                $table_info .= "</tr>";
            }

            $table_info .= "</table>";

            $processData = new ProcesoData();
            $processData->estatus_op = 1;
            $processData->table_info = $table_info;

        }
        else{
            $processData = new ProcesoData();
            $processData->estatus_op = -1;
            $processData->estatus_candidato_vacante = 0;
            $processData->reclutador = "";
        }

        

        return response()->json(
            $processData
        );
        
    }

    public function processapplicantdataget(Request $request)
    {   
        //0  contratado
        //1  descartado
        //2  en proceso
        $info = DB::table('candidatos_proceso')
            ->where("id","=",$request->id)
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
                ->selectRaw('id, entrevista as entrevistaCV, pruebatecnica as pruebatecnicaCV, pruebapsicometrica as pruebapsicometricaCV, referencias as referenciasCV, entrevista_tecnica as entrevista_tecnicaCV, estudio_socioeconomico as estudio_socioeconomicoCV, estatus, observaciones')
                ->where("id","=",$info[0]->id)
                //->where("candidatos_id","=",$request->id)
                //->where("vacantes_id","=",$info[0]->vacantes_id)
                //->where("estatus","=",2)
                ->get();

                $info_candidato = Applicant::where("idcandidato",$info[0]->candidatos_id)->get();
                $processData->nameCandidato = $info_candidato[0]->nombres." ".$info_candidato[0]->apellidos;
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
                    $processData->observaciones = $info_candidatos_vacante[0]->observaciones;
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
            /*if($request->estatus_candidato == 2){
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
            }*/
            $estatus_proceso = $request->estatus_candidato;

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
                $candidatos_proceso->observaciones = $request->observaciones;

                /*
                $applicant = Applicant::findOrFail($request->candidato_id);
                $applicant->estatus_candidatos = $request->estatus_candidato;
                $applicant->update();*/
                
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
                $candidatos_proceso->observaciones = $request->observaciones;

                if($request->estatus_candidato == 1)
                {
                   /* $applicant = Applicant::findOrFail($request->candidato_id);
                    $applicant->estatus_candidatos = 3;
                    $applicant->update();*/
                }
                
                if($candidatos_proceso->save()){
                    return "1";
                }
                else{
                    return "0";
                }
            }

    }

    public function getPerfiles($id){
        $candidatosperfiles = DB::table('candidatos_perfiles as cp')
        ->selectRaw('cp.id, p.perfil')
        ->join('perfil as p','p.id', '=','cp.perfil_id')
        ->where("cp.candidato_id","=",$id)
        ->orderBy("p.perfil","ASC")
        ->get();
        
        $info_perfiles = "";
        foreach($candidatosperfiles as $cp){
            $ids_perfiles[] = $cp->id;
            $info_perfiles .= "<div class='row' style='display:block;' id='editprof_" . $cp->id . "' >".
            $cp->perfil
            ."<span class='delete_profile_edit' id='" . $cp->id . "' style='font-weight:600; color: red;cursor: pointer;'>X</span>
            </div>";
        }
        return array($info_perfiles, $ids_perfiles);
    }

    public function addPerfil(Request $request){

        $validated = $request->validate([
            'perfil_id' => ['required'],
            'candidato_id' => ['required']
        ]);

        $existe = CandidatoPerfil::where("perfil_id","=",$request->perfil_id)
        ->where("candidato_id","=",$request->candidato_id)->get();

        if(count($existe) > 0){
            return -1;
        }

        $candidatoPerfil = new CandidatoPerfil(); 
        $candidatoPerfil->perfil_id = $request->perfil_id;
        $candidatoPerfil->candidato_id = $request->candidato_id;
        $candidatoPerfil->save();  
        
        $id_perfil = DB::getPdo()->lastInsertId();
        return $id_perfil;
    }

    public function deletePerfil($id)
    {
        try{
            $candidatoPerfil = CandidatoPerfil::findOrFail($id);

            $perfiles = CandidatoPerfil::where("candidato_id","=",$candidatoPerfil->candidato_id)->get();

            if(count($perfiles) == 1){
                return -1;
            }

            if($candidatoPerfil->delete()){
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
}
