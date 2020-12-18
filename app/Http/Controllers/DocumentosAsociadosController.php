<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\DocumentoAsociados;

class DocumentosAsociadosController extends Controller
{
    public function getAll(){
        $get_all = DocumentoAsociados::all();
        return $get_all;
    }

    public function createDA(Request $request){
        try {
            DocumentoAsociados::create();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
