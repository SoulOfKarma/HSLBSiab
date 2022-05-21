<?php

namespace App\Http\Controllers;

use App\StockMinMaxMedicamentos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class StockMinMaxMedicamentosController extends Controller
{
    public function GetStockMinMaxMed(Request $request){
        try {
            $filtro = [2];
            $get = StockMinMaxMedicamentos::select('stock_min_max_medicamento.id','bodega.descripcionBodega','estados.descripcionEstado',
            'stock_min_max_medicamento.CODART','stock_min_max_medicamento.NOMBRE',
            'stock_min_max_medicamento.STOCK_MIN','stock_min_max_medicamento.STOCK_MAX','stock_min_max_medicamento.STOCK_CRI',
            'stock_min_max_medicamento.UNIMEDBASE','stock_min_max_medicamento.idBodega','stock_min_max_medicamento.idEstadoStock')
            ->join('bodega','stock_min_max_medicamento.idBodega','=','bodega.id')
            ->join('estados','stock_min_max_medicamento.idEstadoStock','=','estados.id')
            ->whereNotIn('stock_min_max_medicamento.idEstadoStock',$filtro)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostStockMinMaxMed(Request $request){
        try {
            StockMinMaxMedicamentos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutStockMinMaxMed(Request $request){
        try {
            StockMinMaxMedicamentos::where('id',$request->id)
            ->update(['idBodega' => $request->idBodega,'CODART' => $request->CODART,'NOMBRE' => $request->NOMBRE,
            'STOCK_MIN' => $request->STOCK_MIN,'STOCK_MAX' => $request->STOCK_MAX,
            'STOCK_CRI' => $request->STOCK_CRI,'idEstadoStock' => $request->idEstadoStock,'UNIMEDBASE' => $request->UNIMEDBASE]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutDesactivarStockMinMaxMed(Request $request){
        try {
            StockMinMaxMedicamentos::where('id',$request->id)
            ->update(['idEstadoStock' => $request->idEstadoStock]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }  
}
