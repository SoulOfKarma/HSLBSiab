<?php

namespace App\Http\Controllers;

use App\ServicioFamilia4s;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia4sController extends Controller
{
    public function GetSF4(){
        try {
            $get = ServicioFamilia4s::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF4(Request $request){
        try {
            ServicioFamilia4s::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF4(Request $request){
        try {
            ServicioFamilia4s::where('id', $request->id)
            ->update(['descripcionSF4' => $request->descripcionSF4,'idSF3' => $request->idSF3,'visualizar' => $request->visualizar]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
