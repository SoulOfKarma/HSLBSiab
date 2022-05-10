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
    Route::get('/Mantenedor/GetProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@GetProveedor']);
    
    //Posts 
    Route::post('/Mantenedor/PostProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PostProveedor']);

    //Post Como Put
    Route::post('/Mantenedor/ModificarProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@ModificarProveedor']);

    
});

//Generar PDF
Route::get('/Bodega/ActaEntregaPDF/{idSolicitud}/{idCategoria}/{nombre}', ['middleware' => 'cors', 'uses' => 'MaterialInventariosController@ActaEntregaPDF']);
