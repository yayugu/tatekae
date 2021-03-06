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

//Route::get('login', 'Auth\AuthController@showLoginForm');
//Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

Route::get('/social/redirect/twitter', ['as' => 'social.redirect', 'uses' => 'Auth\AuthController@getSocialRedirect']);
Route::get('/social/handle/twitter', ['as' => 'social.handle', 'uses' => 'Auth\AuthController@getSocialHandle']);

//Route::get('home', '');
Route::get('tatekae', 'TatekaeController@getMypage');
Route::get('tatekae/account/{account_id}', ['as' => 'tatekae.account.ledger', 'uses' => 'TatekaeController@getAccountLedger']);
Route::get('tatekae/{user_relationship_id}', ['as' => 'tatekae.user.ledger', 'uses' => 'TatekaeController@getUserLedger']);
Route::post('tatekae/new', 'TatekaeController@postNewAccount');
Route::post('tatekae/{account_id}/new', 'TatekaeController@postNewLedgerRecord');
Route::post('tatekae/{account_id}/{ledger_id}/edit', 'TatekaeController@postEditLedgerRecord');

Route::post('user_relationship/new', 'UserRelationshipController@postNew');
Route::post('user_relationship/reply', 'UserRelationshipController@postReply');

Route::get('user/profile', ['as' => 'profile', 'uses' => 'UserController@getProfile']);
Route::put('user/profile', ['as' => 'profile.update', 'uses' => 'UserController@updateProfile']);