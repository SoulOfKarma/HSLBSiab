<?php

namespace App\Http\Controllers;

use App\ordenCompras;
use App\ordenCompraDetalles;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class OrdenComprasController extends Controller
{
    public function GetOrdenCompras(){
        try {
            $get = ordenCompras::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostOrdenCompras(Request $request){
        try {
            ordenCompras::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutOrdenCompras(Request $request){
        try {
            ordenCompras::where('id',$request->id)
            ->update(['FOLIO' => $request->FOLIO,'RUTPRO' => $request->RUTPRO,'NOMPRO' => $request->NOMPRO,
            'FECORD' => $request->FECORD,'NUMINT' => $request->NUMINT,'NUMSIGFE' => $request->NUMSIGFE,
            'FECSYS' => $request->FECSYS,'OBS' => $request->OBS]);
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
