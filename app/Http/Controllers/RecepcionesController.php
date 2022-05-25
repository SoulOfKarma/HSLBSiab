<?php

namespace App\Http\Controllers;

use App\recepciones;
use Illuminate\Http\Request;
use App\recepcionDetalles;
use DB;
use Illuminate\Support\Facades\Log;

class RecepcionesController extends Controller
{
    public function GetUltimoNInterno(){
        try {
            $get = recepciones::max('NUMINT');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostArticuloDetalle(Request $request){
        try {
            recepciones::create($request->all());
            recepcionDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
