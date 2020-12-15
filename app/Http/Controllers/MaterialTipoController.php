<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialTipos;

class MaterialTipoController extends Controller
{
    public function getAll(){
       $get_all = MaterialTipos::all();
       return $get_all;
    }

    public function PostTipoMaterial(Request $request){
        try {
            MaterialTipos::create($request->all());
            return true;           
        } catch (\Throwable $th) {
            return false;
        }
    }
}
