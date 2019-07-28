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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/fax/post','Postal@CheckPostal');

Route::get('/fax/general/get','FaxController@getGeneral');
Route::post('/fax/general/save','FaxController@saveGeneral');
Route::get('/fax/client/get','FaxController@getClient');
Route::post('/fax/client/save','FaxController@saveClient');
Route::post('/fax/publish','FaxController@publish');
Route::post('/fax/uploadSign','FaxController@uploadSign');