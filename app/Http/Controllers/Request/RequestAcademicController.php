<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\Requirement\AcademicData;
use App\Models\Requirement\AcademicIdiomsData;
use App\Models\Requirement\AcademicCertificadosData;

class RequestAcademicController extends Controller
{
    public function academicData(Request $request)
    {   
            
        $validated = $request->validate([
            'escolaridad' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idAcademico == ''){
            $academicdata = new AcademicData();
            $academicdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $academicdata = AcademicData::findOrFail($request->idAcademico);
        }
        
        $academicdata->escolaridad = $request->escolaridad;
        

        if($academicdata->save()){

            if($request->idAcademico == ''){
                $idAcademico = $academicdata->id;
            }
            else{
                $idAcademico = $request->idAcademico;

                $result=AcademicCertificadosData::where('datosacademicos_id','=',$request->idAcademico)->delete();
                $result2=AcademicIdiomsData::where('datosacademicos_id','=',$request->idAcademico)->delete();
            }


            foreach($request->certificado as $cert){

                if(trim($cert) != ''){
                    $certificate = new AcademicCertificadosData();
                    $certificate->certificado = $cert;
                    $certificate->datosacademicos_id = $idAcademico;
                    $certificate->save();
                }
                
            }

            foreach($request->idiom as $idiom){

                if(trim($idiom) != ''){
                    $idioma = new AcademicIdiomsData();
                    $idioma->idioma = $idiom;
                    $idioma->datosacademicos_id = $idAcademico;
                    $idioma->save();
                }
                
            }

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

    public function academicDataGet($id)
    {   
        $academicData = AcademicData::where("vacantes_id", "=", $id)->firstOrFail();

        $academicCertificadosData = AcademicCertificadosData::where("datosacademicos_id", "=", $academicData->id)->get();
        
        $academicIdiomsData = AcademicIdiomsData::where("datosacademicos_id", "=", $academicData->id)->get();

        $cert = 0;
        $certificado_c = '';
        if(count($academicCertificadosData) > 0){
            foreach($academicCertificadosData as $acd){

                if($cert == 0){
                    $certificado_c .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" >
                        <input type="text" class="form-control certificado_class" id="certificado'.$cert.'" name="certificado['.$cert.']" maxlength="100" placeholder="Certificado o curso" value="'.$acd->certificado.'">
                    </div>';
                }
                else{
                    $certificado_c .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" id="delete_'.$cert.'" >
                        <div class="row">
                            <input type="text" class="form-control certificado_class" id="certificado'.$cert.'" name="certificado['.$cert.']" maxlength="100" placeholder="Certificado o curso" value="'.$acd->certificado.'" style="width:80%;">
                            <button type="button" class="btn btn-danger btn-sm deleteCert" id="'.$cert.'" style="width:10%;margin-left:10%;">X</button>
                        </div>
                    </div>';
                }
                $cert++;

            }
        }
        $academicData->certificado_select = $certificado_c;
        $academicData->certificado_num = $cert;

        $idi = 0;
        $idioms = '';
        if(count($academicIdiomsData) > 0){
            foreach($academicIdiomsData as $aid){

                if($idi == 0){
                    $idioms .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;">
                        <input type="text" class="form-control idiom_class" id="idiom'.$idi.'" name="idiom['.$idi.']" maxlength="100" placeholder="Idioma" value="'.$aid->idioma.'">
                    </div>';
                }
                else{
                    $idioms .= '
                    <div class="row" style="margin-bottom: 5px;margin-right:5px;" id="deleteidiom_'.$idi.'">
                        <div class="row">
                            <input type="text" class="form-control idiom_class" id="idiom'.$idi.'" name="idiom['.$idi.']" maxlength="100" placeholder="Idioma" value="'.$aid->idioma.'" style="width:80%;">
                            <button type="button" class="btn btn-danger btn-sm deleteIdiom" id="'.$idi.'" style="width:10%;margin-left:10%;">X</button>
                        </div>
                    </div>';
                }
                
                $idi++;
            }
        }
        $academicData->idiom_select = $idioms;
        $academicData->idiom_num = $idi;

        return response()->json(
            $academicData
        );
        
        
    }

    //falta
    public function academicDataEdit(Request $request)
    {   
        $validated = $request->validate([
            'escolaridad' => ['required',
                        'max:100'
            ]
        ]);

        if($request->idAcademico == ''){
            $academicdata = new AcademicData();
            $academicdata->vacantes_id = $request->idRequerimiento;
        }
        else{
            $academicdata = AcademicData::findOrFail($request->idAcademico);
        }
        
        $academicdata->escolaridad = $request->escolaridad;
        

        if($academicdata->save()){

            if($request->idAcademico == ''){
                $idAcademico = $academicdata->id;
            }
            else{
                $idAcademico = $request->idAcademico;

                $result=AcademicCertificadosData::where('datosacademicos_id','=',$request->idAcademico)->delete();
                $result2=AcademicIdiomsData::where('datosacademicos_id','=',$request->idAcademico)->delete();
            }


            foreach($request->certificado as $cert){

                if(trim($cert) != ''){
                    $certificate = new AcademicCertificadosData();
                    $certificate->certificado = $cert;
                    $certificate->datosacademicos_id = $idAcademico;
                    $certificate->save();
                }
                
            }

            foreach($request->idiom as $idiom){

                if(trim($idiom) != ''){
                    $idioma = new AcademicIdiomsData();
                    $idioma->idioma = $idiom;
                    $idioma->datosacademicos_id = $idAcademico;
                    $idioma->save();
                }
                
            }

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
