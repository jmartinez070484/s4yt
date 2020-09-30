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
Route::get('/schedule/new','Organization@scheduleNew') -> name('organization.schedule.new');
Route::get('/schedule/{schedule}','Organization@scheduleEdit') -> where('schedule','[0-9]+') -> name('organization.schedule.item');
Route::get('/question','Organization@question') -> name('organization.question');
Route::get('/answers','Organization@answers') -> name('organization.answers');
Route::get('/answers/{answer}','Organization@answersDetails') -> where('answer','[0-9]+') -> name('organization.answers.details');
Route::get('/scholarships','Organization@scholarships') -> name('organization.scholarships');
Route::get('/map','Organization@enterprise') -> name('organization.enterprise');
Route::get('/self','Organization@self') -> name('organization.self');
Route::get('/self/question','Organization@selfQuestion') -> name('organization.self.question');

//post
Route::post('/','Organization@profile');
Route::post('/question','Organization@question');
Route::post('/answers/{answer}','Organization@answersDetails') -> where('answer','[0-9]+');
Route::post('/schedule/new','Organization@scheduleNew') -> name('organization.schedule.new');
Route::post('/answers/{answer}','Organization@answersDetails') -> where('answer','[0-9]+');
Route::post('/answers/{answer}/winner','Organization@answersWinner') -> where('answer','[0-9]+');

//delete
Route::delete('/schedule/{schedule}','Organization@scheduleEdit') -> where('schedule','[0-9]+');


?>