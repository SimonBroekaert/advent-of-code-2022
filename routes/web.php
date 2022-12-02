<?php

use App\Http\Controllers\DayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DayOneController;
use App\Http\Controllers\DayTwoController;

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

Route::get('/', DayController::class)
    ->name('days.index');

Route::get('day-1', DayOneController::class)
    ->name('days.show.1');

Route::get('day-2', DayTwoController::class)
    ->name('days.show.2');
