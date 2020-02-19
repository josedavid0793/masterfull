<?php

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
//Cargando clases
use App\Http\Middleware\ApiAuthmiddleware;
//Rutas de pruebas
Route::get('/', function () {
    return view('welcome');
});
Route::get('/pruebas/{nombre?}', function($nombre = null){
   $texto = '<h2>MIAH ES HERMOSA MAMI NO </h2>';
   $texto .= 'Nombre: ' .$nombre;
    return view('pruebas', array (
       'texto' => $texto
    ));
});

Route::get('/miah','PruebasController@index');
Route::get('/test-orm','PruebasController@Orm');

// Fin de rutas de pruebas
/*Metodos HTTP comunes
 * GET: Conseguir datos o recursos.
 * POST: Guardar datos o recursos o hacer logica es mas seguro los datos no se ven por la url.
 * PUT:  Actualizar recursos o datos.
 * DELETE: Eliminar datos o recursos.
 */

//Rutas del API como pruebas
/*
Route::get('/usuario/pruebas','UserController@pruebas');
Route::get('/usuario/categorias','CategoryController@pruebas');
Route::get('/usuario/posts','PostController@pruebas');
*/

//Rutas del controlador de Usuarios deben realizarcen desde un formulario HTML o un cliente RESTful
Route::post('/api/register','UserController@register');
Route::post('/api/login','UserController@login');
Route::put('/api/user/update','UserController@update');
Route::post('/api/user/upload','UserController@upload')->middleware(\ApiAuthmiddleware::class);
Route::get('/api/user/avatar/{filename}','UserController@getImage');
Route::get('/api/user/detail/{id}','UserController@detail');

//Rutas de l controlador de categorias rutas de tipo rousorces o automaticas

Route::resource('/api/category','CategoryController');

//Rutas del controlador de entradas
Route::resource('/api/post','PostController');
Route::post('/api/post/upload','PostController@upload')->middleware(\ApiAuthmiddleware::class);
Route::get('/api/post/image/{filename}','PostController@getImage');
Route::get('/api/post/category/{id}','PostController@getPostsByCategory');
Route::get('/api/post/user/{id}','PostController@getPostsByUser');