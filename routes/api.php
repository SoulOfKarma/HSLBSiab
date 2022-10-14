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
Route::post('/auth/RefreshToken','AuthJWT@handle');

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

    Route::get('/Mantenedor/GetAllProductos', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetAllProductos']);        
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
    Route::get('/Mantenedor/GetRecepcionIngresadaOrdenCompra', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionIngresadaOrdenCompra']);
    Route::get('/Recepcion/GetRecepcionCerradaOC', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionCerradaOC']);
    Route::get('/Mantenedor/GetUltimoNInternoOC', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetUltimoNInterno']);
    Route::get('/Mantenedor/GetUltimoNFolioOC', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetUltimoNFolio']);
    Route::get('/Mantenedor/GetOCAbiertas', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetOCAbiertas']);
    Route::get('/Mantenedor/GetOCCerradas', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetOCCerradas']);
    Route::get('/Despachos/GetDetallesArticulosDisponibles', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDetallesArticulosDisponibles']);
    Route::get('/Despachos/GetUltimoNInternoDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@GetUltimoNInternoDespacho']);
    Route::get('/Despachos/GetUltimoNFolioDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@GetUltimoNFolioDespacho']);
    Route::get('/Despachos/GetDespachosAbiertos', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDespachosAbiertos']);
    Route::get('/Despachos/GetDespachosCerrados', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDespachosCerrados']);
    Route::get('/Recepcion/GetDetallesRecepcionesAnulados', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetDetallesRecepcionesAnulados']);
    Route::get('/Despachos/GetDetallesDespachosAnulados', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDetallesDespachosAnulados']);
    Route::get('/Mantenedor/GetTipoCompras', ['middleware' => 'cors', 'uses' => 'TipoComprasController@GetTipoCompras']);
    
    
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
    Route::post('/Mantenedor/PostArticuloGeneral', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostArticuloGeneral']);
    Route::post('/Mantenedor/RegistrarUsuario', ['middleware' => 'cors', 'uses' => 'LoginController@RegistrarUsuario']);
    Route::post('/Mantenedor/PostCodArticuloGeneral', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostCodArticuloGeneral']);
    Route::post('/Mantenedor/PostSaldoInventario', ['middleware' => 'cors', 'uses' => 'SaldoInventariosController@PostSaldoInventario']);
    Route::post('/Mantenedor/PostEstado', ['middleware' => 'cors', 'uses' => 'EstadosController@PostEstado']);
    Route::post('/Mantenedor/PostStockMinMax', ['middleware' => 'cors', 'uses' => 'StockMinMaxController@PostStockMinMax']);
    Route::post('/Mantenedor/PostStockMinMaxMed', ['middleware' => 'cors', 'uses' => 'StockMinMaxMedicamentosController@PostStockMinMaxMed']);    
    Route::post('/Mantenedor/PostValidarCodBarraMed', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostValidarCodBarraMed']);
    Route::post('/Mantenedor/PostTipoDocumentos', ['middleware' => 'cors', 'uses' => 'TipoDocumentosController@PostTipoDocumentos']);
    Route::post('/Mantenedor/PostArticuloDetalle', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticuloDetalle']);
    Route::post('/Mantenedor/PostArticuloDetalleCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticuloDetalleCodInterno']);
    Route::post('/Mantenedor/PostOrdenCompras', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@PostOrdenCompras']);
    Route::post('/Mantenedor/PostOrdenComprasDetalleByCodInterno', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@PostOrdenComprasDetalleByCodInterno']);
    Route::post('/Despachos/PostDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@PostDespacho']);
    Route::post('/Despachos/PostDetalleDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@PostDetalleDespacho']);
    Route::post('/Despachos/PostQuitarArticuloDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@PostQuitarArticuloDespacho']);
    Route::post('/Recepcion/PostArticulosDespacho', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticulosDespacho']);
    Route::post('/Recepcion/PostArticulosDespachoCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostArticulosDespachoCodInterno']);
    Route::post('/Mantenedor/PostImagen', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PostImagen']);
    Route::post('/Mantenedor/PostTipoCompras', ['middleware' => 'cors', 'uses' => 'TipoComprasController@PostTipoCompras']);

    //Post Como Get
    Route::post('/Mantenedor/GetListadoArticulosByCodInterno', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetListadoArticulosByCodInterno']);
    Route::post('/Mantenedor/GetListadoMedicamentosByCodInterno', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@GetListadoMedicamentosByCodInterno']);
    Route::post('/Mantenedor/GetArticulosIngresadosByCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetArticulosIngresadosByCodInterno']);
    Route::post('/Mantenedor/GetRecepcionIngresadaByCodInterno', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GetRecepcionIngresadaByCodInterno']);
    Route::post('/Mantenedor/GetOrdenCompraIngresadosByCodInterno', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetOrdenCompraIngresadosByCodInterno']);
    Route::post('/Mantenedor/GetOrdenCompraDetallesIngresadosByCodInterno', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GetOrdenCompraDetallesIngresadosByCodInterno']);
    Route::post('/Despachos/GetDespachos', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDespachos']);
    Route::post('/Despachos/GetDespachoDetalles', ['middleware' => 'cors', 'uses' => 'DespachosController@GetDespachoDetalles']);

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
    Route::post('/Mantenedor/PutArticuloGeneral', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PutArticuloGeneral']);
    Route::post('/Mantenedor/PutCodigoBarra', ['middleware' => 'cors', 'uses' => 'SiabArticulosController@PutCodigoBarra']);    
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
    Route::post('/Mantenedor/PostCerrarOrdenCompra', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@PostCerrarOrdenCompra']);
    Route::post('/Mantenedor/PutListadoOrdenCompra', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@PutListadoOrdenCompra']);
    Route::post('/Mantenedor/PutOrdenCompras', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@PutOrdenCompras']);
    Route::post('/Despachos/PutDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@PutDespacho']);
    Route::post('/Despachos/PutDespachoObservaciones', ['middleware' => 'cors', 'uses' => 'DespachosController@PutDespachoObservaciones']);
    Route::post('/Despachos/CerrarDespacho', ['middleware' => 'cors', 'uses' => 'DespachosController@CerrarDespacho']);
    Route::post('/Despachos/PostAnularArticulo', ['middleware' => 'cors', 'uses' => 'DespachosController@PostAnularArticulo']);
    Route::post('/Despachos/PostRAnularArticulo', ['middleware' => 'cors', 'uses' => 'DespachosController@PostRAnularArticulo']);
    Route::post('/Despachos/PostAnularTodo', ['middleware' => 'cors', 'uses' => 'DespachosController@PostAnularTodo']);
    Route::post('/Recepcion/PostAnularArticulo', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostAnularArticulo']);
    Route::post('/Recepcion/PostRAnularArticulo', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostRAnularArticulo']);
    Route::post('/Recepcion/PostAnularTodo', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostAnularTodo']);
    Route::post('/Recepcion/PostCerrarDespacho', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostCerrarDespacho']);
    Route::post('/Recepcion/PostCerrarRecepcionDespacho', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostCerrarRecepcionDespacho']);
    Route::post('/Mantenedor/PutTipoCompras', ['middleware' => 'cors', 'uses' => 'TipoComprasController@PutTipoCompras']);

    //Post como Delete
    Route::post('/Mantenedor/DeleteArticuloDetalle', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DeleteArticuloDetalle']);

    //Post Documentos
    Route::post('/Mantenedor/PostDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PostDocumentoAuthUsuario']);
    Route::post('/Mantenedor/PutDocumentoAuthUsuario', ['middleware' => 'cors', 'uses' => 'DocumentacionAuthUsuariosController@PutDocumentoAuthUsuario']);
    Route::post('/Recepcion/PostDocumentoRecepcionFactura', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostDocumentoRecepcionFactura']);
    Route::post('/Recepcion/DestroyDocumentoRecepcionFactura', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DestroyDocumentoRecepcionFactura']);
    Route::post('/Recepcion/PostDocumentoRecepcionFacturaRib', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostDocumentoRecepcionFacturaRib']);
    Route::post('/Recepcion/DestroyDocumentoRecepcionFacturaRib', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DestroyDocumentoRecepcionFactura']);
    Route::post('/Recepcion/PostDocumentoRecepcionFacturaCarta', ['middleware' => 'cors', 'uses' => 'RecepcionesController@PostDocumentoRecepcionFacturaCarta']);
    Route::post('/Recepcion/DestroyDocumentoRecepcionFacturaCarta', ['middleware' => 'cors', 'uses' => 'RecepcionesController@DestroyDocumentoRecepcionFactura']);

    //Get Reportes
    Route::get('/Reportes/GetSaldosReporte', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosReporte']);
    Route::get('/Reportes/GetSaldosValorizadoReporte', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoReporte']);
    Route::get('/Reportes/GetSaldoValorizadoP', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldoValorizadoP']);
    Route::get('/Reportes/GetSaldosValorizadoPMP', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoPMP']);
    Route::get('/Reportes/GetArticulosSaldoEstado', ['middleware' => 'cors', 'uses' => 'Reportes@GetArticulosSaldoEstado']);

    //Post Reportes
    Route::post('/Reportes/GetBincard', ['middleware' => 'cors', 'uses' => 'Reportes@GetBincard']);
    Route::post('/Reportes/GetBincardFVen', ['middleware' => 'cors', 'uses' => 'Reportes@GetBincardFVen']);
    Route::post('/Reportes/GetConsumoAnio', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsumoAnio']);
    Route::post('/Reportes/GetConsumoMes', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsumoMes']);    
    Route::post('/Reportes/GetConsumoMesServicio', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsumoMesServicio']);
    Route::post('/Reportes/GetFechaVencimiento', ['middleware' => 'cors', 'uses' => 'Reportes@GetFechaVencimiento']);
    Route::post('/Reportes/GetZGEN', ['middleware' => 'cors', 'uses' => 'Reportes@GetZGEN']);
    Route::post('/Reportes/GetZGENPriorizados', ['middleware' => 'cors', 'uses' => 'Reportes@GetZGENPriorizados']);
    Route::post('/Reportes/GetSaldoValorizadoPCod', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldoValorizadoPCod']);
    Route::post('/Reportes/GetSaldosValorizadoPMPCod', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoPMPCod']);
    Route::post('/Reportes/GetSaldoValorizadoPCodFecha', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldoValorizadoPCodFecha']);
    Route::post('/Reportes/GetSaldosValorizadoPMPCodFecha', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoPMPCodFecha']);
    Route::post('/Reportes/GetSaldoValorizadoPFarmacia', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldoValorizadoPFarmacia']);
    Route::post('/Reportes/GetSaldosValorizadoPMPFarmacia', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoPMPFarmacia']);
    Route::post('/Reportes/GetSaldoValorizadoPEconomato', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldoValorizadoPEconomato']);
    Route::post('/Reportes/GetSaldosValorizadoPMPEconomato', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosValorizadoPMPEconomato']);
    Route::post('/Reportes/GetArticulosSaldoEstadoC', ['middleware' => 'cors', 'uses' => 'Reportes@GetArticulosSaldoEstadoC']);
    Route::post('/Reportes/GetArticulosSaldoEstadoCovid', ['middleware' => 'cors', 'uses' => 'Reportes@GetArticulosSaldoEstadoCovid']);
    Route::post('/Reportes/GetArticulosSaldoEstadoCF', ['middleware' => 'cors', 'uses' => 'Reportes@GetArticulosSaldoEstadoCF']);
    Route::post('/Reportes/GetDespachoxServicio', ['middleware' => 'cors', 'uses' => 'Reportes@GetDespachoxServicio']);
    Route::post('/Reportes/GetDespachoxServicioI', ['middleware' => 'cors', 'uses' => 'Reportes@GetDespachoxServicioI']);
    Route::post('/Reportes/GetConsolidadoDespacho', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsolidadoDespacho']);
    Route::post('/Reportes/GetConsolidadoDespachoServicio', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsolidadoDespachoServicio']);
    Route::post('/Reportes/GetConsolidadoDespachoServicioCovid', ['middleware' => 'cors', 'uses' => 'Reportes@GetConsolidadoDespachoServicioCovid']);
    Route::post('/Reportes/GetSaldosRecepcion', ['middleware' => 'cors', 'uses' => 'Reportes@GetSaldosRecepcion']);
});

//Generar PDF
Route::get('/Recepcion/RecepcionPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'RecepcionesController@GenerarImpresion']);
Route::get('/Despacho/DespachoPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'DespachosController@GenerarImpresion']);
Route::get('/OrdenCompra/OrdenCompraPDF/{NUMINT}', ['middleware' => 'cors', 'uses' => 'OrdenComprasController@GenerarImpresion']);
Route::post('/Firma/PostUsuarioRecepcionFirma', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@PostUsuarioRecepcionFirma']);
Route::post('/Firma/FirmaDigitalArray', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@FirmaDigitalArray']);
Route::post('/Firma/PostUsuarioDespachosFirma', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@PostUsuarioDespachosFirma']);
Route::post('/Firma/FirmaDigitalDespachoArray', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@FirmaDigitalDespachoArray']);

//FPDF Prueba
Route::post('/Firma/process', ['middleware' => 'cors', 'uses' => 'FirmasDigitales@process']);

//Get para Verificacion
Route::get('/Despachos/GetDespachosCerradosV', 'DespachosController@GetDespachosCerrados');
Route::get('/Recepcion/GetRecepcionCerradasV', 'RecepcionesController@GetRecepcionCerradas');

