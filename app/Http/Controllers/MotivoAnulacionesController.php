<?php

namespace App\Http\Controllers;

use App\motivo_anulaciones;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class MotivoAnulacionesController extends Controller
{
    public function PostAnulacion(Request $request){
        try {
            motivo_anulaciones::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetAnulacion(){
        try {
            $get = motivo_anulaciones::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutAnulacion(Request $request)
    {
        try {
            motivo_anulaciones::where('id',$request->id)
            ->update(['CODMOT' => $request->CODMOT,'NOMMOT' => $request->NOMMOT]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
