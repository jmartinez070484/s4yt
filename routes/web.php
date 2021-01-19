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

Route::get('/','Controller@index') -> name('event');

//get
/*Route::get('/login','Controller@auth') -> name('login');
Route::get('/forgot-password','Controller@auth') -> name('password.forgot');
Route::get('/reset-password','Controller@reset') -> name('password.reset');
Route::get('/logout','Controller@logout') -> name('logout');

//post
Route::post('/login','Controller@authenticate');
Route::post('/forgot-password','Controller@forgot');
Route::post('/reset-password','Controller@reset');

//event routes
Route::get('/','Event@index') -> name('event');
Route::get('/enterprise','Event@enterprise') -> name('enterprise');
Route::get('/enterprise/{business}','Event@business') -> name('business');
Route::get('/enterprise/{business}/question','Event@question') -> name('question');
Route::get('/chatroom','Event@chatroom') -> name('chatroom');
Route::get('/raffle','Event@items') -> name('items');
Route::get('/raffle/winners','Event@itemWinners') -> name('items.winners');
Route::get('/account','Event@account') -> name('account');
Route::get('/oops','Event@oops') -> name('oops');

//event winners
Route::get('/winners','Event@winners') -> name('winners');

//event post routes
Route::post('/raffle/{item}','Event@items');
Route::post('/enterprise/{business}','Event@business');
Route::post('/enterprise/{business}/question','Event@question');
Route::post('/elements/','Event@elements') -> name('elements');

//event delete routes
Route::delete('/enterprise/{business}/question','Event@question');*/