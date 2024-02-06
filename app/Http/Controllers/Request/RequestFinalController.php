<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\FinalData;

class RequestFinalController extends Controller
{
    public function finalData(Request $request)
    {   
        if($request->idFinal == ''){
            $finaldata = new FinalData();
        }
        else{
            $finaldata = FinalData::findOrFail($request->idFinal);
        }
        
        $finaldata->razonnocontratacion = $request->razonnocontratacion;
        $finaldata->fechacontratacion = $request->fechacontratacion;
        if($request->idFinal == ''){
            $finaldata->vacantes_id = $request->idRequerimiento;
        }

        if($finaldata->save()){

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

    public function finalDataGet($id)
    {   
        $finalData = FinalData::where("vacantes_id", "=", $id)->firstOrFail();

        return response()->json(
            $finalData
        );
        
        
    }

    public function finalDataEdit(Request $request)
    {   

        if($request->idFinal == ''){
            $finaldata = new FinalData();
        }
        else{
            $finaldata = FinalData::findOrFail($request->idFinal);
        }
        
        $finaldata->razonnocontratacion = $request->razonnocontratacion;
        $finaldata->fechacontratacion = $request->fechacontratacion;
        if($request->idFinal == ''){
            $finaldata->vacantes_id = $request->idRequerimiento;
        }

        if($finaldata->save()){

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
