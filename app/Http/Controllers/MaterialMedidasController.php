<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\material_medidas;

class MaterialMedidasController extends Controller
{
    public function getAll(){
        $get_all = material_medidas::all();
        return $get_all;
    }

    public function filtroMedidas(){
        try {
            $data = [13];
            $get_all = material_medidas::select('material_medidas.*')
            ->whereNotIn('id',$data)
            ->get();
            return $get_all;
            
        } catch (\Throwable $th) {
            return false;
        }
    }
}
