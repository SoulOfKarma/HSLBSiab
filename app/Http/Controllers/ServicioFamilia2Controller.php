<?php

namespace App\Http\Controllers;

use App\ServicioFamilia2;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia2Controller extends Controller
{
    public function GetSF2(){
        try {
            $get = ServicioFamilia2::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF2(Request $request){
        try {
            ServicioFamilia2::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF2(Request $request){
        try {
            ServicioFamilia2::where('id', $request->id)
            ->update(['descripcionSF2' => $request->descripcionSF2,'idSF1' => $request->idSF1]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
