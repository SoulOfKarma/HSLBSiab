<?php

namespace App\Http\Controllers;

use App\DescripcionFamilia02;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DescripcionFamilia02Controller extends Controller
{
    public function GetFamilia(){
        try {
            $get = DescripcionFamilia02::orderby('descripcionFamilia','ASC')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostFamilia(Request $request){
        try {
            DescripcionFamilia02::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutFamilia(Request $request){
        try {
            DescripcionFamilia02::where('id',$request->id)
            ->update(['descripcionFamilia' => $request->descripcionFamilia,'idDesFam01' => $request->idDesFam01]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
