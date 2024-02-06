<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\ProcesoData;

class RequestProcessController extends Controller
{

    public function processData(Request $request)
    {   
        $validated = $request->validate([
            'duracion' => ['required',
                        'max:100'
            ],
        ]);

        if($request->idProceso == ''){
            $processdata = new ProcesoData();
        }
        else{
            $processdata = ProcesoData::findOrFail($request->idProceso);
        }            
        
        $processdata->duracion = $request->duracion;
        $processdata->cantidadfiltros = $request->cantidadfiltros;
        $processdata->niveles_flitro = $request->niveles_flitro;
        $processdata->entrevista = $request->entrevista;
        $processdata->pruebatecnica = $request->pruebat;
        $processdata->pruebapsicometrica = $request->pruebap;
        $processdata->referencias = $request->referencias;
        $processdata->entrevista_tecnica = $request->entrevista_tecnica;
        $processdata->estudio_socioeconomico = $request->estudio_socioeconomico;

        if($request->idProceso == ''){
            $processdata->vacantes_id = $request->idRequerimiento;
        }

        if($processdata->save()){

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

    public function processDataGet($id)
    {   
        $processData = ProcesoData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $processData
        );
        
        
    }

    public function processDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'duracion' => ['required',
                        'max:100'
            ],
        ]);

        if($request->idProceso == ''){
            $processdata = new ProcesoData();
        }
        else{
            $processdata = ProcesoData::findOrFail($request->idProceso);
        }            
        
        $processdata->duracion = $request->duracion;
        $processdata->cantidadfiltros = $request->cantidadfiltros;
        $processdata->niveles_flitro = $request->niveles_flitro;
        $processdata->entrevista = $request->entrevista;
        $processdata->pruebatecnica = $request->pruebat;
        $processdata->pruebapsicometrica = $request->pruebap;
        $processdata->referencias = $request->referencias;
        $processdata->entrevista_tecnica = $request->entrevista_tecnica;
        $processdata->estudio_socioeconomico = $request->estudio_socioeconomico;

        if($request->idProceso == ''){
            $processdata->vacantes_id = $request->idRequerimiento;
        }

        if($processdata->save()){

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
