<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use Response;
use Datatables;
use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index()
    {
        $report = DB::table('vacantes as v')
        ->selectRaw('*')
        ->where('v.estatus','=','5')
        ->get();

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

    public function searchReport(Request $request)
    {
        /*echo $request->requerimiento."//--";
        echo $request->responsable."//--";
        echo $request->fecha."//--";
        echo $request->estatus."//--";*/
        $requerimiento = trim($request->requerimiento);
        $responsable = $request->responsable;
        $fecha = $request->fecha;
        $estatus = $request->estatus;
        
        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        $request = DB::table('vacantes as v')
        ->selectRaw('v.id, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fechaalta,v.fecha_vacante_cubierta, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta_norm, dg.puesto, v.estatus_vacante as estatus_vacante_in, ev.color, ev.estatus as estatus_vacante_or,"Ventas" as ubicacion, u.name as responsable, COUNT(cp.id) as numero_candidatos')
        ->leftjoin('datosgenerales as dg','dg.vacantes_id','=','v.id')
        ->leftjoin('users as u','u.id','=','v.reclutador_id')
        ->leftjoin('estatus_vacantes as ev','ev.id','=','v.estatus_vacante')
        ->leftjoin('candidatos_proceso as cp','cp.vacantes_id','=','v.id')
        ->when($requerimiento, function ($query, $requerimiento) {
            return $query->where('dg.puesto',"=",$requerimiento);
        })
        ->when($responsable, function ($query, $responsable) {
            return $query->where('v.reclutador_id',"=",$responsable);
        })
        ->when($fecha, function ($query, $fecha) {
            return $query->where('v.fechaalta',"LIKE",$fecha."%");
        })
        ->when($estatus, function ($query, $estatus) {
            return $query->where('v.estatus_vacante',"=",$estatus);
        })
        ->orderBy("v.id","DESC")
        ->groupBy('v.id')
        ->get();

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        return Datatables()->of($request)
        ->addIndexColumn()
        ->addColumn('dias_transcurridos', function($requerimientos){
            
            if($requerimientos->fecha_vacante_cubierta != null || $requerimientos->fecha_vacante_cubierta != ''){
                $date1 = new DateTime($requerimientos->fechaalta_norm);
                $date2 = new DateTime($requerimientos->fecha_vacante_cubierta);
                $interval = $date1->diff($date2);
            }
            else{
                $date1 = new DateTime($requerimientos->fechaalta_norm);
                $date2 = new DateTime(Carbon::now());
                $interval = $date1->diff($date2);
            }
        
            return $interval->days;
        })
        ->addColumn('estatus_vacante', function($request){

            if(auth()->user()->roles_id == 4){
                if($request->estatus_vacante_in == 1){
                    $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">Nuevo requerimiento</div>';
                }
                else{
                    $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">'.$request->estatus_vacante_or.'</div>';
                }
                
            }
            else{
                $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">'.$request->estatus_vacante_or.'</div>';
            }
            
    
            return $state;
        })
        ->rawColumns(['dias_transcurridos','estatus_vacante'])
        ->make(true);    
    }

    public function searchDataChart(Request $request)
    {
        $requerimiento = trim($request->requerimiento);
        $responsable = $request->responsable;
        $fecha = $request->fecha;
        $estatus = $request->estatus;
        /*
        {
        name: "Responsable requerimiento 1",
        categories: ["Dias Transcurridos", "Candidatos asignados"]
        }, {
        name: "Responsable requerimiento 2",
        categories: ["Dias Transcurridos", "Candidatos asignados"]
        },
        {
        name: "Responsable requerimiento 3",
        categories: ["Dias Transcurridos", "Candidatos asignados"]
        }, {
        name: "Responsable requerimiento 4",
        categories: ["Dias Transcurridos", "Candidatos asignados"]
        },
        {
        name: "Responsable requerimiento 5",
        categories: ["Dias Transcurridos", "Candidatos asignados"]
        }*/

        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        $request = DB::table('vacantes as v')
        ->selectRaw('v.id, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fechaalta,v.fecha_vacante_cubierta, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta_norm, dg.puesto, v.estatus_vacante as estatus_vacante_in, ev.color, ev.estatus as estatus_vacante_or,"Ventas" as ubicacion, u.name as responsable, COUNT(cp.id) as numero_candidatos')
        ->leftjoin('datosgenerales as dg','dg.vacantes_id','=','v.id')
        ->leftjoin('users as u','u.id','=','v.reclutador_id')
        ->leftjoin('estatus_vacantes as ev','ev.id','=','v.estatus_vacante')
        ->leftjoin('candidatos_proceso as cp','cp.vacantes_id','=','v.id')
        ->when($requerimiento, function ($query, $requerimiento) {
            return $query->where('dg.puesto',"=",$requerimiento);
        })
        ->when($responsable, function ($query, $responsable) {
            return $query->where('v.reclutador_id',"=",$responsable);
        })
        ->when($fecha, function ($query, $fecha) {
            return $query->where('v.fechaalta',"LIKE",$fecha."%");
        })
        ->when($estatus, function ($query, $estatus) {
            return $query->where('v.estatus_vacante',"=",$estatus);
        })
        ->groupBy('v.id')
        ->take(5)
        ->get();

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        $jsonXasis = [];
        $jsonValues = [];
        
        foreach($request as $r){
            $jsonArray = 
            [
                "name" => $r->responsable.' '.$r->puesto,
                "categories"=> ["Dias Transcurridos", "Candidatos asignados"]
            ];
            array_push($jsonXasis, $jsonArray);

            $tag = "Días transcurridos";

            if($r->fecha_vacante_cubierta != null || $r->fecha_vacante_cubierta != ''){
                $date1 = new DateTime($r->fechaalta_norm);
                $date2 = new DateTime($r->fecha_vacante_cubierta);
                $interval = $date1->diff($date2);
            }
            else{
                $date1 = new DateTime($r->fechaalta_norm);
                $date2 = new DateTime(Carbon::now());
                $interval = $date1->diff($date2);
            }

            $valor = $interval->days;

            $jsonArray2 = 
            [
                "name" => $tag,
                "y"=> $valor
            ];
            array_push($jsonValues, $jsonArray2);

            $tag = "Candidatos asignados";
            $valor = $r->numero_candidatos;

            $jsonArray2 = 
            [
                "name" => $tag,
                "y"=> $valor
            ];
            array_push($jsonValues, $jsonArray2);
        }
            

        //$myJSON = json_encode($jsonXasis);

        return Response::json(array(
            'jsonXasis' => $jsonXasis,
            'jsonValues' => $jsonValues
        ));

        /*
            [
                {
                    name: ,
                    y: <?php  echo 5; ?>,
                },
                {
                    name: "Candidatos asignados",
                    y: <?php  echo 4; ?>,
                },
                {
                    name: "Requerimiento 3",
                    y: <?php  echo 3; ?>,
                },
                {
                    name: "Requerimiento 4",
                    y: <?php  echo 2; ?>,
                },
                {
                    name: "Requerimiento 5",
                    y: <?php  echo 2; ?>,
                },
                {
                    name: "Requerimiento 1",
                    y: <?php  echo 5; ?>,
                },
                {
                    name: "Requerimiento 2",
                    y: <?php  echo 4; ?>,
                },
                {
                    name: "Requerimiento 3",
                    y: <?php  echo 3; ?>,
                },
                {
                    name: "Requerimiento 4",
                    y: <?php  echo 2; ?>,
                },
                {
                    name: "Requerimiento 5",
                    y: <?php  echo 2; ?>,
                }
            ]
        }*/
        /*
        config()->set('database.connections.mysql.strict', false);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        $request = DB::table('vacantes as v')
        ->selectRaw('v.id, DATE_FORMAT(v.fechaalta, "%d-%m-%Y") as fechaalta,v.fecha_vacante_cubierta, DATE_FORMAT(v.fechaalta, "%Y-%m-%d") as fechaalta_norm, dg.puesto, v.estatus_vacante as estatus_vacante_in, ev.color, ev.estatus as estatus_vacante_or,"Ventas" as ubicacion, u.name as responsable, COUNT(cp.id) as numero_candidatos')
        ->leftjoin('datosgenerales as dg','dg.vacantes_id','=','v.id')
        ->leftjoin('users as u','u.id','=','v.reclutador_id')
        ->leftjoin('estatus_vacantes as ev','ev.id','=','v.estatus_vacante')
        ->leftjoin('candidatos_proceso as cp','cp.vacantes_id','=','v.id')
        ->when($requerimiento, function ($query, $requerimiento) {
            return $query->where('v.id',"=",$requerimiento);
        })
        ->when($responsable, function ($query, $responsable) {
            return $query->where('v.reclutador_id',"=",$responsable);
        })
        ->when($fecha, function ($query, $fecha) {
            return $query->where('v.fechaalta',"LIKE",$fecha."%");
        })
        ->when($estatus, function ($query, $estatus) {
            return $query->where('v.estatus_vacante',"=",$estatus);
        })
        ->groupBy('v.id')
        ->get();

        config()->set('database.connections.mysql.strict', true);
        \DB::reconnect(); //important as the existing connection if any would be in strict mode

        return Datatables()->of($request)
        ->addIndexColumn()
        ->addColumn('dias_transcurridos', function($requerimientos){
            
            if($requerimientos->fecha_vacante_cubierta != null || $requerimientos->fecha_vacante_cubierta != ''){
                $date1 = new DateTime($requerimientos->fechaalta_norm);
                $date2 = new DateTime($requerimientos->fecha_vacante_cubierta);
                $interval = $date1->diff($date2);
            }
            else{
                $date1 = new DateTime($requerimientos->fechaalta_norm);
                $date2 = new DateTime(Carbon::now());
                $interval = $date1->diff($date2);
            }
        
            return $interval->days;
        })
        ->addColumn('estatus_vacante', function($request){

            if(auth()->user()->roles_id == 4){
                if($request->estatus_vacante_in == 1){
                    $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">Nuevo requerimiento</div>';
                }
                else{
                    $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">'.$request->estatus_vacante_or.'</div>';
                }
                
            }
            else{
                $state = '<div class="badge bg-'.$request->color.'-4 hp-bg-dark-'.$request->color.' text-'.$request->color.' border-'.$request->color.'">'.$request->estatus_vacante_or.'</div>';
            }
            
    
            return $state;
        })
        ->rawColumns(['dias_transcurridos','estatus_vacante'])
        ->make(true);    */
       /* data: [
            {
                name: 'En proceso',
                y: <?php  echo 5; ?>,
            },
            {
                name: 'Pendientes',
                y: <?php  echo 4; ?>,
            },
            {
                name: 'Contratado',
                y: <?php  echo 3; ?>,
            },
            {
                name: 'Descartado',
                y: <?php  echo 2; ?>,
            },
            {
                name: 'Nuevo',
                y: <?php  echo 2; ?>,
            }
        ]*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showReport()
    {
        $estatus_vacantes = DB::table('estatus_vacantes')->get();
        $reclutador = DB::table('users')->orderBy('name','ASC')
            ->where('roles_id','=','3')->where('status','=','1')->get();
        $vacantes = DB::table('vacantes as v')
        ->selectRaw('v.id, dg.puesto ')
        ->join('datosgenerales as dg','dg.vacantes_id', '=','v.id')
        ->orderBy('dg.puesto','ASC')
        ->where('v.estatus','=','1')->get();

        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 5)
        ->where(function ($query) {
            $query->where('permiso', '=', 1)
                  ->orWhere('permiso', '=', 5);
        })
        ->get();

        if($roles[0]->permitido == 1){
            return view('report.index')->with(['roles'=>$roles,'estatus_vacantes'=>$estatus_vacantes,'reclutador'=>$reclutador,'vacantes'=>$vacantes]);
        }
        else{
            
            return redirect('/');
        }
        
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
