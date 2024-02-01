<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicioRequerido;
use Carbon\Carbon;
use Datatables;
use DB;

class ServicioRequeridoController extends Controller
{
    public function index()
    {
        $service = DB::table('servicio_requerido as sr')
        ->selectRaw('sr.id, sr.servicio, sr.estatus')
        ->orderBy("sr.id","DESC")
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 9)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                  ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;

        return Datatables()->of($service)
        ->addIndexColumn()
        ->addColumn('state', function($service){

            if($service->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($service->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($service){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                                if($GLOBALS["editar"] == 1){
                                    $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$service->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                                }

                                if($GLOBALS["eliminar"] == 1){
                                    if($service->estatus == 1){
                                        $btn.='<input type="checkbox" id="switch_'.$service->id.'" /><label class="desactivar" id="lbl_'.$service->id.'" for="switch_'.$service->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                                    }
                                    if($service->estatus == 0){
                                        $btn.='<input type="checkbox" id="switch_'.$service->id.'" checked /><label class="activar" id="lbl_'.$service->id.'" for="switch_'.$service->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
                                    }
                                }

                                $btn.=  '</ul>
                            </div>';
            }
        
            return $btn;
        })
        ->rawColumns(['state','action'])
        ->make(true);    

        //return Datatables::of($users)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showServicioRequerido()
    {
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 9)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                    ->orWhere('permiso', '=', 2)
                    ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            return view('required_service.index')->with(['roles'=>$roles]);  
        }
        else{
            
            return redirect('/');
        }
        
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => ['required',
                        'string',
                        'max:100'
                        ]
        ]);

        $requiredservice = new ServicioRequerido();
        $requiredservice->servicio = $request->name;
        $requiredservice->estatus = 1;
        
        if($requiredservice->save()){
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
        $requiredservice = ServicioRequerido::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        return response()->json(
            $requiredservice
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
            'name' => ['required',
                        'string',
                        'max:45'
                        ]
        ]);

        $requiredservice = ServicioRequerido::findOrFail($id);
        $requiredservice->servicio = $request->name;

        if($requiredservice->update()){
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
            $requiredservice = ServicioRequerido::findOrFail($id);

            if($requiredservice->estatus == 1){
                $requiredservice->estatus = 0;
            }
            else{
                $requiredservice->estatus = 1;
            }
            

            if($requiredservice->update()){
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
