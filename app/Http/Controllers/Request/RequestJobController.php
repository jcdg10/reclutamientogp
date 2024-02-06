<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\PuestoData;

class RequestJobController extends Controller
{
    public function jobData(Request $request)
    {   
        $validated = $request->validate([
            'experience' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPuesto == ''){
            $jobdata = new PuestoData();
            $jobdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $jobdata = PuestoData::findOrFail($request->idPuesto);
        }
        
        $jobdata->experiencia = $request->experience;
        $jobdata->actividades = $request->activities;
        $jobdata->conocimientos_tecnicos = $request->technical_knowledge;
        $jobdata->competencias_necesarias = $request->necessary_skills;
        
        if($jobdata->save()){

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

    public function jobDataGet($id)
    {   
        $jobData = PuestoData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $jobData
        );
        
        
    }

    public function jobDataEdit(Request $request)
    {   
            $validated = $request->validate([
                'experience' => ['required',
                            'max:100'
                ]
            ]);

            if($request->idPuesto == ''){
                $jobdata = new PuestoData();
                $jobdata->vacantes_id = $request->idRequerimiento;
            }
            else{
                $jobdata = PuestoData::findOrFail($request->idPuesto);
            }
            
            $jobdata->experiencia = $request->experience;
            $jobdata->actividades = $request->activities;
            $jobdata->conocimientos_tecnicos = $request->technical_knowledge;
            $jobdata->competencias_necesarias = $request->necessary_skills;
            
            if($jobdata->save()){

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
