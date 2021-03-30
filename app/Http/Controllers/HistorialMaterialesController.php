<?php

namespace App\Http\Controllers;

use App\HistorialMateriales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HistorialMaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $res = HistorialMateriales::all();
            return $res;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            foreach($data as $e => $req ){                       
                HistorialMateriales::create(array_merge($req,['id_ticket' => $req['idOT'],'id_estados' => 1]));
            }
            //HistorialMateriales::create($request->all());
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\HistorialMateriales  $historialMateriales
     * @return \Illuminate\Http\Response
     */
    public function show(HistorialMateriales $historialMateriales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HistorialMateriales  $historialMateriales
     * @return \Illuminate\Http\Response
     */
    public function edit(HistorialMateriales $historialMateriales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HistorialMateriales  $historialMateriales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistorialMateriales $historialMateriales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HistorialMateriales  $historialMateriales
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistorialMateriales $historialMateriales)
    {
        //
    }
}
