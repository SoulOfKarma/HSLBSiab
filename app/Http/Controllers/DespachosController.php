<?php

namespace App\Http\Controllers;

use App\despachos;
use App\despachoDetalles;
use App\saldo_inventarios;
use App\recepcionDetalles;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DespachosController extends Controller
{
    public function GetDetallesArticulosDisponibles(){
        try {
            $get = DB::select('select SUM(t.saldo) AS saldo,COALESCE((SUM(t.saldo) - COALESCE(despacho_detalles.CANTIDAD,0)),SUM(t.saldo)) AS saldoCorrecto,
            t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI
                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
              COALESCE(TIMESTAMPDIFF(DAY,NOW(),recepcion_detalles.FECVEN)+1,0) as diasVencimiento,COALESCE(recepcion_detalles.FECVEN,"No tiene Fecha") AS fechaVencimiento,
              recepcion_detalles.PREUNI AS PREUNI
              from recepcion_detalles 
              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
      
              union all
      
              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
               COALESCE(TIMESTAMPDIFF(DAY,NOW(),saldo_inventario.FECVEN)+1,0) as diasVencimiento,COALESCE(saldo_inventario.FECVEN,"No tiene Fecha") AS fechaVencimiento,
               saldo_inventario.PRECIO AS PREUNI
              from saldo_inventario 
              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
              
              ) t
              LEFT JOIN despacho_detalles ON t.LOTE = despacho_detalles.LOTE
      group by despacho_detalles.CANTIDAD,t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDespacho(Request $request){
        try {
            despachos::create($request->all());
            despachoDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostDetalleDespacho(Request $request){
        try {
            despachoDetalles::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNInternoDespacho(){
        try {
            $get = despachos::max('NUMINT');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetUltimoNFolioDespacho(){
        try {
            $get = despachos::max('FOLIO');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachosAbiertos(){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->where('FOLIO',null)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachosCerrados(){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUINT')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->whereNotNull('despachos.FOLIO')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachos(Request $request){
        try {
            $get = despachos::select('despachos.NUMINT','despachos.FOLIO','despachos.FECDES','despachos.idServicio','servicios.descripcionServicio',
            'despachos.NUMLIBRO','despachos.USUING')
            ->join('servicios','despachos.idServicio','=','servicios.id')
            ->where('despachos.NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachoDetalles(Request $request){
        try {
            $get = despachoDetalles::where('despacho_detalles.NUMINT',$request->NUMINT)
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
