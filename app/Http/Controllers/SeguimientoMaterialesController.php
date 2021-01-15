<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\seguimientoMateriales;
use Illuminate\Support\Facades\Log;
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

    public function PostSeguimientoMaterial(Request $request,$idUser){
        try {
            $lista = $request->all();
        
            foreach($lista as $e => $req ){       
                $data = ["id_usuario" => $idUser,"id_material" => $req["id"], "descripcion_seguimiento" => "Se ha asignado el material a la OT ".''.$req["idOT"].''.", Se utilizaron ".''.$req["material_cantidad"] .''. " " .''.$req["descripcion_medidas"]];
                
                seguimientoMateriales::create($data);
            }
           
          return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
          
    }
}
