<?php

namespace App\Http\Controllers;

use App\despachos;
use App\despachoDetalles;
use App\saldo_inventarios;
use App\recepcionDetalles;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class Reportes extends Controller
{
    public function GetSaldosReporte(){
        try {
            $get = DB::select('select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = t.LOTE && 
            despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
            GROUP BY despacho_detalles.LOTE),0))
                         AS saldoCorrecto,
                                    t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN
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
                              group by t.NOMBRE,t.CODBAR,t.LOTE,t.UNIMED,t.CODART,t.diasVencimiento,t.fechaVencimiento,t.PREUNI,ZGEN
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoReporte(){
        try {
            $get = DB::select('select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
            despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
            GROUP BY despacho_detalles.NOMART),0))
                         AS saldoCorrecto,
                                    t.NOMBRE,t.UNIMED,t.CODART,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN,
                                    (SELECT MAX(recepcion_detalles.PREUNI)
												FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
												WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,
												FORMAT(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
												            despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
												            GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
												FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
												WHERE recepcion_detalles.CODART = t.CODART)),2) AS TOTAL
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
                              group by t.NOMBRE,t.UNIMED,t.CODART,ZGEN,ULTPRE
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetBincard(){
        try {
            $get = DB::select('select "Saldo Inventario" AS TIPO, NOMBRE AS NOMBRE,STR_TO_DATE(DATE_FORMAT(created_at,"%d-%m-%Y"),"%d-%m-%Y") as FECHA,'-' AS FOLDES,'-' AS FOLREC,'-' AS NUMORD,
            '-' AS PROVEEDOR,CODART AS CODART,CODART_BARR AS CODBAR,PRECIO AS PRECIO,CANTIDAD AS CANTIDAD
            FROM saldo_inventario WHERE CODART = "2130017"
            UNION
            SELECT "Recepcion" AS TIPO, recepcion_detalles.PRODUCTO AS NOMBRE,STR_TO_DATE(DATE_FORMAT(recepcion_detalles.FECDES,"%d-%m-%Y"),"%d-%m-%Y") as FECHA,'-' AS FOLDES,
            recepcion_detalles.FOLIO AS FOLREC,recepciones.NUMORD AS NUMORD,recepciones.NOMPRO AS PROVEEDOR,recepcion_detalles.CODART AS CODART,
            recepcion_detalles.CODBAR AS CODBAR,recepcion_detalles.PREUNI,recepcion_detalles.CANREC AS CANTIDAD
            FROM recepcion_detalles 
            JOIN recepciones ON recepcion_detalles.NUMINT = recepciones.NUMINT
            WHERE CODART = "2130017"
            UNION	
            SELECT "Despacho" AS TIPO, despacho_detalles.NOMART AS NOMBRE,STR_TO_DATE(DATE_FORMAT(despacho_detalles.FECDES,"%d-%m-%Y"),"%d-%m-%Y") as FECHA,despacho_detalles.FOLIO AS FOLDES,
            '-' AS FOLREC,'-' AS NUMORD,'-' AS PROVEEDOR,despacho_detalles.CODART AS CODART,
            despacho_detalles.CODBAR AS CODBAR,despacho_detalles.PRECIO,despacho_detalles.CANTIDAD AS CANTIDAD
            FROM despacho_detalles 
            WHERE CODART = "2130017"
            ORDER BY FECHA
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }
}
