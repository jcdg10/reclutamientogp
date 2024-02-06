<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\AdicionalesData;

class RequestAdditionalController extends Controller
{
    public function additionalData(Request $request)
    {   
        if($request->desplazarse == 3){
            $desplazarse_motivo = $request->desplazarse_motivo; 
        }
        else{
            $desplazarse_motivo = '';
        }

        if($request->viajar == 3){
            $viajar_motivo = $request->viajar_motivo; 
        }
        else{
            $viajar_motivo = '';
        }

        if($request->disponibilidad_horario == 3){
            $disponibilidad_horario_motivo = $request->disponibilidad_horario_motivo; 
        }
        else{
            $disponibilidad_horario_motivo = '';
        }

        if($request->personal_cargo == 1){
            $num_personas_cargo = $request->num_personas_cargo; 
        }
        else{
            $num_personas_cargo = 0;
        }
        
        if($request->idAdicional == ''){
            $additionaldata = new AdicionalesData();
            $additionaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $additionaldata = AdicionalesData::findOrFail($request->idAdicional);
        }
        
        $additionaldata->desplazarse = $request->desplazarse;
        $additionaldata->desplazarse_motivo = $desplazarse_motivo;
        $additionaldata->viajar = $request->viajar;
        $additionaldata->viajar_motivo = $viajar_motivo;
        $additionaldata->disponibilidad_horario = $request->disponibilidad_horario;
        $additionaldata->disponibilidad_horario_motivo = $disponibilidad_horario_motivo;
        $additionaldata->personal_cargo = $request->personal_cargo;
        $additionaldata->num_personas_cargo = $num_personas_cargo;
        $additionaldata->persona_reporta = $request->persona_reporta;
        $additionaldata->equipo_computo = $request->equipo_computo;

        if($additionaldata->save()){

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

    public function additionalDataGet($id)
    {   
        $additionalData = AdicionalesData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $additionalData
        );
        
        
    }

    public function additionalDataEdit(Request $request)
    {   
            if($request->desplazarse == 3){
                $desplazarse_motivo = $request->desplazarse_motivo; 
            }
            else{
                $desplazarse_motivo = '';
            }

            if($request->viajar == 3){
                $viajar_motivo = $request->viajar_motivo; 
            }
            else{
                $viajar_motivo = '';
            }

            if($request->disponibilidad_horario == 3){
                $disponibilidad_horario_motivo = $request->disponibilidad_horario_motivo; 
            }
            else{
                $disponibilidad_horario_motivo = '';
            }

            if($request->personal_cargo == 1){
                $num_personas_cargo = $request->num_personas_cargo; 
            }
            else{
                $num_personas_cargo = 0;
            }
            
            if($request->idAdicional == ''){
                $additionaldata = new AdicionalesData();
                $additionaldata->vacantes_id = $request->idRequerimiento;
            }
            else{
                $additionaldata = AdicionalesData::findOrFail($request->idAdicional);
            }
            
            $additionaldata->desplazarse = $request->desplazarse;
            $additionaldata->desplazarse_motivo = $desplazarse_motivo;
            $additionaldata->viajar = $request->viajar;
            $additionaldata->viajar_motivo = $viajar_motivo;
            $additionaldata->disponibilidad_horario = $request->disponibilidad_horario;
            $additionaldata->disponibilidad_horario_motivo = $disponibilidad_horario_motivo;
            $additionaldata->personal_cargo = $request->personal_cargo;
            $additionaldata->num_personas_cargo = $num_personas_cargo;
            $additionaldata->persona_reporta = $request->persona_reporta;
            $additionaldata->equipo_computo = $request->equipo_computo;

            if($additionaldata->save()){

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
