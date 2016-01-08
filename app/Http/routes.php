<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
	return view('index');
});

Route::get('home', 'HomeController@show');

Route::get('cursos', 'CourseController@all');
Route::get('cursos/{slug}', 'CourseController@show');
Route::get('cursos/{course}/{lesson}', 'LessonController@show');

Route::post('cursos/{course}/{lesson}/avaliar', [
		'middleware' => 'auth',
		'uses' => 'LessonController@rate'
]);

Route::post('cursos/{course}/{lesson}/perguntar', [
		'middleware' => 'auth',
		'uses' => 'LessonController@ask'
]);

Route::post('perguntas/{id}/responder', [
		'middleware' => 'auth',
		'uses' => 'LessonController@answer'
]);

Route::post('cursos/{course}/{lesson}/nota', [
	'middleware' => 'auth',
	'uses' => 'LessonController@note'
]);

Route::get('perfil', [
	'middleware' => 'auth',
	'uses' => 'ProfileController@view'
]);

Route::post('perfil', [
	'middleware' => 'auth',
	'uses' => 'ProfileController@update'
]);

Route::get('perfil/editar', [
	'middleware' => 'auth',
	'uses' => 'ProfileController@edit'
]);

Route::get('perfil/textomaior', [
	'middleware' => 'auth',
	'uses' => 'ProfileController@increaseSize'
]);

Route::get('perfil/textomenor', [
	'middleware' => 'auth',
	'uses' => 'ProfileController@decreaseSize'
]);

// Authentication routes...
Route::get('entrar', 'Auth\AuthController@getLogin');
Route::post('entrar', 'Auth\AuthController@postLogin');
Route::get('sair', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('registo', 'Auth\AuthController@getRegister');
Route::post('registo', 'Auth\AuthController@postRegister');