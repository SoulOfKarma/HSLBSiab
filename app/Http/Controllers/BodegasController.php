<?php

namespace App\Http\Controllers;

use App\Bodegas;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class BodegasController extends Controller
{
    public function GetBodega(){
        try {
            $get = Bodegas::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostBodega(Request $request){
        try {
            Bodegas::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutBodega(Request $request){
        try {
            Bodegas::where('id',$request->id)
            ->update(['descripcionBodega' => $request->descripcionBodega]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
