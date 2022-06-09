<?php

namespace App\Http\Controllers;

use App\ordenCompras;
use App\ordenCompraDetalles;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class OrdenComprasController extends Controller
{
    public function GetUltimoNInterno(){
        try {
            $get = ordenCompras::max('NUMINT');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNFolio(){
        try {
            $get = ordenCompras::max('FOLIO');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetOrdenCompras(){
        try {
            $get = ordenCompras::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetOCAbiertas(Request $request){
        try {
            $get = ordenCompras::where('FOLIO',null)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetOCCerradas(Request $request){
        try {
            $get = ordenCompras::whereNotNull('FOLIO')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostOrdenCompras(Request $request){
        try {
            ordenCompras::create($request->all());
            ordenCompraDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostOrdenComprasDetalleByCodInterno(Request $request){
        try {
            ordenCompraDetalles::create($request->all());
            ordenCompras::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO,'RUTPRO' => $request->RUTPRO,'NOMPRO' => $request->NOMPRO,
            'FECORD' => $request->FECORD,'NUMINT' => $request->NUMINT,'NUMSIGFE' => $request->NUMSIGFE,
            'FECSYS' => $request->FECSYS,'OBS' => $request->OBS]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostCerrarOrdenCompra(Request $request){
        try {
            ordenCompraDetalles::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            ordenCompras::where('NUMINT',$request->NUMINT)
            ->update(['FOLIO' => $request->FOLIO]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetOrdenCompraIngresadosByCodInterno(Request $request){
        try {
            $get = ordenCompras::select('FOLIO','RUTPRO','NOMPRO','FECORD','NUMINT','NUMSIGFE','FECSYS','OBS')
            ->where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetOrdenCompraDetallesIngresadosByCodInterno(Request $request){
        try {
            $get = ordenCompraDetalles::select('FOLREC','TIPDOC','NUMDOC','FECDOC','NOMORD','TOTAL')
            ->where('NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutListadoOrdenCompra(Request $request){
        try {
                $lista = $request->all();
            
                foreach($lista as $e => $req ){                           
                    ordenCompraDetalles::where('id',$req["id"])
                    ->update(['FOLREC' => $req["FOLREC"],'TIPDOC' => $req["TIPDOC"],'NUMDOC' => $req["NUMDOC"],
                    'FECDOC' => $req["FECDOC"],'NOMORD' => $req["NOMORD"],'TOTAL' => $req["TOTAL"]]);
                    
                }
              return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PutOrdenCompras(Request $request){
        try {
            ordenCompras::where('NUMINT',$request->NUMINT)
            ->update(['NUMSIGFE' => $request->NUMSIGFE]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
