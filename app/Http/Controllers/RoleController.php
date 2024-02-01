<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permissions;

class RoleController extends Controller
{
    public function showRole()
    {
        $roles = DB::table('permisos')
        ->where('rol_id','=', auth()->user()->roles_id)
        ->where('modulo_id','=', 10)
        ->where('permiso', '=', 1)
        ->get();

        if($roles[0]->permitido == 1){
            $roles_det = DB::table('roles')->get();
            return view('role.index')->with(['roles_det'=>$roles_det]);
        }
        else{
            return redirect('/');
        }
        
    }

    public function getPermisosModulo(Request $request,$id)
    {

        $modulos =  DB::table('modulos')->where('activo','=',1)->get();
        $permisos =  DB::table('permisos')
                    ->where('modulo_id','=',$request->modulo)
                    ->where('rol_id','=',$id)
                    ->get();
        $permisosarray = json_decode($permisos, true);

        $permisosmodulos = '
            <div class="col-md-3">
                <div class="mb-3">
                    <h5 style="margin-bottom: 15px;">Seleccione un módulo:</h5>';

                    foreach($modulos as $m){
                        // $m->id.'///'.$request->modulo."<br>";
                        $permisosmodulos .= '<button role="button" class="mt-2 button-28 ';
                        
                        if($m->id == $request->modulo){
                           // echo "aqui algo rara pasa";
                            $permisosmodulos .= 'active-uniq';
                        }
                        
                        $permisosmodulos .= '" onclick="cargarRolPermiso('.$m->id.')">'.$m->nombre.'</a></button><br>';
                    }
            
            $permisosmodulos .= '
            
                </div>
            </div>
            <div class="col-md-9">
                <h5>Seleccione los permisos par cada módulo:</h5><br>
                
                <table>
                    <tr>
                        <th>Consultar</th>
                        <th>Agregar</th>
                        <th>Editar</th>
                        <th>Activar/Inactivar</th>
                        <th>Descargar</th>
                        <th>Validar</th>
                    </tr>
                    <tr style="height:535px;">
                        ';
                if($request->modulo != 10 && $request->modulo != 4){
                    for($x = 1;$x <= 5; $x++){
                        $permisosmodulos .= '
                        <td>
                            <input type="checkbox" class="form-check-input" id="Check'.$x.'"';
                            
                            if($permisosarray[$x-1]['permitido'] == 1){
                                $permisosmodulos .= 'checked';
                            }

                            $permisosmodulos .= '
                            >';
                           /* <label class="form-check-label" for="exampleCheck1">';

                            if($x == 1){
                                $permisosmodulos .= 'Consultar';
                            }
                            if($x == 2){
                                $permisosmodulos .= 'Agregar';
                            }
                            if($x == 3){
                                $permisosmodulos .= 'Editar';
                            }
                            if($x == 4){
                                $permisosmodulos .= 'Eliminar';
                            }
                            </label>*/
                        $permisosmodulos .= '
                            
                        </td>';

                    }
                }
                if($request->modulo == 4){
                    for($x = 1;$x <= 6; $x++){
                        $permisosmodulos .= '
                        <td>
                            <input type="checkbox" class="form-check-input" id="Check'.$x.'"';
                            
                            if($permisosarray[$x-1]['permitido'] == 1){
                                $permisosmodulos .= 'checked';
                            }

                            $permisosmodulos .= '
                            >';
                           /* <label class="form-check-label" for="exampleCheck1">';

                            if($x == 1){
                                $permisosmodulos .= 'Consultar';
                            }
                            if($x == 2){
                                $permisosmodulos .= 'Agregar';
                            }
                            if($x == 3){
                                $permisosmodulos .= 'Editar';
                            }
                            if($x == 4){
                                $permisosmodulos .= 'Eliminar';
                            }
                            </label>*/
                        $permisosmodulos .= '
                            
                        </td>';

                    }
                }
                if($request->modulo == 10){

                    for($x = 1;$x <= 1; $x++){
                        $permisosmodulos .= '
                        <td>
                            <input type="checkbox" class="form-check-input" id="Check'.$x.'"';
                            
                            if($permisosarray[$x-1]['permitido'] == 1){
                                $permisosmodulos .= 'checked';
                            }

                            $permisosmodulos .= '
                            >';
                            /*<label class="form-check-label" for="exampleCheck1">';

                            if($x == 1){
                                $permisosmodulos .= 'Consultar';
                            }
                            if($x == 2){
                                $permisosmodulos .= 'Agregar';
                            }
                            if($x == 3){
                                $permisosmodulos .= 'Editar';
                            }
                            if($x == 4){
                                $permisosmodulos .= 'Eliminar';
                            }

                        $permisosmodulos .= '
                            </label>*/
                        $permisosmodulos .= '</tab>';

                    }
                }

            $permisosmodulos .= '
            </tr>
            </table>
            </div>
            <br><br>
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary mt-2 float-start" id="guardarPermisos">Guardar</button>
            </div>';
            

        return response()->json(
            $permisosmodulos
        );
    }

    public function modifyPermissions(Request $request){
        
        $id_rol = $request->id_rol;
        $id_modulo = $request->id_modulo;

        $check1 = $request->check1;
        if($id_modulo != 10){
            $check2 = $request->check2;
            $check3 = $request->check3;
            $check4 = $request->check4;
            $check5 = $request->check5;
        }
        
        

        $permisobus1 = Permissions::where('rol_id','=',$id_rol)
        ->where('modulo_id','=',$id_modulo)
        ->where('permiso','=',1)
        ->first();
        $permiso1 = Permissions::findOrFail($permisobus1->id);
        $permiso1->permitido = $check1;
        $permiso1->update();

        if($id_modulo != 10){
            $permisobus2 = Permissions::where('rol_id','=',$id_rol)
            ->where('modulo_id','=',$id_modulo)
            ->where('permiso','=',2)
            ->first(); 
            $permiso2 = Permissions::findOrFail($permisobus2->id);
            $permiso2->permitido = $check2;
            $permiso2->update();

            $permisobus3 = Permissions::where('rol_id','=',$id_rol)
            ->where('modulo_id','=',$id_modulo)
            ->where('permiso','=',3)
            ->first();
            $permiso3 = Permissions::findOrFail($permisobus3->id);
            $permiso3->permitido = $check3;
            $permiso3->update();

            $permisobus4 = Permissions::where('rol_id','=',$id_rol)
            ->where('modulo_id','=',$id_modulo)
            ->where('permiso','=',4)
            ->first(); 
            $permiso4 = Permissions::findOrFail($permisobus4->id);
            $permiso4->permitido = $check4;
            $permiso4->update();

            $permisobus5 = Permissions::where('rol_id','=',$id_rol)
            ->where('modulo_id','=',$id_modulo)
            ->where('permiso','=',5)
            ->first(); 
            $permiso5 = Permissions::findOrFail($permisobus5->id);
            $permiso5->permitido = $check5;
            $permiso5->update();
            
        }

        if($id_modulo == 4){
            $check6 = $request->check6;

            $permisobus6 = Permissions::where('rol_id','=',$id_rol)
            ->where('modulo_id','=',$id_modulo)
            ->where('permiso','=',6)
            ->first(); 
            $permiso6 = Permissions::findOrFail($permisobus6->id);
            $permiso6->permitido = $check6;
            $permiso6->update();
        }

        return 1;
    }
}
