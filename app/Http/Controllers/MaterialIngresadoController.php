<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialIngresados;

class MaterialIngresadoController extends Controller
{
    public function getAll(){
        $get_all = MaterialIngresados::all();
        return $get_all;
    }

    public function PostMaterial(Request $request){
        try {
            MaterialIngresados::create($request->all());
        return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }
}
