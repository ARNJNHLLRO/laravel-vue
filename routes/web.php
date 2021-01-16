<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarEventController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calendar', [CalendarEventController::class, 'index']);

Route::get('/get-events',[CalendarEventController:: class, 'getCalendarEvents']);

Route::post('/add-events', [CalendarEventController::class, 'createEvents']);