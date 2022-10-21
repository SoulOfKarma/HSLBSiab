<?php

namespace App\Http\Controllers;

use App\ServicioFamilia3s;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia3sController extends Controller
{
    public function GetSF3(){
        try {
            $get = ServicioFamilia3s::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF3(Request $request){
        try {
            ServicioFamilia3s::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF3(Request $request){
        try {
            ServicioFamilia3s::where('id', $request->id)
            ->update(['descripcionSF3' => $request->descripcionSF3,'idSF2' => $request->idSF2,'visualizar' => $request->visualizar]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
