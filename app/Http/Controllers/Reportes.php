<?php

namespace App\Http\Controllers;

use App\despachos;
use App\despachoDetalles;
use App\saldo_inventarios;
use App\recepcionDetalles;
use App\siab_articulos;
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
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoReporte(){
        try {
            $get = DB::select('select SUM(a.saldoCorrecto) AS saldoCorrecto,a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.TOTAL FROM
            (
            select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                        despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                        GROUP BY despacho_detalles.NOMART),0))
                                     AS saldoCorrecto,
                                                t.NOMBRE,t.UNIMED,t.CODART,
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
                                          group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE
                                          
                                          
                                          UNION ALL 
                                          
                                          SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
            siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS TOTAL
            FROM siab_articulo
            
            ) a
            
            group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.TOTAL
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Busqueda Saldo General

    public function GetSaldoValorizadoP(){
        try {
            $get = DB::select('select a.CODART,a.NOMBRE,a.UNIMED,ROUND(SUM(a.saldoCorrecto),0) AS saldoCorrecto,ROUND(a.ULTPRE,0) AS ULTPRE,ROUND(a.MINPRE,0) AS MINPRE,a.TOTAL AS TOTAL
            FROM
                        (
                        select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && 
                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                                    GROUP BY despacho_detalles.NOMART),0))
                                                 AS saldoCorrecto,
                                                            t.NOMBRE,t.UNIMED,t.CODART,
                                                            (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,                                                            
                                                                        (SELECT MIN(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS MINPRE,
                                                                        ROUND(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                                                                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                                                                                    GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART)),0) AS TOTAL
                                                                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                                                              recepcion_detalles.PREUNI AS PREUNI,
                                                              ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP
                                                              from recepcion_detalles 
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                                      
                                                              union all
                                                      
                                                              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                               saldo_inventario.PRECIO AS PREUNI,
                                                               ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP
                                                              from saldo_inventario 
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                              ) t
                                                      group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE,t.CODBAR
                                                      
                                                      
                                                      UNION ALL 
                                                      
                                                      SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
                        siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS MINPRE,0 AS TOTAL
                        FROM siab_articulo
                        
                        ) a
                        WHERE saldoCorrecto > 0
                        group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.MINPRE,a.TOTAL
                        ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoPMP(){
        try {
            $get = DB::select('select SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0) AS CANTOT,SUM(t.PMP) AS PMP,ROUND((SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0))*SUM(t.PMP),0) AS VALTOT,t.CODART AS CODART from
            (SELECT ROUND(SUM(recepcion_detalles.CANREC),0) AS CANTOT,
            ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP,recepcion_detalles.CODART AS CODART FROM recepcion_detalles
            GROUP BY CODART
            
            UNION ALL
            
            SELECT ROUND(SUM(saldo_inventario.SALDO),0) AS CANTOT,
            ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP,saldo_inventario.CODART AS CODART FROM saldo_inventario
            GROUP BY CODART) t
            GROUP BY t.CODART 
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Busqueda Saldo Farmacia/Economato por Fecha

    public function GetSaldoValorizadoPCod(Request $request){
        try {
            $get = DB::select('select a.CODART,a.NOMBRE,a.UNIMED,ROUND(SUM(a.saldoCorrecto),0) AS saldoCorrecto,ROUND(a.ULTPRE,0) AS ULTPRE,ROUND(a.MINPRE,0) AS MINPRE,a.TOTAL AS TOTAL
            FROM
                        (
                        select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && 
                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                    GROUP BY despacho_detalles.NOMART),0))
                                                 AS saldoCorrecto,
                                                            t.NOMBRE,t.UNIMED,t.CODART,
                                                            (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,                                                            
                                                                        (SELECT MIN(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS MINPRE,
                                                                        ROUND(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                                                                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                                                    GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART)),0) AS TOTAL
                                                                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                                                              recepcion_detalles.PREUNI AS PREUNI,
                                                              ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP
                                                              from recepcion_detalles 
                                                              WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                                      
                                                              union all
                                                      
                                                              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                               saldo_inventario.PRECIO AS PREUNI,
                                                               ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP
                                                              from saldo_inventario 
                                                              WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                              ) t
                                                      group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE,t.CODBAR
                                                      
                                                      
                                                      UNION ALL 
                                                      
                                                      SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
                        siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS MINPRE,0 AS TOTAL
                        FROM siab_articulo
                        
                        ) a
                        WHERE saldoCorrecto > 0
                        group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.MINPRE,a.TOTAL
                        ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoPMPCod(Request $request){
        try {
            $get = DB::select('select SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0) AS CANTOT,SUM(t.PMP) AS PMP,ROUND((SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0))*SUM(t.PMP),0) AS VALTOT,t.CODART AS CODART from
            (SELECT ROUND(SUM(recepcion_detalles.CANREC),0) AS CANTOT,
            ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP,recepcion_detalles.CODART AS CODART FROM recepcion_detalles
            WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART
            
            UNION ALL
            
            SELECT ROUND(SUM(saldo_inventario.SALDO),0) AS CANTOT,
            ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP,saldo_inventario.CODART AS CODART FROM saldo_inventario
            WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART) t
            GROUP BY t.CODART 
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Busqueda Por Codigo y Fecha

    public function GetSaldoValorizadoPCodFecha(Request $request){
        try {
            $get = DB::select('select a.CODART,a.NOMBRE,a.UNIMED,ROUND(SUM(a.saldoCorrecto),0) AS saldoCorrecto,ROUND(a.ULTPRE,0) AS ULTPRE,ROUND(a.MINPRE,0) AS MINPRE,a.TOTAL AS TOTAL
            FROM
                        (
                        select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && 
                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                    GROUP BY despacho_detalles.NOMART),0))
                                                 AS saldoCorrecto,
                                                            t.NOMBRE,t.UNIMED,t.CODART,
                                                            (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,                                                            
                                                                        (SELECT MIN(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS MINPRE,
                                                                        ROUND(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                                                                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                                                    GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART)),0) AS TOTAL
                                                                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                                                              recepcion_detalles.PREUNI AS PREUNI,
                                                              ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP
                                                              from recepcion_detalles 
                                                              WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                                      
                                                              union all
                                                      
                                                              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                               saldo_inventario.PRECIO AS PREUNI,
                                                               ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP
                                                              from saldo_inventario 
                                                              WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                              ) t
                                                      group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE,t.CODBAR
                                                      
                                                      
                                                      UNION ALL 
                                                      
                                                      SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
                        siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS MINPRE,0 AS TOTAL
                        FROM siab_articulo
                        
                        ) a
                        WHERE saldoCorrecto > 0 && a.CODART BETWEEN "'.$request->codini.'" and "'.$request->codter.'"
                        group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.MINPRE,a.TOTAL
                        ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoPMPCodFecha(Request $request){
        try {
            $get = DB::select('select SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0) AS CANTOT,SUM(t.PMP) AS PMP,ROUND((SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0))*SUM(t.PMP),0) AS VALTOT,t.CODART AS CODART from
            (SELECT ROUND(SUM(recepcion_detalles.CANREC),0) AS CANTOT,
            ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP,recepcion_detalles.CODART AS CODART FROM recepcion_detalles
            WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART
            
            UNION ALL
            
            SELECT ROUND(SUM(saldo_inventario.SALDO),0) AS CANTOT,
            ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP,saldo_inventario.CODART AS CODART FROM saldo_inventario
            WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART) t
            WHERE t.CODART BETWEEN "'.$request->codini.'" and "'.$request->codter.'"
            GROUP BY t.CODART 
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Busqueda Farmacia Por Fecha

    public function GetSaldoValorizadoPFarmacia(Request $request){
        try {
            $get = DB::select('select a.CODART,a.NOMBRE,a.UNIMED,ROUND(SUM(a.saldoCorrecto),0) AS saldoCorrecto,ROUND(a.ULTPRE,0) AS ULTPRE,ROUND(a.MINPRE,0) AS MINPRE,a.TOTAL AS TOTAL
            FROM
                        (
                        select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && 
                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                    GROUP BY despacho_detalles.NOMART),0))
                                                 AS saldoCorrecto,
                                                            t.NOMBRE,t.UNIMED,t.CODART,
                                                            (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,                                                            
                                                                        (SELECT MIN(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS MINPRE,
                                                                        ROUND(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                                                                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                                                    GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART)),0) AS TOTAL
                                                                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                                                              recepcion_detalles.PREUNI AS PREUNI,
                                                              ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP
                                                              from recepcion_detalles
                                                              WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                                      
                                                              union all
                                                      
                                                              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                               saldo_inventario.PRECIO AS PREUNI,
                                                               ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP
                                                              from saldo_inventario
                                                              WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                              ) t
                                                      group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE,t.CODBAR
                                                      
                                                      
                                                      UNION ALL 
                                                      
                                                      SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
                        siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS MINPRE,0 AS TOTAL
                        FROM siab_articulo
                        
                        ) a
                        WHERE saldoCorrecto > 0 && a.CODART BETWEEN "2110000" and "3470066"
                        group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.MINPRE,a.TOTAL
                        ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoPMPFarmacia(Request $request){
        try {
            $get = DB::select('select SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0) AS CANTOT,SUM(t.PMP) AS PMP,ROUND((SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0))*SUM(t.PMP),0) AS VALTOT,t.CODART AS CODART from
            (SELECT ROUND(SUM(recepcion_detalles.CANREC),0) AS CANTOT,
            ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP,recepcion_detalles.CODART AS CODART FROM recepcion_detalles
            WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART
            
            UNION ALL
            
            SELECT ROUND(SUM(saldo_inventario.SALDO),0) AS CANTOT,
            ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP,saldo_inventario.CODART AS CODART FROM saldo_inventario
            WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART) t
            WHERE t.CODART BETWEEN "2110000" and "3470066"
            GROUP BY t.CODART 
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Busqueda Saldo PMP Economato Por Fecha

    public function GetSaldoValorizadoPEconomato(Request $request){
        try {
            $get = DB::select('select a.CODART,a.NOMBRE,a.UNIMED,ROUND(SUM(a.saldoCorrecto),0) AS saldoCorrecto,ROUND(a.ULTPRE,0) AS ULTPRE,ROUND(a.MINPRE,0) AS MINPRE,a.TOTAL AS TOTAL
            FROM
                        (
                        select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && 
                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                    GROUP BY despacho_detalles.NOMART),0))
                                                 AS saldoCorrecto,
                                                            t.NOMBRE,t.UNIMED,t.CODART,
                                                            (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS ULTPRE,                                                            
                                                                        (SELECT MIN(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART) AS MINPRE,
                                                                        ROUND(((SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.NOMART = t.NOMBRE && 
                                                                                    despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL && despacho_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                                                    GROUP BY despacho_detalles.NOMART),0)) * (SELECT MAX(recepcion_detalles.PREUNI)
                                                                        FROM recepcion_detalles LEFT JOIN saldo_inventario ON recepcion_detalles.CODART = saldo_inventario.CODART
                                                                        WHERE recepcion_detalles.CODART = t.CODART)),0) AS TOTAL
                                                                from (select SUM(recepcion_detalles.CANREC) as saldo, recepcion_detalles.PRODUCTO AS NOMBRE,
                                                              recepcion_detalles.CODBAR AS CODBAR,COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART,
                                                              recepcion_detalles.PREUNI AS PREUNI,
                                                              ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP
                                                              from recepcion_detalles
                                                              WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI
                                                      
                                                              union all
                                                      
                                                              select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                               saldo_inventario.CODART_BARR AS CODBAR,COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART,
                                                               saldo_inventario.PRECIO AS PREUNI,
                                                               ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP
                                                              from saldo_inventario
                                                              WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                              group by NOMBRE,CODBAR,LOTE,UNIMED,CODART,PREUNI                         
                                                              ) t
                                                      group by t.NOMBRE,t.UNIMED,t.CODART,ULTPRE,t.CODBAR
                                                      
                                                      
                                                      UNION ALL 
                                                      
                                                      SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,siab_articulo.UNIMEDBASE AS UNIMED,
                        siab_articulo.CODART AS CODART,0 AS ULTPRE,0 AS MINPRE,0 AS TOTAL
                        FROM siab_articulo
                        
                        ) a
                        WHERE saldoCorrecto > 0 && a.CODART NOT BETWEEN "2110000" and "3470066"
                        group by a.NOMBRE,a.UNIMED,a.CODART,a.ULTPRE,a.MINPRE,a.TOTAL
                        ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetSaldosValorizadoPMPEconomato(Request $request){
        try {
            $get = DB::select('select SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0) AS CANTOT,SUM(t.PMP) AS PMP,ROUND((SUM(t.CANTOT)- COALESCE((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODART = t.CODART),0))*SUM(t.PMP),0) AS VALTOT,t.CODART AS CODART from
            (SELECT ROUND(SUM(recepcion_detalles.CANREC),0) AS CANTOT,
            ROUND(ROUND(SUM(recepcion_detalles.VALTOT),0)/ROUND(SUM(recepcion_detalles.CANREC),0),1) AS PMP,recepcion_detalles.CODART AS CODART FROM recepcion_detalles
            WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART
            
            UNION ALL
            
            SELECT ROUND(SUM(saldo_inventario.SALDO),0) AS CANTOT,
            ROUND(ROUND(SUM(saldo_inventario.SALDO*saldo_inventario.PRECIO),0)/ROUND(SUM(saldo_inventario.SALDO),0),1) AS PMP,saldo_inventario.CODART AS CODART FROM saldo_inventario
            WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
            GROUP BY CODART) t
            WHERE t.CODART NOT BETWEEN "2110000" and "3470066"
            GROUP BY t.CODART 
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    //Bincard

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

    public function GetBincardFVen(Request $request){
        try {
            $saldoinv = saldo_inventarios::select(DB::raw("'Saldo Inventario' AS TIPO"), 'saldo_inventario.NOMBRE AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(saldo_inventario.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw("'-' AS FOLDES"),DB::raw("'-' AS FOLREC"),DB::raw("'-' AS PROVEEDOR"),
            DB::raw("COALESCE(STR_TO_DATE(DATE_FORMAT(saldo_inventario.FECVEN,'%d-%m-%Y %H'),'%d-%m-%Y'),'-') AS FECVEN"),
            DB::raw("COALESCE(saldo_inventario.LOTE,'-') AS LOTE"),
            'saldo_inventario.CODART AS CODART','saldo_inventario.CODART_BARR AS CODBAR','saldo_inventario.PRECIO AS PRECIO',
            'saldo_inventario.SALDO AS CANTIDAD',DB::raw("'-' AS SERVICIO"))
            ->where('saldo_inventario.CODART',$request->CODART);

            $recepciondet = recepcionDetalles::select(DB::raw("'Recepcion' AS TIPO"), 'recepcion_detalles.PRODUCTO AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(recepcion_detalles.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw("'-' AS FOLDES"),DB::raw('COALESCE(recepcion_detalles.FOLIO,"-") AS FOLREC'),'recepciones.NOMPRO AS PROVEEDOR',            
            DB::raw("COALESCE(STR_TO_DATE(DATE_FORMAT(recepcion_detalles.FECVEN,'%d-%m-%Y %H'),'%d-%m-%Y'),'-') AS FECVEN"),
            DB::raw("COALESCE(recepcion_detalles.LOTE,'-') AS LOTE"),
            'recepcion_detalles.CODART AS CODART','recepcion_detalles.CODBAR AS CODBAR','recepcion_detalles.PREUNI AS PRECIO',
            'recepcion_detalles.CANREC AS CANTIDAD',DB::raw("'-' AS SERVICIO"))
            ->join('recepciones','recepcion_detalles.NUMINT','=','recepciones.NUMINT')
            ->where('recepcion_detalles.CODART',$request->CODART);

            $despachodet = despachoDetalles::select(DB::raw("'Despacho' AS TIPO"), 'despacho_detalles.NOMART AS NOMBRE',
            DB::raw("STR_TO_DATE(DATE_FORMAT(despacho_detalles.created_at,'%d-%m-%Y %H'),'%d-%m-%Y %H') as FECHA"),
            DB::raw('COALESCE(despacho_detalles.FOLIO,"-") AS FOLDES'),DB::raw("'-' AS FOLREC"),DB::raw("'-' AS PROVEEDOR"),
            DB::raw("COALESCE(STR_TO_DATE(DATE_FORMAT(despacho_detalles.FECVEN,'%d-%m-%Y %H'),'%d-%m-%Y'),'-') AS FECVEN"),
            DB::raw("COALESCE(despacho_detalles.LOTE,'-') AS LOTE"),
            'despacho_detalles.CODART AS CODART','despacho_detalles.CODBAR AS CODBAR','despacho_detalles.PRECIO AS PRECIO',
            'despacho_detalles.CANTIDAD AS CANTIDAD',DB::raw('COALESCE(servicios.descripcionServicio,"-") AS SERVICIO'))
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
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetArticulosSaldoEstadoC(Request $request){
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
            WHERE saldoCorrecto > 0 && a.CODART BETWEEN "'.$request->CODINI.'" and "'.$request->CODTER.'"
            group by a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetArticulosSaldoEstadoCovid(Request $request){
        try {
            $get = DB::select('select SUM(a.saldoCorrecto) AS saldoCorrecto,a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            FROM (select (SUM(t.saldo) - COALESCE((SELECT sum(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = t.LOTE && 
                        despacho_detalles.CODMOT IS NULL && despacho_detalles.FOLIO IS NOT NULL
                        GROUP BY despacho_detalles.LOTE),0))
                                     AS saldoCorrecto,
                                                t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS ZGEN,
                                                (SELECT auth_estados.descripcionEstado FROM siab_articulo JOIN auth_estados ON siab_articulo.idEstado = auth_estados.id WHERE t.CODART = siab_articulo.CODART LIMIT 1) AS Estado
                                                    from (select SUM(recepcion_detalles.CANREC) as saldo, siab_articulo.NOMBRE AS NOMBRE,
                                                  COALESCE(recepcion_detalles.LOTE,"No tiene LOTE") AS LOTE,recepcion_detalles.UNIMED AS UNIMED,recepcion_detalles.CODART AS CODART
                                                  from recepcion_detalles
                                                  JOIN siab_articulo ON recepcion_detalles.CODART = siab_articulo.CODART
                                                  WHERE siab_articulo.COVID = 1
                                                  group by NOMBRE,LOTE,UNIMED,CODART
                                          
                                                  union all
                                          
                                                  select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                  COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART
                                                  from saldo_inventario
                                                  JOIN siab_articulo ON saldo_inventario.CODART = siab_articulo.CODART
                                                  WHERE siab_articulo.COVID = 1
                                                  group by NOMBRE,LOTE,UNIMED,CODART                         
                                                  ) t
                                          group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
                                          
                                          UNION ALL 
                                          
              SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,"No tiene LOTE" AS LOTE,siab_articulo.UNIMEDBASE AS UNIMED,
               siab_articulo.CODART AS CODART,siab_articulo.ZGEN AS ZGEN,auth_estados.descripcionEstado AS Estado
               FROM siab_articulo JOIN auth_estados ON siab_articulo.idEstado = auth_estados.id
            )a 
            WHERE saldoCorrecto > 0 && a.CODART BETWEEN "'.$request->CODINI.'" and "'.$request->CODTER.'"
            group by a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetArticulosSaldoEstadoCF(Request $request){
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
                                                  WHERE recepcion_detalles.FECDES BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                  group by NOMBRE,LOTE,UNIMED,CODART
                                          
                                                  union all
                                          
                                                  select SUM(saldo_inventario.SALDO) as saldo, saldo_inventario.NOMBRE AS NOMBRE,
                                                  COALESCE(saldo_inventario.LOTE,"No tiene LOTE") AS LOTE,saldo_inventario.UNIMEDBASE AS UNIMED,saldo_inventario.CODART AS CODART
                                                  from saldo_inventario
                                                  WHERE saldo_inventario.created_at BETWEEN "'.$request->FECINI.'" AND "'.$request->FECTER.'"
                                                  group by NOMBRE,LOTE,UNIMED,CODART                         
                                                  ) t
                                          group by t.NOMBRE,t.LOTE,t.UNIMED,t.CODART,ZGEN
                                          
                                          UNION ALL 
                                          
              SELECT 0 AS saldoCorrecto,siab_articulo.NOMBRE AS NOMBRE,"No tiene LOTE" AS LOTE,siab_articulo.UNIMEDBASE AS UNIMED,
               siab_articulo.CODART AS CODART,siab_articulo.ZGEN AS ZGEN,auth_estados.descripcionEstado AS Estado
               FROM siab_articulo JOIN auth_estados ON siab_articulo.idEstado = auth_estados.id
            )a 
            WHERE saldoCorrecto > 0 && a.CODART BETWEEN "'.$request->CODINI.'" and "'.$request->CODTER.'"
            group by a.NOMBRE,a.LOTE,a.UNIMED,a.CODART,a.ZGEN,a.Estado
            ORDER BY a.CODART ASC
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetConsumoAnio(Request $request){
        try {
            $get = despachoDetalles::select('despacho_detalles.NOMART AS NOMBRE','despacho_detalles.CODART AS CODART','despacho_detalles.UNIMED AS UNIMED',
            DB::raw('(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE siab_articulo.CODART = despacho_detalles.CODART LIMIT 1) as ZGEN'),
            DB::raw('COALESCE(SUM(despacho_detalles.CANTIDAD),0) AS CONSUMO'))
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->groupBy('despacho_detalles.NOMART','despacho_detalles.CODART','despacho_detalles.UNIMED')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetConsumoMes(Request $request){
        try {
            $get = despachoDetalles::select('despacho_detalles.NOMART AS NOMBRE','despacho_detalles.CODART AS CODART','despacho_detalles.UNIMED AS UNIMED',DB::raw('"'.$request->MES.'" AS MES'),
            DB::raw('(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE siab_articulo.CODART = despacho_detalles.CODART LIMIT 1) as ZGEN'),
            DB::raw('COALESCE(SUM(despacho_detalles.CANTIDAD),0) AS CONSUMO'))
            ->whereRaw('DATE_FORMAT(despacho_detalles.FECDES,"%m") = "'.$request->MES.'"')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->groupBy('despacho_detalles.NOMART','despacho_detalles.CODART','despacho_detalles.UNIMED')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetConsumoMesServicio(Request $request){
        try {
            $get = despachoDetalles::select('despacho_detalles.NOMART AS NOMBRE','despacho_detalles.CODART AS CODART','despacho_detalles.UNIMED AS UNIMED',DB::raw('"'.$request->MES.'" AS MES'),
            'servicios.descripcionServicio AS descripcionServicio',DB::raw('(SELECT siab_articulo.ZGEN FROM siab_articulo WHERE siab_articulo.CODART = despacho_detalles.CODART LIMIT 1) as ZGEN'),
            DB::raw('COALESCE(SUM(despacho_detalles.CANTIDAD),0) AS CONSUMO'))
            ->join('servicios', 'despacho_detalles.idServicio','=','servicios.id')
            ->where('servicios.id',$request->idServicio)
            ->whereRaw('DATE_FORMAT(despacho_detalles.FECDES,"%m") = "'.$request->MES.'"')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->groupBy('despacho_detalles.NOMART','despacho_detalles.CODART','despacho_detalles.UNIMED','servicios.descripcionServicio')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetFechaVencimiento(Request $request){
        try {
            $get = DB::select('select t.CODART,t.NOMBRE,t.UNIMED,t.FECVEN,t.LOTE,t.CODBAR,
            COALESCE(COALESCE(SUM(t.SALDO),0) - COALESCE((SELECT SUM(CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.CODBAR = t.CODBAR && despacho_detalles.LOTE = t.LOTE),0),0) AS SALDO,
            COALESCE(TIMESTAMPDIFF(DAY,CURRENT_DATE(),t.FECVEN),0) AS DIASVENCIMIENTO,t.FOLIO,t.FRECEP,t.NOMPROV,t.TIPDOC,t.NUMDOC,t.DIASREC,t.ORDENCOMPRA
             FROM (SELECT recepcion_detalles.CODART AS CODART,recepcion_detalles.PRODUCTO AS NOMBRE,recepcion_detalles.UNIMED AS UNIMED,
            COALESCE(recepcion_detalles.FECVEN,"-") AS FECVEN,COALESCE(recepcion_detalles.LOTE,"-") AS LOTE,recepcion_detalles.CODBAR AS CODBAR,recepcion_detalles.CANREC AS SALDO,
            recepcion_detalles.FOLIO AS FOLIO,recepcion_detalles.FECDES AS FRECEP,recepciones.NOMPRO AS NOMPROV,recepciones.TIPDOC AS TIPDOC,
            recepciones.NUMDOC AS NUMDOC,COALESCE(TIMESTAMPDIFF(DAY,recepcion_detalles.FECDES,recepcion_detalles.FECVEN),0) AS DIASREC,recepciones.NUMORD AS ORDENCOMPRA
            FROM recepcion_detalles
            JOIN recepciones ON recepcion_detalles.FOLIO = recepciones.FOLIO
            
            UNION ALL
            
            SELECT saldo_inventario.CODART AS CODART,saldo_inventario.NOMBRE AS NOMBRE,saldo_inventario.UNIMEDBASE AS UNIMED,COALESCE(saldo_inventario.FECVEN,"-")AS FECVEN,
            COALESCE(saldo_inventario.LOTE,"-") AS LOTE,saldo_inventario.CODART_BARR AS CODBAR,saldo_inventario.SALDO AS SALDO,"-" AS FOLIO,
            "-" AS FRECEP,"-" AS NOMPROV,"-" AS TIPDOC,"-" AS NUMDOC,"-" AS DIASREC,"-" AS ORDENCOMPRA FROM saldo_inventario) t
            WHERE t.CODART BETWEEN "'.$request->CODINI.'" AND "'.$request->CODTER.'"
            GROUP BY t.CODART,t.NOMBRE,t.UNIMED,t.FECVEN,t.LOTE,t.CODBAR,t.FOLIO,t.FRECEP,t.NOMPROV,t.TIPDOC,t.NUMDOC,t.DIASREC,t.ORDENCOMPRA
            ');
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetZGENPriorizados(Request $request){
        try {
            $get = siab_articulos::select('recepciones.NUMORD AS NUMORD',DB::raw('"13" AS CDEISSV'),DB::raw('"130150" AS DEISEST'),
            'siab_articulo.ZGEN AS ZGEN','siab_articulo.CODART AS CODART','siab_articulo.NOMBRE AS NOMBRE',
            DB::raw('"SI" AS VALMED'),
            DB::raw('"'.$request->MES.'" AS MES'),
            DB::raw('siab_articulo.CODART_BARR AS CODBAR'),
            DB::raw("ROUND(COALESCE(SUM(saldo_inventario.CANTIDAD),0),0) AS STOCKFISICO"),
            DB::raw("ROUND(COALESCE(SUM(saldo_inventario.CANTIDAD),0),0) AS STOCKBINSAL"),
            DB::raw("ROUND(COALESCE(SUM(recepcion_detalles.CANREC),0),0) AS CANREC"),
            DB::raw("0 AS CANDEL"),
            DB::raw("0 AS CANPRES"),
            DB::raw("0 AS CANPAC"),
            DB::raw("0 AS CANPOE"),
            DB::raw("0 AS UMERMA"),
            DB::raw("0 AS MONMERMA"),
            DB::raw("ROUND(SUM(recepcion_detalles.CANREC),0)- COALESCE(ROUND((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = recepcion_detalles.LOTE),0),0) AS SALDO"),
            DB::raw("ROUND(SUM(recepcion_detalles.CANREC),0)- COALESCE(ROUND((SELECT SUM(despacho_detalles.CANTIDAD) FROM despacho_detalles WHERE despacho_detalles.LOTE = recepcion_detalles.LOTE),0),0) AS SALDOBIN"),
            DB::raw("ROUND(recepcion_detalles.PREUNI,0) AS PRECIO1"),
            DB::raw("ROUND((SELECT if((select COUNT(recepcion_detalles.PREUNI) FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR) > 1,(SELECT recepcion_detalles.PREUNI FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR LIMIT 1,1),0)),0) AS PRECIO2"),
            DB::raw("ROUND((SELECT if((select COUNT(recepcion_detalles.PREUNI) FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR) > 2,(SELECT recepcion_detalles.PREUNI FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR LIMIT 2,1),0)),0) AS PRECIO3"),
            DB::raw("ROUND((SELECT if((select COUNT(recepcion_detalles.PREUNI) FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR) > 3,(SELECT recepcion_detalles.PREUNI FROM recepcion_detalles WHERE recepcion_detalles.CODBAR = siab_articulo.CODART_BARR LIMIT 3,1),0)),0) AS PRECIO4"))
            ->join('recepcion_detalles', 'siab_articulo.CODART_BARR','=','recepcion_detalles.CODBAR')            
            ->leftjoin('saldo_inventario', 'recepcion_detalles.CODBAR','=','saldo_inventario.CODART_BARR')
            ->leftjoin('recepciones', 'recepcion_detalles.FOLIO','=','recepciones.FOLIO')
            ->whereRaw('DATE_FORMAT(recepcion_detalles.FECDES,"%m") = "'.$request->MES.'" && siab_articulo.GENERICO !="\\\N"')
            ->groupBy('NUMORD','ZGEN','CODART','NOMBRE','CODBAR','recepcion_detalles.LOTE','PRECIO1')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetZGEN(Request $request){
        try {
            $get = siab_articulos::select('recepciones.NUMORD AS NUMORD',DB::raw('"13" AS CDEISSV'),DB::raw('"130150" AS DEISEST'),
            'siab_articulo.ZGEN AS ZGEN','siab_articulo.CODART AS CODART','siab_articulo.NOMBRE AS NOMBRE',
            DB::raw('"SI" AS VALMED'),DB::raw('"'.$request->MES.'" AS MES'),
            DB::raw("ROUND(SUM(recepcion_detalles.CANREC),0) AS CANREC"),DB::raw("MAX(ROUND(recepcion_detalles.PREUNI,0)) AS PRECIO"),
            DB::raw("ROUND(SUM(COALESCE(recepcion_detalles.CANREC,0)) * SUM(COALESCE(recepcion_detalles.PREUNI,0)),0) AS TOTAL"),
            "recepcion_detalles.UNIMED AS UNIMED",DB::raw('"'.$request->MES.'" AS MESSAL'),
            DB::raw("ROUND(SUM(COALESCE(despacho_detalles.CANTIDAD,0)),0) AS DESPACHO"))
            ->join('recepcion_detalles', 'siab_articulo.CODART_BARR','=','recepcion_detalles.CODBAR')
            ->join('recepciones', 'recepcion_detalles.FOLIO','=','recepciones.FOLIO')
            ->leftjoin('despacho_detalles', 'recepcion_detalles.LOTE','=','despacho_detalles.LOTE')
            ->whereRaw('DATE_FORMAT(recepcion_detalles.FECDES,"%m") = "'.$request->MES.'" && siab_articulo.GENERICO !="\\\N"')
            ->groupBy('NUMORD','CDEISSV','DEISEST','ZGEN','siab_articulo.CODART','recepcion_detalles.PREUNI','NOMBRE','VALMED','UNIMED')
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }    
    }

    public function GetDespachoxServicio(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("STR_TO_DATE(DATE_FORMAT(despacho_detalles.FECDES,'%d-%m-%Y'),'%d-%m-%Y') as FECDES"),
            'despacho_detalles.FOLIO','despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('ROUND(despacho_detalles.CANTIDAD,0) AS CANTIDAD'),DB::raw('ROUND(despacho_detalles.PRECIO,0) AS PRECIO'),DB::raw('ROUND(despacho_detalles.CANTIDAD*despacho_detalles.PRECIO,0) AS TOTAL'),
            'servicios.descripcionServicio')
            ->join('servicios', 'despacho_detalles.idServicio','=','servicios.id')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetDespachoxServicioI(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("STR_TO_DATE(DATE_FORMAT(despacho_detalles.FECDES,'%d-%m-%Y'),'%d-%m-%Y') as FECDES"),
            'despacho_detalles.FOLIO','despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('ROUND(despacho_detalles.CANTIDAD,0) AS CANTIDAD'),DB::raw('ROUND(despacho_detalles.PRECIO,0) AS PRECIO'),DB::raw('ROUND(despacho_detalles.CANTIDAD*despacho_detalles.PRECIO,0) AS TOTAL'),
            'servicios.descripcionServicio')
            ->join('servicios', 'despacho_detalles.idServicio','=','servicios.id')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->where('despacho_detalles.idServicio', $request->idServicio)
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetRecepcionxServicio(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("STR_TO_DATE(DATE_FORMAT(despacho_detalles.FECDES,'%d-%m-%Y'),'%d-%m-%Y') as FECDES"),
            'despacho_detalles.FOLIO','despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('ROUND(despacho_detalles.CANTIDAD,0) AS CANTIDAD'),DB::raw('ROUND(despacho_detalles.PRECIO,0) AS PRECIO'),DB::raw('ROUND(despacho_detalles.CANTIDAD*despacho_detalles.PRECIO,0) AS TOTAL'),
            'servicios.descripcionServicio')
            ->join('servicios', 'despacho_detalles.idServicio','=','servicios.id')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetConsolidadoDespacho(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("DATE_FORMAT(despacho_detalles.FECDES,'%m') AS MES"),
            'despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('SUM(despacho_detalles.CANTIDAD) AS CANTIDAD'),DB::raw('MAX(despacho_detalles.PRECIO) AS PRECIO'),
            DB::raw('ROUND(MAX(despacho_detalles.PRECIO)*SUM(despacho_detalles.CANTIDAD),0) AS TOTAL'))
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->groupBy('MES','CODART','NOMART','UNIMED')
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetConsolidadoDespachoServicio(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("DATE_FORMAT(despacho_detalles.FECDES,'%m') AS MES"),
            'despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('SUM(despacho_detalles.CANTIDAD) AS CANTIDAD'),DB::raw('MAX(despacho_detalles.PRECIO) AS PRECIO'),
            DB::raw('ROUND(MAX(despacho_detalles.PRECIO)*SUM(despacho_detalles.CANTIDAD),0) AS TOTAL'))
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->where('despacho_detalles.idServicio', $request->idServicio)
            ->groupBy('MES','CODART','NOMART','UNIMED')
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetConsolidadoDespachoServicioCovid(Request $request){
        try {
            $get = despachoDetalles::select(DB::raw("DATE_FORMAT(despacho_detalles.FECDES,'%m') AS MES"),
            'despacho_detalles.CODART','despacho_detalles.NOMART','despacho_detalles.UNIMED',
            DB::raw('SUM(despacho_detalles.CANTIDAD) AS CANTIDAD'),DB::raw('MAX(despacho_detalles.PRECIO) AS PRECIO'),
            DB::raw('ROUND(MAX(despacho_detalles.PRECIO)*SUM(despacho_detalles.CANTIDAD),0) AS TOTAL'))
            ->join('siab_articulo', 'despacho_detalles.CODART','=','siab_articulo.CODART')
            ->whereBetween('despacho_detalles.CODART', [$request->CODINI, $request->CODTER])
            ->whereBetween('despacho_detalles.FECDES', [$request->FECINI, $request->FECTER])
            ->whereRaw('siab_articulo.COVID IS TRUE')
            ->groupBy('MES','CODART','NOMART','UNIMED')
            ->get();

            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
