<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialInventarios;

class MaterialInventariosController extends Controller
{
    public function getAll(){
        $get_all = MaterialInventarios::all();
        return $get_all;
    }

    public function createInventario(Request $request){
        try {
            $response = MaterialInventarios::create($request->all());
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }

    public function getListadoStock(){
        $get_all = MaterialInventarios::select('material_inventarios.id','material_inventarios.n_documento','material_ubicaciones.descripcion_ubicacion','material_servicios.descripcion_servicio',
        'material_ingresados.descripcion_material','material_tipos.descripcion_tipo_material','material_cantidades_especificas.descripcion_cantidad_especifica',
        'material_medidas.descripcion_medidas','documento_asociados.descripcion_documento','material_inventarios.material_cantidad','material_inventarios.material_valor')
        ->join('material_ubicaciones', 'material_inventarios.id_ubicaciones','=','material_ubicaciones.id')
        ->join('material_servicios', 'material_inventarios.id_servicios','=','material_servicios.id')
        ->join('material_ingresados', 'material_inventarios.id_material_ing','=','material_ingresados.id')
        ->join('material_tipos', 'material_inventarios.id_material_tipo','=','material_tipos.id')
        ->join('material_cantidades_especificas', 'material_inventarios.id_cant_esp','=','material_cantidades_especificas.id')
        ->join('material_medidas', 'material_inventarios.id_material_medida','=','material_medidas.id')
        ->join('documento_asociados','material_inventarios.id_documento','=','documento_asociados.id')
        ->get();

        return $get_all;
    }

    public function getStockTotal(){
        $get_all = MaterialInventarios::select('material_ingresados.descripcion_material','material_tipos.descripcion_tipo_material','material_inventarios.id_material_medida',DB::raw('sum(material_inventarios.material_cantidad) as total'),DB::raw('sum(material_inventarios.material_cantidad_calculada) AS total_cal'))
        ->join('material_ingresados','material_inventarios.id_material_ing','=','material_ingresados.id')
        ->join('material_tipos','material_inventarios.id_material_tipo','=','material_tipos.id')
        ->groupBy('material_ingresados.descripcion_material','material_tipos.descripcion_tipo_material','material_inventarios.id_material_medida')
        ->get();
        return $get_all;
    }
}
