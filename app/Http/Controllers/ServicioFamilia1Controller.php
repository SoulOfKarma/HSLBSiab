<?php

namespace App\Http\Controllers;

use App\ServicioFamilia1;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class ServicioFamilia1Controller extends Controller
{
    public function GetSF1(){
        try {
            $get = ServicioFamilia1::all();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function PostSF1(Request $request){
        try {
            ServicioFamilia1::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function UpdateSF1(Request $request){
        try {
            ServicioFamilia1::where('id', $request->id)
            ->update(['descripcionSF1' => $request->descripcionSF1]);
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetServiciosTodos(){
        try {
            $get = ServicioFamilia1::select('servicio_familia1s.id',DB::raw('servicio_familia1s.descripcionSF1 as descripcionSF1'),
            'servicio_familia2s.id',DB::raw('servicio_familia2s.descripcionSF2 as descripcionSF2'),
            'servicio_familia3s.id',DB::raw('COALESCE(servicio_familia3s.descripcionSF3,"No tiene Departamentos") as descripcionSF3'),
            'servicio_familia4s.id',DB::raw('COALESCE(servicio_familia4s.descripcionSF4,"No Tiene Unidades") as descripcionSF4'),
            'servicio_familia5s.id',DB::raw('COALESCE(servicio_familia5s.descripcionSF5,"No tiene Sub-Unidades") as descripcionSF5'))
            ->join('servicio_familia2s','servicio_familia1s.id','=','servicio_familia2s.idSF1')
            ->leftjoin('servicio_familia3s','servicio_familia2s.id','=','servicio_familia3s.idSF2')
            ->leftjoin('servicio_familia4s','servicio_familia3s.id','=','servicio_familia4s.idSF3')
            ->leftjoin('servicio_familia5s','servicio_familia4s.id','=','servicio_familia5s.idSF4')
            ->get();
            return $get;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    public function GetServiciosActivos(){
        try {
            $get = ServicioFamilia1::select(DB::raw('COALESCE(servicio_familia3s.descripcionSF3,"No tiene Departamentos") as descripcionSF3'),
            DB::raw('servicio_familia3s.visualizar as VisualizarSF3'),
            DB::raw('COALESCE(servicio_familia4s.descripcionSF4,"No Tiene Unidades") as descripcionSF4'),
            DB::raw('servicio_familia4s.visualizar as VisualizarSF4'),
            DB::raw('COALESCE(servicio_familia5s.descripcionSF5,"No tiene Sub-Unidades") as descripcionSF5'),
            DB::raw('servicio_familia5s.visualizar as VisualizarSF5'))
            ->distinct()
            ->join('servicio_familia2s','servicio_familia1s.id','=','servicio_familia2s.idSF1')
            ->leftjoin('servicio_familia3s','servicio_familia2s.id','=','servicio_familia3s.idSF2')
            ->leftjoin('servicio_familia4s','servicio_familia3s.id','=','servicio_familia4s.idSF3')
            ->leftjoin('servicio_familia5s','servicio_familia4s.id','=','servicio_familia5s.idSF4')
            ->where('servicio_familia3s.visualizar',true)
            ->orwhere('servicio_familia4s.visualizar',true)
            ->orwhere('servicio_familia5s.visualizar',true)
            ->get();

            $dato = [];

            foreach ($get as $key=>$b) {
                    if($b->VisualizarSF3){
                        $dato[$key] = ['id' => $key+1,'descripcionServicio' => $b->descripcionSF3];
                    }else if($b->VisualizarSF4){
                        $dato[$key] = ['id' => $key+1,'descripcionServicio' => $b->descripcionSF4];
                    }else if($b->VisualizarSF5){
                        $dato[$key] = ['id' => $key+1,'descripcionServicio' => $b->descripcionSF5];
                    }
            }

            $dato = json_encode($dato);

            $dato = json_decode($dato);

            return $dato;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }
}
