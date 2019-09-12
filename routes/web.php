<?php
use App\Cliente;
use App\Prestamo;
use App\Cuota;
use App\Abono;
use App\Exports\PrestamosExport;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();#no muestra las páginas si no has logeado
Route::get('/dashboard', 'DashboardController@index');
Route::resource('prestamos','PrestamoController');
Route::resource('clientes','ClienteController');
Route::resource('cuotas','CuotaController');
Route::resource('abonos','AbonoController'); 

Route::post('Cliente','ClienteController@store')->name('clientes.store'); 
Route::post('clientes/{id}','ClienteController@update')->name('cliente.update');

Route::get('prestamos/{id}/create', 'PrestamoController@create');#crea la ruta para para mostrar la página con el formulario de crear nuevo préstamo
Route::post('Prestamo','PrestamoController@store')->name('prestamo.store');#routing para hacer uso del método POST y enviar datos al controlador

Route::get('/pagos', 'PrestamoController@pagos')->name('prestamo.pagos');
Route::get('/utilidades', 'PrestamoController@utilidades')->name('prestamo.utilidades');

Route::get('Prestamo', 'PrestamoController@utilidades')->name('prestamo.utilidades');
Route::post('prestamos/{id}','PrestamoController@update')->name('prestamo.update');

#

Route::get('cuotas/{id}/create', 'CuotaController@create');
Route::post('Cuota','CuotaController@store')->name('cuota.store');
Route::get('cuotas/{id}/edit/{idP?}','CuotaController@edit');
Route::post('cuotas/{id}','CuotaController@update')->name('cuota.update');


Route::post('abonos','AbonoController@store')->name('abono.store');
Route::get('abonos/{id}/edit/{idP?}','AbonoController@edit');
Route::post('abonos/{id}','AbonoController@update')->name('abono.update');
Route::get('abonos/{id}/create', 'AbonoController@create');



#search bar clientes

Route::get ( 'dashboard', function () {
    return view ( 'dashboard' );
} );

/*********************************************************************************************/

Route::post ( '/buscarprestamo', function () {

    $q = Input::get ( 'q' );
    if($q != ""){
        $prestamoCliente = Prestamo::where('monto', 'LIKE' .' '.$q)
        ->orWhere('idCliente','LIKE',''.$q)->get();
 
        return view('prestamos.buscarprestamo', compact(['prestamoCliente']))->withDetails ( $prestamoCliente )->withQuery ( $q );
    }else
        return view ( 'prestamos.buscarprestamo' )->withMessage ( 'No se ha encontrado nada !' );
    } );
Auth::routes();



#limpia cache
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return 'ROUTE CLEARED'; //Return anything
});
Route::get('/cache-clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    //system('composer dump-autoload');
    return 'CACHE CLEARED'; //Return anything
});

