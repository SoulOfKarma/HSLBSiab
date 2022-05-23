<?php

namespace App\Http\Controllers;

use App\saldo_inventarios;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class SaldoInventariosController extends Controller
{
    public function PostSaldoInventario(Request $request){
        try {
            saldo_inventarios::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetSaldoInventario(){
        try {
            $get = saldo_inventarios::select('saldo_inventario.id','saldo_inventario.NOMBRE','saldo_inventario.UNIMEDBASE','saldo_inventario.CODART_ONU',
            'saldo_inventario.CODART','saldo_inventario.CODART_BARR','auth_estados.descripcionEstado',
            'saldo_inventario.UBICACION','saldo_inventario.SECTOR','bodega.descripcionBodega','zona.descripcionZonas',
            'saldo_inventario.CANTXENB','saldo_inventario.ACT_FECVEN as idACT_FECVEN','saldo_inventario.ACT_LOTE AS idACTLOTE',
            DB::raw("(CASE WHEN saldo_inventario.ACT_FECVEN = 1 THEN 'Si' ELSE 'No' END) as ACT_FECVEN"),
            DB::raw("(CASE WHEN saldo_inventario.ACT_LOTE = 1 THEN 'Si' ELSE 'No' END) as ACT_LOTE"),
            'saldo_inventario.idEstado','saldo_inventario.idBodega','saldo_inventario.idZona','saldo_inventario.NOMFAM1','saldo_inventario.NOMFAM2',
            'saldo_inventario.NOMFAM3','saldo_inventario.NOMFAM4','saldo_inventario.NOMFAM5'
            )
           ->leftjoin('auth_estados','saldo_inventario.idEstado','=','auth_estados.id')
           ->leftjoin('bodega','saldo_inventario.idBodega','=','bodega.id')
           ->leftjoin('zona','saldo_inventario.idZona','=','zona.id')
           ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
