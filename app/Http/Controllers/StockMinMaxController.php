<?php

namespace App\Http\Controllers;

use App\stockMinMax;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class StockMinMaxController extends Controller
{
    public function GetStockMinMax(Request $request){
        try {
            $filtro = [2];
            $get = stockMinMax::select('stock_min_max.id','bodega.descripcionBodega','estados.descripcionEstado','stock_min_max.CODART','stock_min_max.NOMBRE',
            'stock_min_max.STOCK_MIN','stock_min_max.STOCK_MAX','stock_min_max.STOCK_CRI','stock_min_max.UNIMEDBASE',
            'stock_min_max.idBodega','stock_min_max.idEstadoStock')
            ->join('bodega','stock_min_max.idBodega','=','bodega.id')
            ->join('estados','stock_min_max.idEstadoStock','=','estados.id')
            ->whereNotIn('stock_min_max.idEstadoStock',$filtro)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostStockMinMax(Request $request){
        try {
            stockMinMax::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutStockMinMax(Request $request){
        try {
            stockMinMax::where('id',$request->id)
            ->update(['idBodega' => $request->idBodega,'CODART' => $request->CODART,'NOMBRE' => $request->NOMBRE,
            'STOCK_MIN' => $request->STOCK_MIN,'STOCK_MAX' => $request->STOCK_MAX,
            'STOCK_CRI' => $request->STOCK_CRI,'idEstadoStock' => $request->idEstadoStock,'UNIMEDBASE' => $request->UNIMEDBASE]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutDesactivarStockMinMax(Request $request){
        try {
            stockMinMax::where('id',$request->id)
            ->update(['idEstadoStock' => $request->idEstadoStock]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }  

}
