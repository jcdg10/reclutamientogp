<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Carbon\Carbon;
use Datatables;
use DB;

class PerfilController extends Controller
{
    public function index()
    {
        $profile = DB::table('perfil as p')
        ->selectRaw('p.id, p.perfil, p.estatus')
        ->orderBy("p.id","DESC")
        ->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 11)
        ->where(function ($query) {
            $query->where('permiso', '=', 3)
                ->orWhere('permiso', '=', 4);
        })
        ->get();

        $GLOBALS["editar"] = $roles[0]->permitido;
        $GLOBALS["eliminar"] = $roles[1]->permitido;


        return Datatables()->of($profile)
        ->addIndexColumn()
        ->addColumn('state', function($profile){

            if($profile->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($profile->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($profile){

            $btn = '<span style="display:inline-flex;vertical-align: middle;">';
            if($GLOBALS["editar"] == 1 || $GLOBALS["eliminar"] == 1){

                                if($GLOBALS["editar"] == 1){
                                    $btn .=  '<img src="'.url('img/edit-2.svg').'"  class="editar imgEdit toggle" id="'.$profile->id.'" data-toggle="tooltip" data-placement="top" title="Editar" />';
                                }

                                if($GLOBALS["eliminar"] == 1){
                                    if($profile->estatus == 1){
                                        $btn.='<input type="checkbox" id="switch_'.$profile->id.'" /><label class="desactivar" id="lbl_'.$profile->id.'" for="switch_'.$profile->id.'"   data-toggle="tooltip" data-placement="top" title="Inactivar">Toggle</label>';
                                    }
                                    if($profile->estatus == 0){
                                        $btn.='<input type="checkbox" id="switch_'.$profile->id.'" checked /><label class="activar" id="lbl_'.$profile->id.'" for="switch_'.$profile->id.'" data-toggle="tooltip" data-placement="top" title="Activar">Toggle</label>';
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
    public function showPerfil()
    {
        
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 11)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                  ->orWhere('permiso', '=', 2)
                  ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            return view('profile.index')->with(['roles'=>$roles]);  
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

        $profile = new Perfil();
        $profile->perfil = $request->name;
        $profile->estatus = 1;
        
        if($profile->save()){
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
        $profile = Perfil::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        return response()->json(
            $profile
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

        $profile = Perfil::findOrFail($id);
        $profile->perfil = $request->name;

        if($profile->update()){
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
            $profile = Perfil::findOrFail($id);

            if($profile->estatus == 1){
                $profile->estatus = 0;
            }
            else{
                $profile->estatus = 1;
            }
            

            if($profile->update()){
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
