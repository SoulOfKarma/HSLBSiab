<?php

namespace App\Http\Controllers;

use App\autorizadoretiros;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class AutorizadoretirosController extends Controller
{
    public function PostAuthUsuario(Request $request){
        try {
            $id = autorizadoretiros::create($request->all())->id;
            return $id;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetAuthUsuario(){
        try {
            $get = autorizadoretiros::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutAuthUsuario(Request $request)
    {
        try {
            autorizadoretiros::where('id',$request->id)
            ->update(['RUN' => $request->RUN,'NOMBRES' => $request->NOMBRES,'APELLIDOS' => $request->APELLIDOS,'FECINI' => $request->FECINI,
            'FECFIN' => $request->FECFIN,'idEstado' => $request->idEstado,'idServicio' => $request->idServicio]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
