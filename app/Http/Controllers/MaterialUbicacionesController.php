<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\material_ubicaciones;
use Illuminate\Support\Facades\Log;

class MaterialUbicacionesController extends Controller
{
    public function getAll(){
        $get_all = material_ubicaciones::all();
        return $get_all;
    }

    public function PostUbicacion(Request $request){
        try {
            $res = material_ubicaciones::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
     }
}
