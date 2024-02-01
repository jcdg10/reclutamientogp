<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;
use Carbon\Carbon;
use Datatables;
use DB;

class EspecialidadController extends Controller
{
    public function index()
    {
        $specialty = DB::table('especialidad as e')
        ->selectRaw('e.id, e.especialidad, e.estatus')
        ->orderBy("e.id","DESC")
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 8)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;


        return Datatables()->of($specialty)
        ->addIndexColumn()
        ->addColumn('state', function($specialty){

            if($specialty->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($specialty->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($specialty){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                                if($GLOBALS["editar"] == 1){
                                    $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$specialty->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                                }

                                if($GLOBALS["eliminar"] == 1){
                                    if($specialty->estatus == 1){
                                        $btn.='<input type="checkbox" id="switch_'.$specialty->id.'" /><label class="desactivar" id="lbl_'.$specialty->id.'" for="switch_'.$specialty->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                                    }
                                    if($specialty->estatus == 0){
                                        $btn.='<input type="checkbox" id="switch_'.$specialty->id.'" checked /><label class="activar" id="lbl_'.$specialty->id.'" for="switch_'.$specialty->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
                                    }
                                }

                                $btn.=  '</span>';
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
    public function showEspecialidad()
    {
        
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 8)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                  ->orWhere('permiso', '=', 2)
                  ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            return view('specialty.index')->with(['roles'=>$roles]);  
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

        $specialty = new Especialidad();
        $specialty->especialidad = $request->name;
        $specialty->estatus = 1;
        
        if($specialty->save()){
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
        $specialty = Especialidad::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        return response()->json(
            $specialty
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

        $specialty = Especialidad::findOrFail($id);
        $specialty->especialidad = $request->name;

        if($specialty->update()){
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
            $specialty = Especialidad::findOrFail($id);

            if($specialty->estatus == 1){
                $specialty->estatus = 0;
            }
            else{
                $specialty->estatus = 1;
            }
            

            if($specialty->update()){
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
