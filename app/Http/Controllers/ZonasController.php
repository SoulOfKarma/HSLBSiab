<?php

namespace App\Http\Controllers;

use App\Zonas;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ZonasController extends Controller
{
    public function GetZona(){
        try {
            $get = Zonas::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostZona(Request $request){
        try {
            Zonas::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutZona(Request $request){
        try {
            Zonas::where('id',$request->id)
            ->update(['descripcionZonas' => $request->descripcionZonas]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
