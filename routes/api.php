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
    Route::get('/Mantenedor/GetLaboratorio', ['middleware' => 'cors', 'uses' => 'SiabLaborsController@GetLaboratorio']);
    Route::get('/Mantenedor/GetAnulacion', ['middleware' => 'cors', 'uses' => 'MotivoAnulacionesController@GetAnulacion']);
    Route::get('/Mantenedor/GetAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@GetAnulacion']);
    Route::get('/Mantenedor/GetServicios', ['middleware' => 'cors', 'uses' => 'ServiciosController@GetServicios']);
    Route::get('/Mantenedor/GetAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@GetAuthUsuario']);
    Route::get('/Mantenedor/GetAuthEstado', ['middleware' => 'cors', 'uses' => 'AuthEstadosController@GetAuthEstado']);
    
    //Posts 
    Route::post('/Mantenedor/PostProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PostProveedor']);
    Route::post('/Mantenedor/PostLaboratorio', ['middleware' => 'cors', 'uses' => 'SiabLaborsController@PostLaboratorio']);
    Route::post('/Mantenedor/PostAnulacion', ['middleware' => 'cors', 'uses' => 'MotivoAnulacionesController@PostAnulacion']);
    Route::post('/Mantenedor/PostAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PostAuthUsuario']);
    Route::post('/Mantenedor/PostServicios', ['middleware' => 'cors', 'uses' => 'ServiciosController@PostServicios']);
    Route::post('/Mantenedor/PostAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PostAuthUsuario']);
    Route::post('/Mantenedor/PostAuthEstado', ['middleware' => 'cors', 'uses' => 'AuthEstadosController@PostAuthEstado']);

    //Post Como Put
    Route::post('/Mantenedor/PutProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PutProveedor']);
    Route::post('/Mantenedor/PutLaboratorio', ['middleware' => 'cors', 'uses' => 'SiabLaborsController@PutLaboratorio']);
    Route::post('/Mantenedor/PutAnulacion', ['middleware' => 'cors', 'uses' => 'MotivoAnulacionesController@PutAnulacion']);
    Route::post('/Mantenedor/PutAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PutAnulacion']);
    Route::post('/Mantenedor/PutServicio', ['middleware' => 'cors', 'uses' => 'ServiciosController@PutServicio']);
    Route::post('/Mantenedor/PutAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PutAuthUsuario']);
    Route::post('/Mantenedor/PutAuthEstado', ['middleware' => 'cors', 'uses' => 'AuthEstadosController@PutAuthEstado']);

    //Post Documentos
    Route::post('/Mantenedor/PostDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PostDocumentoAuthUsuario']);

    
});

//Generar PDF
Route::get('/Bodega/ActaEntregaPDF/{idSolicitud}/{idCategoria}/{nombre}', ['middleware' => 'cors', 'uses' => 'MaterialInventariosController@ActaEntregaPDF']);
