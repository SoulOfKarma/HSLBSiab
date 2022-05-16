<?php

namespace App\Http\Controllers;

use App\DescripcionFamilia03;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DescripcionFamilia03Controller extends Controller
{
    public function GetFamilia(){
        try {
            $get = DescripcionFamilia03::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostFamilia(Request $request){
        try {
            DescripcionFamilia03::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFamilia(Request $request){
        try {
            DescripcionFamilia03::where('id',$request->id)
            ->update(['descripcionFamilia' => $request->descripcionFamilia,'idDesFam02' => $request->idDesFam02]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
