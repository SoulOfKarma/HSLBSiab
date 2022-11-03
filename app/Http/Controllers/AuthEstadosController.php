<?php

namespace App\Http\Controllers;

use App\AuthEstados;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class AuthEstadosController extends Controller
{
    //Este Metodo Devuelve Todos los tipos de estados autorizados para el item v-select del frontend
    public function GetAuthEstado(){
        try {
            $get = AuthEstados::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    //Este Metodo Inserta los valores enviados desde el front por post a la base de datos y devuelve true si funciono o false si no lo hizo
    public function PostAuthEstado(Request $request){
        try {
            AuthEstados::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    //Este Metodo Actualiza los valores enviados desde el front por post a la base de datos si el campo solicitado existe
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
