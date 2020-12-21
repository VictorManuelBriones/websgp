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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/proyecto', 'ProyectoController')->middleware('auth');
Route::resource('/proyectot', 'TipoProyectoController')->middleware('auth');
Route::resource('/proyectos', 'ServicioController')->middleware('auth');
Route::resource('/dashboard/user', 'UserController')->middleware('auth');

