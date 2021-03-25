<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\material_servicios;
use Illuminate\Support\Facades\Log;

class MaterialServiciosController extends Controller
{
    public function getAll(){
        $get_all = material_servicios::all();
        return $get_all;
    }

    public function PostServicio(Request $request){
        try {
            $res = material_servicios::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
     }
}
