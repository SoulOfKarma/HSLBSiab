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
            $get = DB::select('select SUM(a.saldoCorrecto) AS saldoCorrecto,a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN FROM
            (
            select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = t.LOTE && 
                        despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                        GROUP BY despacho_detalles.LOTE),0))
                                     AS saldoCorrecto,
                                                t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN
                                                    from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                  COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART
                                                  from recepcion_detalles 
                                                  group by NOMBRE,LOTE,UNIMED,CODART
                                          
                                                  union all
                                          
                                                  select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                   COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART                                      
                                                  from saldo_inventario 
                                                  group by NOMBRE,LOTE,UNIMED,CODART
                                                  
                                                  ) t
                                          group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
                                          
                                           UNION ALL 
                                                  
                                                  SELECT 0 AS saldo,siab_articulo.NOMBRE AS NOMBRE,"No tiene LOTE" AS LOTE,siab_articulo.UNIMEDBASE AS UNIMED,
            siab_articulo.CODART AS CODART, siab_articulo.ZGEN AS ZGEN
            FROM siab_articulo
            
            ) a
            
            group by a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoReporte(){
        try {
            $get = DB::select('select SUM(a.saldoCorrecto) AS saldoCorrecto,a.NOMBRE,a.UNIMED,a.CODART,a.ZGEN,a.ULTPRE,a.TOTAL FROM
            (
            select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
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
                                                  recepcion_detalles.PREUNI AS PREUNI
                                                  from recepcion_detalles 
                                                  group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                          
                                                  union all
                                          
                                                  select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                   saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                   saldo_inventario.PRECIO AS PREUNI
                                                  from saldo_inventario 
                                                  group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                  ) t
                                          group by t.NOMBRE,t.UNIMED,t.CODART,ZGEN,ULTPRE
                                          
                                          
                                          UNION ALL 
                                          
                                          SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
            siab_articulo.CODART AS CODART, siab_articulo.ZGEN AS ZGEN,0 AS ULTPRE,0 AS TOTAL
            FROM siab_articulo
            
            ) a
            
            group by a.NOMBRE,a.UNIMED,a.CODART,a.ZGEN,a.ULTPRE,a.TOTAL
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetBincard(Request $request){
        try {
            $saldoinv = saldo_inventarios::select(DB::raw("'Saldo Inventario' AS TIPO"), 'saldo_inventario.NOMBRE AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(saldo_inventario.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw("'-' AS FOLDES"),DB::raw("'-' AS FOLREC"),DB::raw("'-' AS NUMORD"),DB::raw("'-' AS PROVEEDOR"),
            'saldo_inventario.CODART AS CODART','saldo_inventario.CODART_BARR AS CODBAR','saldo_inventario.PRECIO AS PRECIO',
            'saldo_inventario.SALDO AS CANTIDAD',DB::raw("'-' AS SERVICIO"),DB::raw("'-' AS NOMMOT"))
            ->where('saldo_inventario.CODART',$request->CODART);

            $recepciondet = recepcionDetalles::select(DB::raw("'Recepcion' AS TIPO"), 'recepcion_detalles.PRODUCTO AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(recepcion_detalles.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw("'-' AS FOLDES"),DB::raw('COALESCE(recepcion_detalles.FOLIO,"-") AS FOLREC'),'recepciones.NUMORD AS NUMORD','recepciones.NOMPRO AS PROVEEDOR',
            'recepcion_detalles.CODART AS CODART','recepcion_detalles.CODBAR AS CODBAR','recepcion_detalles.PREUNI AS PRECIO',
            'recepcion_detalles.CANREC AS CANTIDAD',DB::raw("'-' AS SERVICIO"),DB::raw('COALESCE(recepcion_detalles.NOMMOT,"-") AS NOMMOT'))
            ->join('recepciones','recepcion_detalles.NUMINT','=','recepciones.NUMINT')
            ->where('recepcion_detalles.CODART',$request->CODART);

            $despachodet = despachoDetalles::select(DB::raw("'Despacho' AS TIPO"), 'despacho_detalles.NOMART AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(despacho_detalles.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw('COALESCE(despacho_detalles.FOLIO,"-") AS FOLDES'),DB::raw("'-' AS FOLREC"),DB::raw("'-' AS NUMORD"),DB::raw("'-' AS PROVEEDOR"),
            'despacho_detalles.CODART AS CODART','despacho_detalles.CODBAR AS CODBAR','despacho_detalles.PRECIO AS PRECIO',
            'despacho_detalles.CANTIDAD AS CANTIDAD',DB::raw('COALESCE(servicios.descripcionServicio,"-") AS SERVICIO'),DB::raw('COALESCE(despacho_detalles.NOMMOT,"-") AS NOMMOT'))
            ->leftjoin('servicios','despacho_detalles.idServicio','=','servicios.id')
            ->where('despacho_detalles.CODART',$request->CODART)
            ->union($saldoinv)
            ->union($recepciondet)
            ->orderByRaw("TIPO = 'Saldo Inventario' DESC, FECHA ASC, TIPO = 'Recepcion' DESC")
            ->get();

            return $despachodet;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetArticulosSaldoEstado(){
        try {
            $get = DB::select('select SUM(a.saldoCorrecto) AS saldoCorrecto,a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            FROM (select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = t.LOTE && 
                        despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                        GROUP BY despacho_detalles.LOTE),0))
                                     AS saldoCorrecto,
                                                t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN,
                                                (SELECT auth_estados.descripcionEstado FROM siab_articulo JOIN auth_estados ON siab_articulo.idEstado = auth_estados.id WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS Estado
                                                    from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                  COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART
                                                  from recepcion_detalles 
                                                  group by NOMBRE,LOTE,UNIMED,CODART
                                          
                                                  union all
                                          
                                                  select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                  COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART
                                                  from saldo_inventario 
                                                  group by NOMBRE,LOTE,UNIMED,CODART                         
                                                  ) t
                                          group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
                                          
                                          UNION ALL 
                                          
              SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,"No tiene LOTE" AS LOTE,siab_articulo.UNIMEDBASE AS UNIMED,
               siab_articulo.CODART AS CODART,siab_articulo.ZGEN AS ZGEN,auth_estados.descripcionEstado AS Estado
               FROM siab_articulo JOIN auth_estados ON siab_articulo.idEstado = auth_estados.id
            )a 
            group by a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetConsumoAnio(Request $request){
        try {
            $get = DB::select('select a.NOMBRE,a.CODART,a.UNIMED,a.ZGEN,sum(a.CONSUMO) AS CONSUMO FROM 
            (
            select t.NOMBRE,t.CODART,t.UNIMED,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN,
                        COALESCE((SELECT despacho_detalles.CANTIDAD FROM despacho_detalles WHERE t.CODART = despacho_detalles.CODART && despacho_detalles.FECDES BETWEEN  "'.$request->FECINI.'" AND "'.$request->FECTER.'"  LIMIT 1),0) AS CONSUMO
                            from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                          COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART
                          from recepcion_detalles 
                          group by NOMBRE,LOTE,UNIMED,CODART
                  
                          union all
                  
                          select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                           COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART
                          from saldo_inventario 
                          group by NOMBRE,LOTE,UNIMED,CODART                         
                          ) t
                  group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
                  
                  UNION ALL 
                  
                  SELECT siab_articulo.NOMBRE AS NOMBRE,siab_articulo.CODART AS CODART,siab_articulo.UNIMEDBASE AS UNIMED,
                           siab_articulo.ZGEN AS ZGEN,0 AS CONSUMO
                           FROM siab_articulo 
            ) a
            group by a.NOMBRE,a.UNIMED,a.CODART,a.ZGEN
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetConsumoMes(Request $request){
        try {
            $get = DB::select('select DISTINCT "'.$request->ANIO.'" AS ANIO,"'.$request->MES.'" AS MES,t.NOMBRE,t.CODART,t.UNIMED,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN,
            COALESCE((SELECT despacho_detalles.CANTIDAD FROM despacho_detalles WHERE t.CODART = despacho_detalles.CODART && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'" LIMIT 1),0) AS CONSUMO
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
      group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }
}
