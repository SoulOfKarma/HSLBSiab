<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\seguimientoMateriales;
use DB;

class SeguimientoMaterialesController extends Controller
{
    public function GetSeguimientoMaterial($id){
        $get_all = seguimientoMateriales::select('seguimiento_materiales.*','users.nombre_usuario','users.apellido_usuario')
        ->join('users', 'seguimiento_materiales.id_usuario','=','users.id')
        ->join('material_inventarios', 'seguimiento_materiales.id_material','=','material_inventarios.id')
        ->where('material_inventarios.id',$id)
        ->get();

        return $get_all;
    }
}
