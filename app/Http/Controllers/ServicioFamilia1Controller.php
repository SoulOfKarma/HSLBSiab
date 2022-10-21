<?php

namespace App\Http\Controllers;

use App\ServicioFamilia1;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia1Controller extends Controller
{
    public function GetSF1(){
        try {
            $get = ServicioFamilia1::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF1(Request $request){
        try {
            ServicioFamilia1::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF1(Request $request){
        try {
            ServicioFamilia1::where('id', $request->id)
            ->update(['descripcionSF1' => $request->descripcionSF1]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
