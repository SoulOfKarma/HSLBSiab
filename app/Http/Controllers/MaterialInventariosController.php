<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialInventarios;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Client;
use App\RetornarMateriales;

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
            log::info($th);
            return false;
        }
        
    }

    public function PutInventario(Request $request){
       try {
           MaterialInventarios::where('id', $request->id)
           ->update(['id_ubicaciones' => $request->id_ubicaciones,'id_servicios' => $request->id_servicios,
           'id_cubiculo' => $request->id_cubiculo,'id_material_ing' => $request->id_material_ing,'id_cant_esp' => $request->id_cant_esp,
           'id_material_medida' => $request->id_material_medida,'material_cantidad' => $request->material_cantidad,'material_valor' => $request->material_valor,
           'material_cantidad_calculada' => $request->material_cantidad_calculada,'id_documento' => $request->id_documento,'n_documento' => $request->n_documento]);
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
    }

    public function TraerMaterial($id){
        try {
            $get_all = MaterialInventarios::select('material_inventarios.*')
            ->where('material_inventarios.id', $id)
            ->get();
          return $get_all;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function PostAsignarMaterial(Request $request){
        try {
            $userInput = $request->all();
            foreach($userInput as $e => $req ){                         
                MaterialInventarios::where('id',$req['id'])
              ->update(['material_cantidad' => $req['material_cantidad']]);
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutAsignarMaterial(Request $request){
        try {
            $userInput = $request->all();
            foreach($userInput as $e => $req ){                         
                MaterialInventarios::where('id',$req['id'])
              ->update(['material_cantidad' => $req['material_cantidad']]);
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function TraerMaterialEspecifico($id){
        try {
            $get_all = MaterialInventarios::select('material_inventarios.id','material_inventarios.n_documento','material_ubicaciones.descripcion_ubicacion',/* 'material_servicios.descripcion_servicio', */
            'material_ingresados.descripcion_material',/* 'material_cantidades_especificas.descripcion_cantidad_especifica', */
            'material_medidas.descripcion_medidas','material_cubiculos.descripcion_cubiculo','documento_asociados.descripcion_documento','material_inventarios.material_cantidad','material_inventarios.material_valor')
            ->join('material_ubicaciones', 'material_inventarios.id_ubicaciones','=','material_ubicaciones.id')
            /* ->join('material_servicios', 'material_inventarios.id_servicios','=','material_servicios.id') */
            ->join('material_ingresados', 'material_inventarios.id_material_ing','=','material_ingresados.id')
            /* ->join('material_cantidades_especificas', 'material_inventarios.id_cant_esp','=','material_cantidades_especificas.id') */
            ->join('material_medidas', 'material_inventarios.id_material_medida','=','material_medidas.id')
            ->join('documento_asociados','material_inventarios.id_documento','=','documento_asociados.id')
            ->join('material_cubiculos','material_inventarios.id_cubiculo','=','material_cubiculos.id')
            ->where('material_inventarios.id', $id)
            ->get();
          return $get_all;
        }catch (\Throwable $th){
            return false;
        }
    }

    public function getListadoStock(){
        $get_all = MaterialInventarios::select('material_inventarios.*','material_ubicaciones.descripcion_ubicacion',/* 'material_servicios.descripcion_servicio', */
        'material_ingresados.descripcion_material',/* 'material_cantidades_especificas.descripcion_cantidad_especifica', */
        'material_medidas.descripcion_medidas','material_cubiculos.descripcion_cubiculo','documento_asociados.descripcion_documento',DB::raw("DATE_FORMAT(material_inventarios.created_at,'%d/%m/%Y') as created"))
        ->join('material_ubicaciones', 'material_inventarios.id_ubicaciones','=','material_ubicaciones.id')
        /* ->join('material_servicios', 'material_inventarios.id_servicios','=','material_servicios.id') */
        ->join('material_ingresados', 'material_inventarios.id_material_ing','=','material_ingresados.id')
        /* ->join('material_cantidades_especificas', 'material_inventarios.id_cant_esp','=','material_cantidades_especificas.id') */
        ->join('material_medidas', 'material_inventarios.id_material_medida','=','material_medidas.id')
        ->join('documento_asociados','material_inventarios.id_documento','=','documento_asociados.id')
        ->join('material_cubiculos','material_inventarios.id_cubiculo','=','material_cubiculos.id')
        ->get();

        return $get_all;
    }

    public function getStockTotal(){
        $get_all = MaterialInventarios::select('material_ingresados.descripcion_material','material_inventarios.id_material_medida',DB::raw('sum(material_inventarios.material_cantidad) as total'),DB::raw('sum(material_inventarios.material_cantidad_calculada) AS total_cal'))
        ->join('material_ingresados','material_inventarios.id_material_ing','=','material_ingresados.id')
        ->groupBy('material_ingresados.descripcion_material','material_inventarios.id_material_medida')
        ->get();
        return $get_all;
    }

    public function ActaEntregaPDF($idSolicitud,$idCategoria,$nombre){
        try {
            $client = new Client();
            $resp = $client->request('POST','http://10.4.237.120:8001/api/auth/login',
            [
                'form_params' => [
                    'run' => '18499714-2',
                    'password' => '1849',
                ]
            ]); 
            $tokens = json_decode($resp->getBody()->getContents());

            $token = $tokens->token;

            $res = $client->request('POST','http://10.4.237.120:8001/api/Agente/ExportarDataPDF', 
            ['json' => [
                'idSolicitud' => $idSolicitud,
                'idCategoria' => $idCategoria
            ],
            'headers' => 
                [
                    'Authorization' => "Bearer {$token}"
                ]
            ]);
            $dat = json_decode($res->getBody()->getContents(),true);
            $data =[$dat];

            $get_data = RetornarMateriales::select('retornar_materiales.material_cantidad','material_ingresados.descripcion_material')
            ->join('material_inventarios','retornar_materiales.id_material_inventario','=','material_inventarios.id')
            ->join('material_ingresados', 'material_inventarios.id_material_ing','=','material_ingresados.id')
            ->where('retornar_materiales.id_ticket',[$idSolicitud])
            ->where('retornar_materiales.id_categoria',[$idCategoria])
            ->whereNotIn('retornar_materiales.material_cantidad',[0])
            ->get();

            $nomapeA = $nombre;

            $pdf = App::make("dompdf.wrapper");
            $pdf->loadView('ActEntregaMat', compact ('data','get_data','nomapeA'));
            //$pdf->loadView('ActEntregaMat',['data' => $data]);
            $pdf->setOptions(['isJavascriptEnabled' => true]);
            $pdf->setOptions(['isRemoteEnabled' => true]);
            return $pdf->stream("ActEntregaMat.pdf", array("Attachment" => 0));
            //return $pdf->stream("ActEntregaMat.pdf", array("Attachment" => 0));
            /* return [
                'status'=>"success",
                "data"=> mb_convert_encoding($pdf->output(), 'UTF-8', 'UTF-8')
            ]; */
            
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
