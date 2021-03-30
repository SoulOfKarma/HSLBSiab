<?php

namespace App\Http\Controllers;

use App\RetornarMateriales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RetornarMaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $res = RetornarMateriales::all();
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
                RetornarMateriales::create(array_merge($req,['id_ticket' => $req['idOT'],'id_estados' => 2]));
            }
            return true;
        } catch (\Throwable $th) {
            log::info($th);
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RetornarMateriales  $retornarMateriales
     * @return \Illuminate\Http\Response
     */
    public function show(RetornarMateriales $retornarMateriales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RetornarMateriales  $retornarMateriales
     * @return \Illuminate\Http\Response
     */
    public function edit(RetornarMateriales $retornarMateriales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RetornarMateriales  $retornarMateriales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RetornarMateriales $retornarMateriales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RetornarMateriales  $retornarMateriales
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetornarMateriales $retornarMateriales)
    {
        //
    }
}
