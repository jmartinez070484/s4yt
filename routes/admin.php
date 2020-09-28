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
Route::get('/','Admin@index') -> name('admin');

//students
Route::get('/students','Admin@students') -> name('admin.students');
Route::get('/students/{user}','Admin@studentProfile') -> where('user','[0-9]+') -> name('admin.students.profile');
Route::get('/students/new','Admin@studentCreate') -> name('admin.students.new');
Route::get('/students/{user}/tickets','Admin@studentTickets') -> where('user','[0-9]+') -> name('admin.students.tickets');
Route::post('/students/{user}','Admin@studentProfile') -> where('user','[0-9]+');
Route::post('/students/new','Admin@studentCreate');
Route::post('/students/{user}/tickets','Admin@studentTickets');
Route::post('/students/{user}/email','Admin@userEmail');

//business
Route::get('/business','Admin@business') -> name('admin.business');
Route::get('/business/{user}','Admin@businessProfile') -> where('user','[0-9]+') -> name('admin.business.profile');
Route::get('/business/{user}/question','Admin@businessQuestion') -> where('user','[0-9]+') -> name('admin.business.question');
Route::get('/business/{user}/schedule','Admin@businessSchedule') -> where('user','[0-9]+') -> name('admin.business.schedule');
Route::get('/business/{user}/schedule/new','Admin@businessScheduleNew') -> where('user','[0-9]+') -> name('admin.business.schedule.new');
Route::get('/business/{user}/scholarships','Admin@businessScholarships') -> where('user','[0-9]+') -> name('admin.business.scholarships');
Route::get('/business/{user}/schedule/{schedule}','Admin@businessScheduleItem') -> where('user','[0-9]+') -> where('schedule','[0-9]+') -> name('admin.business.schedule.item');
Route::get('/business/new','Admin@businessCreate') -> name('admin.business.new');
Route::post('/business/new','Admin@businessCreate');
Route::post('/business/{user}','Admin@businessProfile') -> where('user','[0-9]+');
Route::post('/business/{user}/question','Admin@businessQuestion') -> where('user','[0-9]+');
//Route::post('/business/{user}/schedule/new','Admin@businessScheduleNew') -> where('user','[0-9]+') -> name('admin.business.schedule.new');
//Route::post('/business/{user}/schedule/{schedule}','Admin@businessScheduleItem') -> where('user','[0-9]+') -> where('schedule','[0-9]+');
Route::post('/business/{user}/email','Admin@userEmail');


//items
Route::get('/items','Admin@items') -> name('admin.items');
Route::get('/items/{item}','Admin@editItem') -> where('item','[0-9]+') -> name('admin.items.details');
Route::get('/items/new','Admin@newItem') -> name('admin.items.new');
Route::post('/items/new','Admin@newItem');
Route::post('/items/{item}','Admin@editItem') -> where('item','[0-9]+');
Route::post('/items/{item}/winner','Admin@winnerItem') -> where('item','[0-9]+');

//delete
Route::delete('/delete/user/{user}','Admin@deleteUser') -> name('admin.delete.user');
Route::delete('/students/{user}/tickets/{ticket}','Admin@deleteTicket') -> name('admin.delete.ticket');
Route::delete('/delete/items/{item}','Admin@deleteItem') -> name('admin.delete.item');
Route::delete('/business/{user}/schedule/{schedule}','Admin@businessScheduleItem') -> where('user','[0-9]+') -> where('schedule','[0-9]+');

//partials
Route::post('/partials/{element}','Admin@partials') -> name('admin.partials');

?>