<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\material_servicios;

class MaterialServiciosController extends Controller
{
    public function getAll(){
        $get_all = material_servicios::all();
        return $get_all;
    }
}
