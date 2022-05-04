<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/Login/Salir', 'LoginController@salir');
Route::post('/Login/GetUsers', 'LoginController@getUsuarios');
Route::post('/Login/getpr', 'LoginController@adminPr');
Route::post('/auth/login','LoginController@login');

Route::group(['middleware' => ['jwt.verify']], function() {
    //Gets
    Route::get('/Bodega/GetUbicaciones', ['middleware' => 'cors', 'uses' => 'MaterialUbicacionesController@getAll']);
    
    //Posts 
    Route::post('/Bodega/PostMaterial', ['middleware' => 'cors', 'uses' => 'MaterialIngresadoController@PostMaterial']);

    //Post Como Put
    Route::post('/Bodega/PutInventario', ['middleware' => 'cors', 'uses' => 'MaterialInventariosController@PutInventario']);

    
});

//Generar PDF
Route::get('/Bodega/ActaEntregaPDF/{idSolicitud}/{idCategoria}/{nombre}', ['middleware' => 'cors', 'uses' => 'MaterialInventariosController@ActaEntregaPDF']);
