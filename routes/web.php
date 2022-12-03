<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', \App\Http\Controllers\DayController::class)
    ->name('days.index');

Route::get('day-1', \App\Http\Controllers\DayOneController::class)
    ->name('days.show.1');

Route::get('day-2', \App\Http\Controllers\DayTwoController::class)
    ->name('days.show.2');

Route::get('day-3', \App\Http\Controllers\DayThreeController::class)
    ->name('days.show.3');

Route::get('day-4', \App\Http\Controllers\DayFourController::class)
    ->name('days.show.4');

Route::get('day-5', \App\Http\Controllers\DayFiveController::class)
    ->name('days.show.5');

Route::get('day-6', \App\Http\Controllers\DaySixController::class)
    ->name('days.show.6');

Route::get('day-7', \App\Http\Controllers\DaySevenController::class)
    ->name('days.show.7');

Route::get('day-8', \App\Http\Controllers\DayEightController::class)
    ->name('days.show.8');

Route::get('day-9', \App\Http\Controllers\DayNineController::class)
    ->name('days.show.9');

Route::get('day-10', \App\Http\Controllers\DayTenController::class)
    ->name('days.show.10');

Route::get('day-11', \App\Http\Controllers\DayElevenController::class)
    ->name('days.show.11');

Route::get('day-12', \App\Http\Controllers\DayTwelveController::class)
    ->name('days.show.12');

Route::get('day-13', \App\Http\Controllers\DayThirteenController::class)
    ->name('days.show.13');

Route::get('day-14', \App\Http\Controllers\DayFourteenController::class)
    ->name('days.show.14');

Route::get('day-15', \App\Http\Controllers\DayFifteenController::class)
    ->name('days.show.15');

Route::get('day-16', \App\Http\Controllers\DaySixteenController::class)
    ->name('days.show.16');

Route::get('day-17', \App\Http\Controllers\DaySeventeenController::class)
    ->name('days.show.17');

Route::get('day-18', \App\Http\Controllers\DayEighteenController::class)
    ->name('days.show.18');

Route::get('day-19', \App\Http\Controllers\DayNineteenController::class)
    ->name('days.show.19');

Route::get('day-20', \App\Http\Controllers\DayTwentyController::class)
    ->name('days.show.20');

Route::get('day-21', \App\Http\Controllers\DayTwentyOneController::class)
    ->name('days.show.21');

Route::get('day-22', \App\Http\Controllers\DayTwentyTwoController::class)
    ->name('days.show.22');

Route::get('day-23', \App\Http\Controllers\DayTwentyThreeController::class)
    ->name('days.show.23');

Route::get('day-24', \App\Http\Controllers\DayTwentyFourController::class)
    ->name('days.show.24');

Route::get('day-25', \App\Http\Controllers\DayTwentyFiveController::class)
    ->name('days.show.25');
