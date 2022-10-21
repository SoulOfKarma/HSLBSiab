<?php

namespace App\Http\Controllers;

use App\ServicioFamilia5s;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia5sController extends Controller
{
    public function GetSF5(){
        try {
            $get = ServicioFamilia5s::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF5(Request $request){
        try {
            ServicioFamilia5s::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF5(Request $request){
        try {
            ServicioFamilia5s::where('id', $request->id)
            ->update(['descripcionSF5' => $request->descripcionSF5,'idSF4' => $request->idSF4,'visualizar' => $request->visualizar]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
