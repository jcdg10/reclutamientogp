<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recruiter;
use Carbon\Carbon;
use Datatables;
use DB;

class RecruiterController extends Controller
{
    public function index()
    {
        //if(auth()->user()->profile_id == 1){
            $recruiters = DB::table('reclutador as r')
            ->selectRaw('r.id, r.nombres, r.apellidos, r.estatus')
            ->get();
        /*}
        if(auth()->user()->profile_id == 2){
            $users = DB::table('users')
            ->selectRaw('users.id, users.name, users.email, profile.name as profile, users.active, franchises.franchise')
            ->join('profile', 'users.profile_id', '=', 'profile.id')
            ->join('franchises', 'users.franchise_id', '=', 'franchises.id')
            ->where('franchise_id','=',auth()->user()->franchise_id)
            ->get();
        }*/

        return Datatables()->of($recruiters)
        ->addIndexColumn()
        ->addColumn('state', function($recruiters){

            if($recruiters->estatus == 1){
                $state = '<div class="badge bg-success-4 hp-bg-dark-success text-success border-success">Activo</div>';
            }
            if($recruiters->estatus == 0){
                $state = '<div class="badge bg-danger-4 hp-bg-dark-danger text-danger border-danger">Inactivo</div>';
            }
        
            return $state;
        })
        ->addColumn('action', function($recruiters){

            $btn =      '<div class="btn-group dropup dataTablesD">'.
                            '<button type="button" class="without-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="opcionesOp"><span class="editar operaciones" id="'.$recruiters->id.'">Editar</span></li>';

                                if($recruiters->estatus == 1){
                                    $btn.= '<li class="opcionesOp"><span class="desactivar operaciones" id="'.$recruiters->id.'">Desactivar</span></li>';
                                }
                                if($recruiters->estatus == 0){
                                    $btn.= '<li class="opcionesOp"><span class="activar operaciones" id="'.$recruiters->id.'">Activar</span></li>';
                                }

                            $btn.=  '</ul>
                        </div>';
        
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
    public function showRecruiter()
    {
        //if(auth()->user()->profile_id == 1){
            return view('recruiter.index');
        /*}
        else{
            $roles = DB::table('profile')->get();
            $franquicias = DB::table('franchises')->where('active','=','1')->get();
            return view('user.index-asesores')->with(['roles'=>$roles,'franquicias'=>$franquicias]);
        }*/
        
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
        ]);

        $recruiter = new Recruiter();
        $recruiter->nombres = $request->names;
        $recruiter->apellidos = $request->lastnames;
        $recruiter->estatus = 1;
        
        if($recruiter->save()){
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
        $recruiter = Recruiter::findOrFail($id);
        /*if(auth()->user()->profile_id == 1){
            $profile = '<option value="0">Selecciona un perfil</option>';
        }*/

        return response()->json(
            $recruiter
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
            'names' => ['required',
                        'string',
                        'max:45'
                        ],
            'lastnames' => ['required',
                        'string',
                        'max:45'
                        ],
        ]);

        $recruiter = Recruiter::findOrFail($id);
        $recruiter->nombres = $request->names;
        $recruiter->apellidos = $request->lastnames;

        if($recruiter->update()){
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
            $recruiter = Recruiter::findOrFail($id);

            if($recruiter->estatus == 1){
                $recruiter->estatus = 0;
            }
            else{
                $recruiter->estatus = 1;
            }
            

            if($recruiter->update()){
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
