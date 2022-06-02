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
    Route::get('/Mantenedor/GetLabUsuario', ['middleware' => 'cors', 'uses' => 'LabUsuariosController@GetLabUsuario']);
    Route::get('/Mantenedor/GetBodega', ['middleware' => 'cors', 'uses' => 'BodegasController@GetBodega']);
    Route::get('/Mantenedor/GetFamilia1', ['middleware' => 'cors', 'uses' => 'DescripcionFamiliaController@GetFamilia']);
    Route::get('/Mantenedor/GetFamilia2', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia01Controller@GetFamilia']);
    Route::get('/Mantenedor/GetFamilia3', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia02Controller@GetFamilia']);
    Route::get('/Mantenedor/GetFamilia4', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia03Controller@GetFamilia']);
    Route::get('/Mantenedor/GetFamilia5', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia04Controller@GetFamilia']);
    Route::get('/Mantenedor/GetZona', ['middleware' => 'cors', 'uses' => 'ZonasController@GetZona']);
    Route::get('/Mantenedor/GetMedicamentos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetMedicamentos']);
    Route::get('/Mantenedor/GetInsumoEconomato', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetInsumoEconomato']);    
    Route::get('/Mantenedor/GetUsers', ['middleware' => 'cors', 'uses' => 'LoginController@GetUsers']);    
    Route::get('/Mantenedor/GetEstado', ['middleware' => 'cors', 'uses' => 'EstadosController@GetEstado']);    
    Route::get('/Mantenedor/GetStockMinMax', ['middleware' => 'cors', 'uses' => 'StockMinMaxController@GetStockMinMax']);    
    Route::get('/Mantenedor/GetStockMinMaxMed', ['middleware' => 'cors', 'uses' => 'StockMinMaxMedicamentosController@GetStockMinMaxMed']);
    Route::get('/Mantenedor/GetAllArticulos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetAllArticulos']);
    Route::get('/Mantenedor/GetSaldoInventario', ['middleware' => 'cors', 'uses' => 'SaldoInventariosController@GetSaldoInventario']);
    Route::get('/Mantenedor/GetTipoDocumentos', ['middleware' => 'cors', 'uses' => 'TipoDocumentosController@GetTipoDocumentos']);
    Route::get('/Mantenedor/GetUltimoNInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetUltimoNInterno']);
    Route::get('/Mantenedor/GetRecepcionAbiertas', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionAbiertas']);
    Route::get('/Mantenedor/GetUltimoNFolio', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetUltimoNFolio']);
    Route::get('/Mantenedor/GetRecepcionCerradas', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionCerradas']);
    
    //Posts 
    Route::post('/Mantenedor/PostProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PostProveedor']);
    Route::post('/Mantenedor/PostLaboratorio', ['middleware' => 'cors', 'uses' => 'SiabLaborsController@PostLaboratorio']);
    Route::post('/Mantenedor/PostAnulacion', ['middleware' => 'cors', 'uses' => 'MotivoAnulacionesController@PostAnulacion']);
    Route::post('/Mantenedor/PostAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PostAuthUsuario']);
    Route::post('/Mantenedor/PostServicios', ['middleware' => 'cors', 'uses' => 'ServiciosController@PostServicios']);
    Route::post('/Mantenedor/PostAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PostAuthUsuario']);
    Route::post('/Mantenedor/PostAuthEstado', ['middleware' => 'cors', 'uses' => 'AuthEstadosController@PostAuthEstado']);
    Route::post('/Mantenedor/PostLabUsuario', ['middleware' => 'cors', 'uses' => 'LabUsuariosController@PostLabUsuario']);
    Route::post('/Mantenedor/PostBodega', ['middleware' => 'cors', 'uses' => 'BodegasController@PostBodega']);
    Route::post('/Mantenedor/PostFamilia1', ['middleware' => 'cors', 'uses' => 'DescripcionFamiliaController@PostFamilia']);
    Route::post('/Mantenedor/PostFamilia2', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia01Controller@PostFamilia']);
    Route::post('/Mantenedor/PostFamilia3', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia02Controller@PostFamilia']);
    Route::post('/Mantenedor/PostFamilia4', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia03Controller@PostFamilia']);
    Route::post('/Mantenedor/PostFamilia5', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia04Controller@PostFamilia']);
    Route::post('/Mantenedor/PostZona', ['middleware' => 'cors', 'uses' => 'ZonasController@PostZona']);
    Route::post('/Mantenedor/PostMedicamentos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostMedicamentos']);
    Route::post('/Mantenedor/PostInsumoEconomato', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostInsumoEconomato']);
    Route::post('/Mantenedor/RegistrarUsuario', ['middleware' => 'cors', 'uses' => 'LoginController@RegistrarUsuario']);
    Route::post('/Mantenedor/PostCodMedicamentos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostCodMedicamentos']);
    Route::post('/Mantenedor/PostCodInsumoEconomato', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostCodInsumoEconomato']);
    Route::post('/Mantenedor/PostSaldoInventario', ['middleware' => 'cors', 'uses' => 'SaldoInventariosController@PostSaldoInventario']);
    Route::post('/Mantenedor/PostEstado', ['middleware' => 'cors', 'uses' => 'EstadosController@PostEstado']);
    Route::post('/Mantenedor/PostStockMinMax', ['middleware' => 'cors', 'uses' => 'StockMinMaxController@PostStockMinMax']);
    Route::post('/Mantenedor/PostStockMinMaxMed', ['middleware' => 'cors', 'uses' => 'StockMinMaxMedicamentosController@PostStockMinMaxMed']);    
    Route::post('/Mantenedor/PostValidarCodBarraMed', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostValidarCodBarraMed']);
    Route::post('/Mantenedor/PostTipoDocumentos', ['middleware' => 'cors', 'uses' => 'TipoDocumentosController@PostTipoDocumentos']);
    Route::post('/Mantenedor/PostArticuloDetalle', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticuloDetalle']);
    Route::post('/Mantenedor/PostArticuloDetalleCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticuloDetalleCodInterno']);

    //Post Como Get
    Route::post('/Mantenedor/GetListadoArticulosByCodInterno', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetListadoArticulosByCodInterno']);
    Route::post('/Mantenedor/GetListadoMedicamentosByCodInterno', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetListadoMedicamentosByCodInterno']);
    Route::post('/Mantenedor/GetArticulosIngresadosByCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetArticulosIngresadosByCodInterno']);
    Route::post('/Mantenedor/GetRecepcionIngresadaByCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionIngresadaByCodInterno']);

    //Post Como Put
    Route::post('/Mantenedor/PutProveedor', ['middleware' => 'cors', 'uses' => 'SiabProveedoresController@PutProveedor']);
    Route::post('/Mantenedor/PutLaboratorio', ['middleware' => 'cors', 'uses' => 'SiabLaborsController@PutLaboratorio']);
    Route::post('/Mantenedor/PutAnulacion', ['middleware' => 'cors', 'uses' => 'MotivoAnulacionesController@PutAnulacion']);
    Route::post('/Mantenedor/PutAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PutAnulacion']);
    Route::post('/Mantenedor/PutServicio', ['middleware' => 'cors', 'uses' => 'ServiciosController@PutServicio']);
    Route::post('/Mantenedor/PutAuthUsuario', ['middleware' => 'cors', 'uses' => 'AutorizadoretirosController@PutAuthUsuario']);
    Route::post('/Mantenedor/PutAuthEstado', ['middleware' => 'cors', 'uses' => 'AuthEstadosController@PutAuthEstado']);
    Route::post('/Mantenedor/PutLabUsuario', ['middleware' => 'cors', 'uses' => 'LabUsuariosController@PutLabUsuario']);
    Route::post('/Mantenedor/PutBodega', ['middleware' => 'cors', 'uses' => 'BodegasController@PutBodega']);
    Route::post('/Mantenedor/PutFamilia1', ['middleware' => 'cors', 'uses' => 'DescripcionFamiliaController@PutFamilia']);
    Route::post('/Mantenedor/PutFamilia2', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia01Controller@PutFamilia']);
    Route::post('/Mantenedor/PutFamilia3', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia02Controller@PutFamilia']);
    Route::post('/Mantenedor/PutFamilia4', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia03Controller@PutFamilia']);
    Route::post('/Mantenedor/PutFamilia5', ['middleware' => 'cors', 'uses' => 'DescripcionFamilia04Controller@PutFamilia']);
    Route::post('/Mantenedor/PutZona', ['middleware' => 'cors', 'uses' => 'ZonasController@PutZona']);
    Route::post('/Mantenedor/PutMedicamentos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PutMedicamentos']);
    Route::post('/Mantenedor/PutInsumoEconomato', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PutInsumoEconomato']);    
    Route::post('/Mantenedor/PutUsuario', ['middleware' => 'cors', 'uses' => 'LoginController@PutUsuario']);
    Route::post('/Mantenedor/PutEstado', ['middleware' => 'cors', 'uses' => 'EstadosController@PutEstado']);    
    Route::post('/Mantenedor/PutStockMinMax', ['middleware' => 'cors', 'uses' => 'StockMinMaxController@PutStockMinMax']);
    Route::post('/Mantenedor/PutDesactivarStockMinMax', ['middleware' => 'cors', 'uses' => 'StockMinMaxController@PutDesactivarStockMinMax']);
    Route::post('/Mantenedor/PutStockMinMaxMed', ['middleware' => 'cors', 'uses' => 'StockMinMaxMedicamentosController@PutStockMinMaxMed']);
    Route::post('/Mantenedor/PutDesactivarStockMinMaxMed', ['middleware' => 'cors', 'uses' => 'StockMinMaxMedicamentosController@PutDesactivarStockMinMaxMed']);
    Route::post('/Mantenedor/PutTipoDocumentos', ['middleware' => 'cors', 'uses' => 'TipoDocumentosController@PutTipoDocumentos']);
    Route::post('/Mantenedor/PostCerrarRecepcion', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostCerrarRecepcion']);
    Route::post('/Mantenedor/PutListadoArticulosRecepcion', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PutListadoArticulosRecepcion']);
    Route::post('/Mantenedor/PutRecepcionTotal', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PutRecepcionTotal']);

    //Post como Delete
    Route::post('/Mantenedor/DeleteArticuloDetalle', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DeleteArticuloDetalle']);

    //Post Documentos
    Route::post('/Mantenedor/PostDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PostDocumentoAuthUsuario']);
    Route::post('/Mantenedor/PutDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PutDocumentoAuthUsuario']);

    
});

//Generar PDF
Route::get('/Recepcion/RecepcionPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GenerarImpresion']);
