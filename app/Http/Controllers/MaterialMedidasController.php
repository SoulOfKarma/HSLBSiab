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
}
