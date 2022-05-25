<?php

namespace App\Http\Controllers;

use App\tipoDocumentos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class TipoDocumentosController extends Controller
{
    public function GetTipoDocumentos(){
        try {
            $get = tipoDocumentos::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostTipoDocumentos(Request $request){
        try {
            tipoDocumentos::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutTipoDocumentos(Request $request){
        try {
            tipoDocumentos::where('id',$request->id)
            ->update(['descripcionDocumento' => $request->descripcionDocumento]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
