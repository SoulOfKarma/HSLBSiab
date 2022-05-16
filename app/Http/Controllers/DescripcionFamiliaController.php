<?php

namespace App\Http\Controllers;

use App\DescripcionFamilia;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DescripcionFamiliaController extends Controller
{
    public function GetFamilia(){
        try {
            $get = DescripcionFamilia::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostFamilia(Request $request){
        try {
            DescripcionFamilia::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFamilia(Request $request){
        try {
            DescripcionFamilia::where('id',$request->id)
            ->update(['descripcionFamilia' => $request->descripcionFamilia,'idBodega' => $request->idBodega]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
