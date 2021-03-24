<?php

namespace App\Http\Controllers;

use App\MaterialCubiculos;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class MaterialCubiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getAll(){
        $get_all = MaterialCubiculos::all();
        return $get_all;
     }

     public function PostCubiculo(Request $request){
        try {
            $res = MaterialCubiculos::create($request->all());
            return true;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaterialCubiculos  $materialCubiculos
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialCubiculos $materialCubiculos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaterialCubiculos  $materialCubiculos
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialCubiculos $materialCubiculos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaterialCubiculos  $materialCubiculos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialCubiculos $materialCubiculos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaterialCubiculos  $materialCubiculos
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialCubiculos $materialCubiculos)
    {
        //
    }
}
