<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use DB;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Recruiter;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $applicants = DB::table('cliente as c')
        ->selectRaw('c.id, c.nombres, c.estatus, c.telefono')
        ->orderBy("c.id","DESC")
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 2)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                  ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;

        return Datatables()->of($applicants)
        ->addIndexColumn()
        ->addColumn('state', function($applicants){

            if($applicants->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($applicants->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($applicants){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                if($GLOBALS["editar"] == 1){
                    $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$applicants->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                }

                if($GLOBALS["eliminar"] == 1){
                    if($applicants->estatus == 1){
                        $btn.='<input type="checkbox" id="switch_'.$applicants->id.'" /><label class="desactivar" id="lbl_'.$applicants->id.'" for="switch_'.$applicants->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                    }
                    if($applicants->estatus == 0){
                        $btn.='<input type="checkbox" id="switch_'.$applicants->id.'" checked /><label class="activar" id="lbl_'.$applicants->id.'" for="switch_'.$applicants->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
                    }
                }

            }
            $btn .= '</span>';
            return $btn;
        })
        ->rawColumns(['avatar','state','action'])
        ->make(true);    

        //return Datatables::of($users)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showClient()
    {
        $estados = DB::table('estados_federales')
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 2)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                  ->orWhere('permiso', '=', 2)
                  ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            return view('client.index')->with(['roles'=>$roles, 'estados'=>$estados]);  
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
                            'max:100'
                            ],
                'email' => ['required',
                            'email',
                            'max:255'
                        ],
            ]);

            $client = new Client();
            $client->nombres = $request->names;
            $client->telefono = $request->telefono;
            $client->email = $request->email;
            $client->calle = $request->calle;
            $client->num_int = $request->num_int;
            $client->num_ext = $request->num_ext;
            $client->codigo_postal = $request->codigo_postal;
            $client->ciudad = $request->ciudad;
            $client->estado_id = $request->estado;
            $client->referencia = $request->referencia;
            $client->estatus = 1;
            
            if($client->save()){
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
        $client = Client::findOrFail($id);
        
        /*$recruiter = Recruiter::orderBy('nombres','ASC')->orderBy('apellidos','ASC')
        ->get()->where('estatus','=','1');

        $reclutador = "<option value=''>Selecciona un reclutador</option>";
        foreach($recruiter as $r){
            $reclutador .= "<option value='".$r->id."' ";

            if($r->id == $client->reclutador_id){
                $reclutador .= "selected";
            }
            
            $reclutador .= ">".$r->nombres." ".$r->apellidos."</option>";
        }*/

        $state = DB::table('estados_federales')->get();

        $estados = "<option value=''>Selecciona un estado</option>";
        foreach($state as $s){
            $estados .= "<option value='".$s->id."' ";

            if($s->id == $client->estado_id){
                $estados .= "selected";
            }
            
            $estados .= ">".$s->estado."</option>";
        }

        //$client->recruiter_select = $reclutador;
        $client->state_select = $estados;

        return response()->json(
            $client
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
                            'max:100'
                            ],
                'email' => ['required',
                    'email',
                    'max:255'
                            ],
            ]);

            $client = Client::findOrFail($id);
            $client->nombres = $request->names;
            $client->telefono = $request->telefono;
            $client->email = $request->email;
            $client->calle = $request->calle;
            $client->num_int = $request->num_int;
            $client->num_ext = $request->num_ext;
            $client->codigo_postal = $request->codigo_postal;
            $client->ciudad = $request->ciudad;
            $client->estado_id = $request->estado;
            $client->referencia = $request->referencia;

            if($client->update()){
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
            $client = Client::findOrFail($id);

            if($client->estatus == 1){
                $client->estatus = 0;
            }
            else{
                $client->estatus = 1;
            }
            

            if($client->update()){
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
