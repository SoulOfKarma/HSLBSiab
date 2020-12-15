<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialCantidadesEspecificas;

class MaterialCantidadesEspecificasController extends Controller
{
    public function getAll(){
       $get_all = MaterialCantidadesEspecificas::all();
       return $get_all;
    }

    public function PostCantEsp(Request $request){
        try {
            MaterialCantidadesEspecificas::create($request->all());
       return true;
        } catch (\Throwable $th) {
            return false;
        }
       
    }
}
