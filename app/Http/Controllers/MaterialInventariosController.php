<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MaterialInventarios;

class MaterialInventariosController extends Controller
{
    public function getAll(){
        $get_all = MaterialInventarios::all();
        return $get_all;
    }

    public function createInventario(Request $request){
        try {
            $response = MaterialInventarios::create($request->all());
            return true;
        } catch (\Throwable $th) {
            return false;
        }
        
    }
}
