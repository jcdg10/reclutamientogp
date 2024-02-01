<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Support\Facades\File;
use Response;

class ReportController extends Controller
{
    public function index()
    {
        //if(auth()->user()->profile_id == 1){
            $report = DB::table('reporte as r')
            ->selectRaw('r.id, r.reporte, r.ruta, DATE_FORMAT(r.fechalta, "%d-%m-%Y") as fechalta')
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

        return Datatables()->of($report)
        ->addIndexColumn()
        ->addColumn('action', function($report){

            $btn =      '<div class="btn-group dropup dataTablesD">'.
                            '<button type="button" class="without-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="opcionesOp"><span class="descargarReporte operaciones" id="'.$report->id.'" name="'.$report->reporte.'">Descargar</span></li>';

                                $btn.= '<li class="opcionesOp"><span class="eliminarReporte operaciones" id="'.$report->id.'">Eliminar</span></li>';

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
    public function showReport()
    {
        return view('report.index');
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'nombre' => ['required',
                        'string',
                        'max:80'
                        ],
            'archivo' => ['required',
                        'mimes:pdf',
                        'max:5120'
                    ]
        ]);

        $report = new Report();
        $report->reporte = $request->nombre;

        if($request->hasFile('archivo')){
			$file = $request->file('archivo');
            $reporteNombre = time() . '_'. uniqid() . '.' . $request->archivo->extension();
            $file->move(storage_path('app/public/reportes/'),$reporteNombre);
			$report->ruta = $reporteNombre;
		}

        $report->fechalta = Carbon::now();
        $report->fechamod = Carbon::now();
        
        if($report->save()){
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
            $report = Report::findOrFail($id);
            $filename = $report->ruta;

            if($report->delete()){
                if(File::exists(storage_path('app/public/reportes/').$filename)) {
                    File::delete(storage_path('app/public/reportes/').$filename);
                }
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

    public function download($id)
    {
        $report = Report::findOrFail($id);

        $pdfDownload = storage_path('app/public/reportes/') . $report->ruta;

        return response()->download($pdfDownload);

    }
}
