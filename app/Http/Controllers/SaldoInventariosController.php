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
}
