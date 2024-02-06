<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\PersonalData;

class RequestPersonalController extends Controller
{
    public function personalData(Request $request)
    {   
        $validated = $request->validate([
            'rangeAge' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPersonal == ''){
            $personaldata = new PersonalData();
            $personaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $personaldata = PersonalData::findOrFail($request->idPersonal);
        }
        
        $personaldata->rangoedad = $request->rangeAge;
        $personaldata->sexo = $request->sex;
        $personaldata->estadocivil = $request->civilstate;
        $personaldata->lugarresidencia = $request->residencePlace;
        
        if($personaldata->save()){

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

    public function personalDataGet($id)
    {   
        $personalData = PersonalData::where("vacantes_id", "=", $id)->firstOrFail();

        $estado_civiles = DB::table('estados_civiles')->get();

        $estado_civiles_c = "";
        foreach($estado_civiles as $ec){
            $estado_civiles_c .= "<option value='".$ec->id."' ";

            if($ec->id == $personalData->estadocivil){
                $estado_civiles_c .= "selected";
            }
            
            $estado_civiles_c .= ">".$ec->estados_civiles."</option>";
        }

        $personalData->estados_civiles_select = $estado_civiles_c; 

        if($personalData->sexo == 1){
            $sexo = '<option value="1" selected>Femenino</option>';
        }
        else{
            $sexo = '<option value="1">Femenino</option>';
        }

        if($personalData->sexo == 2){
            $sexo .= '<option value="2" selected>Masculino</option>';
        }
        else{
            $sexo .= '<option value="2">Masculino</option>';
        }

        if($personalData->sexo == 3){
            $sexo .= '<option value="3" selected>Indiferente</option>';
        }
        else{
            $sexo .= '<option value="3">Indiferente</option>';
        }
    
        $personalData->sexo_select = $sexo;

        return response()->json(
            $personalData
        );
        
        
    }

    public function personalDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'rangeAge' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idPersonal == ''){
            $personaldata = new PersonalData();
            $personaldata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $personaldata = PersonalData::findOrFail($request->idPersonal);
        }
        
        $personaldata->rangoedad = $request->rangeAge;
        $personaldata->sexo = $request->sex;
        $personaldata->estadocivil = $request->civilstate;
        $personaldata->lugarresidencia = $request->residencePlace;
        
        if($personaldata->save()){

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
