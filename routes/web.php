<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
/*Documentos */
/* WEB */
Route::get('/documentos', ['as' => 'documentos', 'uses' => 'App\Http\Controllers\DocumentsController@index']);
Route::get('/documentos/edit/{id?}', ['as' => 'documentos.edit', 'uses' => 'App\Http\Controllers\DocumentsController@edit']);

/* API */
Route::get('/documentos/get/{id?}', ['as' => 'documentos.get', 'uses' => 'App\Http\Controllers\DocumentsController@get']);
Route::post('/documentos', ['as' => 'documentos.save', 'uses' => 'App\Http\Controllers\DocumentsController@save']);
Route::put('/documentos', ['as' => 'documentos.update', 'uses' => 'App\Http\Controllers\DocumentsController@update']);
Route::delete('/documentos/{id?}', ['as' => 'documentos.delete', 'uses' => 'App\Http\Controllers\DocumentsController@delete']);
Route::get('/documentos/list/{user_id?}', ['as' => 'documentos.list', 'uses' => 'App\Http\Controllers\DocumentsController@list']);
//Route::get('/documentos/new', [App\Http\Controllers\DocumentsController::class, 'view']);
//Route::post('/documentos/save', [App\Http\Controllers\DocumentsController::class, 'save']);


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
