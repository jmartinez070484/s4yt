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

//get
Route::get('/','Organization@profile') -> name('organization');
Route::get('/schedule','Organization@schedule') -> name('organization.schedule');
Route::get('/question','Organization@question') -> name('organization.question');
Route::get('/answers','Organization@answers') -> name('organization.answers');
Route::get('/answers/{answer}','Organization@answersDetails') -> where('answer','[0-9]+') -> name('organization.answers.details');

//post
Route::post('/','Organization@profile');
Route::post('/question','Organization@question');
Route::post('/answers/{answer}','Organization@answersDetails') -> where('answer','[0-9]+');

?>