<?php

namespace App\Http\Controllers;

use App\estados;
use Illuminate\Http\Request;

class EstadosController extends Controller
{
    public function GetEstado(Request $request){
        try {
            $get = estados::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostEstado(Request $request){
        try {
            estados::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutEstado(Request $request){
        try {
            estados::where('id',$request->id)
            ->update(['descripcionEstado' => $request->descripcionEstado]);

            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
