<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Client;

class DashboardController extends Controller
{
    public function showDash()
    {
        $clientes_activos = DB::table('cliente')
        ->selectRaw('COUNT(id) as activos')
        ->where('estatus','=','1')
        ->get();

        $clientes_inactivos = DB::table('cliente')
        ->selectRaw('COUNT(id) as inactivos')
        ->where('estatus','=','0')
        ->get();

        $clientes = DB::table('cliente')
        ->selectRaw('COUNT(id) as clientes')
        ->get();

        $candidatos_por_asignar = DB::table('candidatos')
        ->selectRaw('COUNT(idcandidato) as porasignar')
        ->where('estatus','=','1')
        ->where('estatus_candidatos','=','5')
        ->get();

        $candidatos_asignados = DB::table('candidatos')
        ->selectRaw('COUNT(idcandidato) as asignados')
        ->where('estatus','=','1')
        ->where('estatus_candidatos','<>','5')
        ->get();

        $requerimientos_pendiente = DB::table('vacantes')
        ->selectRaw('COUNT(id) as pendiente')
        ->where('estatus','=','1')
        ->where('estatus_vacante','=','1')
        ->get();

        $requerimientos_proceso = DB::table('vacantes')
        ->selectRaw('COUNT(id) as proceso')
        ->where('estatus','=','1')
        ->where('estatus_vacante','=','3')
        ->get();

        $requerimientos_contratado = DB::table('vacantes')
        ->selectRaw('COUNT(id) as contratado')
        ->where('estatus','=','1')
        ->where('estatus_vacante','=','4')
        ->get();

        $requerimientos_descartado = DB::table('vacantes')
        ->selectRaw('COUNT(id) as descartado')
        ->where('estatus','=','1')
        ->where('estatus_vacante','=','2')
        ->get();

       /* $requerimientos_cartera = DB::table('vacantes')
        ->selectRaw('COUNT(id) as cartera')
        ->where('estatus','=','5')
        ->where('estatus_vacante','=','4')
        ->get();*/

        return view('dashboard')->with(['clientes'=>$clientes, 'clientes_activos'=>$clientes_activos, 'clientes_inactivos'=>$clientes_inactivos,
        'candidatos_por_asignar'=>$candidatos_por_asignar, 'candidatos_asignados'=>$candidatos_asignados,
        'requerimientos_pendiente'=>$requerimientos_pendiente, 'requerimientos_proceso'=>$requerimientos_proceso, 'requerimientos_contratado'=>$requerimientos_contratado,
        'requerimientos_descartado'=>$requerimientos_descartado ]);  
        
    }

}
