<?php

namespace App\Http\Controllers;

use App\AuthEstados;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class AuthEstadosController extends Controller
{
    public function GetAuthEstado(){
        try {
            $get = AuthEstados::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostAuthEstado(Request $request){
        try {
            AuthEstados::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutAuthEstado(Request $request){
        try {
            AuthEstados::where('id',$request->id)
            ->update(['descripcionEstado' => $request->descripcionEstado]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
