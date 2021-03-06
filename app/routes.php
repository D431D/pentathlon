<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('login', array('before' => 'guest', function(){
	return View::make('login/login');
}));


Route::get('/', array('before' => 'auth', function(){
	return View::make('layaouts/base');
}));
Route::get('asd', function(){
	$elemento = Elemento::find(2)->arrestos;
	//$elemento = Arresto::find(2)->elemento;
	return Response::json($elemento);
});

// Route::controller('editar', 'EditaReclutaController');

Route::get('recluta/alta','AltaReclutaController@get_nuevo');
Route::post('recluta/curp','AltaReclutaController@errorCurp');
Route::post('recluta/alta','AltaReclutaController@post_nuevo');

Route::get('recluta/editar','EditaReclutaController@editar');
Route::post('recluta/buscar','EditaReclutaController@buscar');
Route::post('recluta/update','EditaReclutaController@update');
Route::get('recluta/lugares','EditaReclutaController@lugares');
Route::post('recluta/extendidos','EditaReclutaController@extendidos');
Route::post('recluta/cargos','EditaReclutaController@cargos');

/*Route::get('cargos/editar','AsignaCargosController@editar');
Route::post('cargos/buscar','AsignaCargosController@buscar');
Route::post('cargos/update','AsignaCargosController@update');*/

Route::controller('cargos', 'AsignaCargosController');
Route::controller('ascensos', 'AsignaAscensosController');
Route::controller('jura', 'JuraBanderaController');
Route::controller('reportes', 'ReportesController');
Route::controller('concursos', 'ConcursosController');


Route::post('buscar','BuscarController@buscar');
Route::controller('pagos', 'MembresiasController');
Route::controller('companias','CompaniasController');
Route::controller('asistencias','AsistenciasController');
Route::controller('condecoraciones','CondecoracionesController');

Route::controller('eventos','EventosController');
Route::controller('examenes','ExamenesController');
Route::controller('arrestos','ArrestosController');
Route::controller('armas','armasController');
Route::controller('cuerpos','cuerposController');
Route::controller('historial','HistorialController');
Route::get('history',array('before' => 'auth', function(){
	return View::make('historial/history');
}));
Route::post('login', 'UserLogin@user');
Route::get('logout', 'UserLogin@logOut');

Route::get('forgot','RecoverPassword@getForgotpassword');
Route::post('forgot','RecoverPassword@postForgotpassword');
Route::get('recover/{token?}','RecoverPassword@getRecover');
Route::post('recover','RecoverPassword@postRecover');
Route::controller('settings','settingsController');

