<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\GeneralData;
use App\Models\ServicioRequerido;
use App\Models\User;
use DB;

class RequestGeneralController extends Controller
{
    public function generalData(Request $request)
    {   
        $validated = $request->validate([
            'position' => ['required',
                        'max:100'
            ],
            'numVacant' => ['required'
            ],
            'requestDate' => ['required'
            ],
        ]);

        if($request->idGeneralUnico == ''){
            $generaldata = new GeneralData();
            $generaldata->vacantes_id = $request->idRequerimiento;
            $generaldata->ejecutivoen = $request->executiveInCharge;
        }
        else{
            $generaldata = GeneralData::findOrFail($request->idGeneralUnico);
        }

        
        $generaldata->puesto = $request->position;
        $generaldata->novacantes = $request->numVacant;
        $generaldata->fechasolicitud = $request->requestDate;
        $generaldata->serviciore = $request->requestService;
        $generaldata->tiemasignacion = $request->asignmentTime;
        $generaldata->cantidadtiempo = $request->time;
        $generaldata->modalidad = $request->modality;
        $generaldata->horario_inicio = $request->timeBegin;
        $generaldata->horario_fin = $request->timeEnd;
        
        if($generaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }

    public function generalDataGet($id)
    {   
        $generalData = GeneralData::where("vacantes_id", "=", $id)->firstOrFail();

        $request_service = ServicioRequerido::orderBy('servicio','ASC')
        ->where('estatus','=','1')->orWhere("id","=",$generalData->serviciore)->get();
        $modalidad = DB::table('modalidad')->get();

        $request_servicec = "";
        foreach($request_service as $rs){
            $request_servicec .= "<option value='".$rs->id."' ";

            if($rs->id == $generalData->serviciore){
                $request_servicec .= "selected";
            }
            
            $request_servicec .= ">".$rs->servicio."</option>";
        }

        $generalData->require_service_select = $request_servicec;

        $modalidad_c = "";
        foreach($modalidad as $m){
            $modalidad_c .= "<option value='".$m->id."' ";

            if($m->id == $generalData->modalidad){
                $modalidad_c .= "selected";
            }
            
            $modalidad_c .= ">".$m->modalidad."</option>";
        }
        $generalData->modalidad_select = $modalidad_c;

        $executive = User::where("id","=",$generalData->ejecutivoen)->firstOrFail();
        $generalData->ejecutivoen = $executive->name;

        return response()->json(
            $generalData
        );
        
        
    }

    public function generalDataEdit(Request $request)
    {   

        $validated = $request->validate([
            'position' => ['required',
                        'max:100'
            ],
            'numVacant' => ['required'
            ],
            'requestDate' => ['required'
            ],
        ]);

        if($request->idGeneralUnico == ''){
            $generaldata = new GeneralData();
            $generaldata->vacantes_id = $request->idRequerimiento;
            $generaldata->ejecutivoen = $request->executiveInCharge;
        }
        else{
            $generaldata = GeneralData::findOrFail($request->idGeneralUnico);
        }

        
        $generaldata->puesto = $request->position;
        $generaldata->novacantes = $request->numVacant;
        $generaldata->fechasolicitud = $request->requestDate;
        $generaldata->serviciore = $request->requestService;
        $generaldata->tiemasignacion = $request->asignmentTime;
        $generaldata->cantidadtiempo = $request->time;
        $generaldata->modalidad = $request->modality;
        $generaldata->horario_inicio = $request->timeBegin;
        $generaldata->horario_fin = $request->timeEnd;

                

        
        if($generaldata->save()){

            $requerimiento = Requerimiento::findOrFail($request->idRequerimiento);
            if($requerimiento->estatus_vacante == 2){
                $requerimiento->estatus_vacante = 1;
                $requerimiento->update();
            }

            return 1;
        }
        else{
            return 0;
        }
            
    }
}
