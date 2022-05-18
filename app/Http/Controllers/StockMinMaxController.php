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
            $get = stockMinMax::all();
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
            'STOCK_CRI' => $request->STOCK_CRI,'idEstadoStock' => $request->idEstadoStock]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

}
