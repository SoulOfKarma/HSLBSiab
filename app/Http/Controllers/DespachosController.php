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
            $get = DB::select('select sum(saldo) AS saldo,sum(saldo)- COALESCE((select SUM(despacho_detalles.CANTIDAD) as saldo from despacho_detalles),0) AS saldoCorrecto,
            NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
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
      group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,diasVencimiento,fechaVencimiento,PREUNI
      
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
