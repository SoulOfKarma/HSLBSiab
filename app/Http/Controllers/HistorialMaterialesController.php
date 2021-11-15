<?php

namespace App\Http\Controllers;

use App\HistorialMateriales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistorialMaterialesController extends Controller
{

    public function index()
    {
        try {
            $res = HistorialMateriales::all();
            return $res;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            foreach($data as $e => $req ){                       
                HistorialMateriales::create(array_merge($req,['id_ticket' => $req['idOT'],'id_categoria' => $req['id_categoria'],'id_estados' => 1]));
            }
            //HistorialMateriales::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutHistorialMateriales(Request $request){
        try {
            $data = $request->all();
            foreach($data as $e => $req ){                     
                HistorialMateriales::create(array_merge($req,['id_ticket' => $req['idOT'],'id_estados' => 6]));
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

}
