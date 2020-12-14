<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\material_ubicaciones;

class MaterialUbicacionesController extends Controller
{
    public function getAll(){
        $get_all = material_ubicaciones::all();
        return $get_all;
    }
}
