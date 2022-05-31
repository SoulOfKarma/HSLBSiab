<?php

namespace App\Http\Controllers;

use App\fondos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class FondosController extends Controller
{
   public function GetFondos(){
       try {
           $get = fondos::all();
           return $get;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
   }

   public function PostFondos(Request $request){
       try {
           fondos::create($request->all());
           return true;
       } catch (\Throwable $th) {
            log::info($th);
            return false;
       }
   }

   public function PutFondos(Request $request){
       try {
           fondos::where('id',$request->id)
           ->update(['descripcionFondos' => $request->descripcionFondos]);
           return true;
       } catch (\Throwable $th) {
           log::info($th);
           return false;
       }
   }
}
