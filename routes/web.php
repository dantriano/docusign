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

/*Documentos */
/* WEB */
Route::get('/dashboard', ['as' => 'requests', 'uses' => 'App\Http\Controllers\RequestsController@index']);

Route::get('/documentos', ['as' => 'documentos', 'uses' => 'App\Http\Controllers\DocumentsController@index']);
Route::get('/documentos/edit/{id?}', ['as' => 'documentos.edit', 'uses' => 'App\Http\Controllers\DocumentsController@edit']);
Route::get('/documentos/manager/{id}', ['as' => 'documentos.manager', 'uses' => 'App\Http\Controllers\DocumentsController@manager']);

Route::get('/peticiones/firma/view/{id}', ['as' => 'requests.sign', 'uses' => 'App\Http\Controllers\RequestsController@viewSign']);

Route::get('/pdf', ['as' => 'test', 'uses' => 'App\Http\Controllers\PdfController@index']);
Route::post('/PDFfromB64', ['as' => 'postPDFfromB64', 'uses' => 'App\Http\Controllers\PdfController@savePDFfromB64']);


/* API */
Route::get('/documentos/get/{id?}', ['as' => 'documentos.get', 'uses' => 'App\Http\Controllers\DocumentsController@get']);
Route::post('/documentos', ['as' => 'documentos.save', 'uses' => 'App\Http\Controllers\DocumentsController@save']);
Route::put('/documentos', ['as' => 'documentos.update', 'uses' => 'App\Http\Controllers\DocumentsController@save']);
Route::delete('/documentos/{id?}', ['as' => 'documentos.delete', 'uses' => 'App\Http\Controllers\DocumentsController@delete']);
Route::get('/documentos/list/{user_id?}', ['as' => 'documentos.list', 'uses' => 'App\Http\Controllers\DocumentsController@list']);
//Route::get('/documentos/new', [App\Http\Controllers\DocumentsController::class, 'view']);
//Route::post('/documentos/save', [App\Http\Controllers\DocumentsController::class, 'save']);
Route::get('/requests/document/{id}', ['as' => 'requests.byDocument', 'uses' => 'App\Http\Controllers\RequestsController@byDocument']);
Route::get('/requests/user/{id}', ['as' => 'requests.byDocument', 'uses' => 'App\Http\Controllers\RequestsController@byUser']);
Route::post('/requests', ['as' => 'requests.save', 'uses' => 'App\Http\Controllers\RequestsController@save']);
Route::delete('/requests/{id?}', ['as' => 'requests.delete', 'uses' => 'App\Http\Controllers\RequestsController@delete']);
Route::put('/requests/{id?}', ['as' => 'requests.put', 'uses' => 'App\Http\Controllers\RequestsController@update']);
Route::get('/requests/{id?}/pdf', ['as' => 'getRequestPDF', 'uses' => 'App\Http\Controllers\RequestsController@getRequestPDFb64']);


Route::get('/users', ['as' => 'users.get', 'uses' => 'App\Http\Controllers\UsersController@list']);



Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
