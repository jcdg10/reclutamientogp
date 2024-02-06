<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\EconomicaData;

class RequestEconomicController extends Controller
{
    public function economicData(Request $request)
    {   
        $validated = $request->validate([
            'esquemacontratacion' => ['required',
                        'max:100'
            ],
            'montominimo' => ['required'],
            'montomaximo' => ['required']
        ]);

        if($request->idEconomico == ''){
            $economicdata = new EconomicaData();
        }
        else{
            $economicdata = EconomicaData::findOrFail($request->idEconomico);
        }

        $montominimo = str_replace("$", "", $request->montominimo);
        $montominimo = str_replace(",", "", $montominimo);
        $montomaximo = str_replace("$", "", $request->montomaximo);
        $montomaximo = str_replace(",", "", $montomaximo);
        
        $economicdata->esquemacontratacion = $request->esquemacontratacion;
        $economicdata->tiposalario = $request->tiposalario;
        $economicdata->montominimo = $montominimo;
        $economicdata->montomaximo = $montomaximo;
        $economicdata->jornadalaboral = $request->jornadalaboral;
        $economicdata->prestaciones_beneficios = $request->prestaciones_beneficios;

        if($request->idEconomico == ''){
            $economicdata->vacantes_id = $request->idRequerimiento;
        }

        if($economicdata->save()){

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

    public function economicDataGet($id)
    {   
        $economicData = EconomicaData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $economicData
        );
        
        
    }

    public function economicDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'esquemacontratacion' => ['required',
                        'max:100'
            ],
            'montominimo' => ['required'],
            'montomaximo' => ['required']
        ]);

        if($request->idEconomico == ''){
            $economicdata = new EconomicaData();
        }
        else{
            $economicdata = EconomicaData::findOrFail($request->idEconomico);
        }

        $montominimo = str_replace("$", "", $request->montominimo);
        $montominimo = str_replace(",", "", $montominimo);
        $montomaximo = str_replace("$", "", $request->montomaximo);
        $montomaximo = str_replace(",", "", $montomaximo);
        
        $economicdata->esquemacontratacion = $request->esquemacontratacion;
        $economicdata->tiposalario = $request->tiposalario;
        $economicdata->montominimo = $montominimo;
        $economicdata->montomaximo = $montomaximo;
        $economicdata->jornadalaboral = $request->jornadalaboral;
        $economicdata->prestaciones_beneficios = $request->prestaciones_beneficios;

        if($request->idEconomico == ''){
            $economicdata->vacantes_id = $request->idRequerimiento;
        }

        if($economicdata->save()){

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
