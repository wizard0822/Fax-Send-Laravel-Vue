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

//Remove constant from vendor/setasign/fpdf/fpdf.php

// Route::get('/', 'FaxController@index');
// Route::post('/', 'FaxController@store');
// Route::get('/upload','FaxController@upload' );
// Route::post('/post','Postal@CheckPostal');
// Route::post('/upload', 'FaxController@signature');
// Route::get('/thanks','FaxController@thanks');
// Route::get('/polling','FaxController@polling');
// Route::post('/image-process','FaxController@processImage');

// used for 'postbode.nu' for updating status
Route::post('/webhook/6701b6ef8854ca3d2888/315e64e81f48','LetterController@webhook');

// Route::get('/test', 'FaxController@testFunc');

Route::group(['prefix' => 'fax'], function () {
	Route::get('/{vue?}', function () {
	    return view('main');
	})->where('vue', '[\/\w\.-]*')->name('fax');
});