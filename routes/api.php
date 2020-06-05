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


/**
 * Apis Publicas
 */
Route::get('tags/{tag}', 'Comun\ApiController@obtenerTagsPorNombre')->name('api_tags_nombre'); // Obtener los tags por nombre
Route::get('tags', 'Comun\ApiController@obtenerTags')->name('api_tags'); // Obtener todos los tags
Route::get('getPublished', 'NoticiasController@noticiasPublicadas')->name('noticias_publicadas'); //obtener todas las noticias publicadas
Route::get('/comments/{noticia}', 'NoticiasController@commentsAction')->name('comentarios'); //Obtener todos los comentarios de una noticia

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
