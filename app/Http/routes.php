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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

//Route::get('home', '');
Route::get('tatekae', 'TatekaeController@getMypage');
Route::get('tatekae/{account_id}', 'TatekaeController@getLedger');
Route::post('tatekae/new', 'TatekaeController@postNewAccount');
Route::post('tatekae/{account_id}/new', 'TatekaeController@postNewLedgerRecord');
Route::post('tatekae/{account_id}/{ledger_id}/edit', 'TatekaeController@postEditLedgerRecord');