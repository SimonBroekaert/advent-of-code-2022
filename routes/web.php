<?php

use App\Http\Controllers\DayController;
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

Route::get('day-1', [DayController::class, 'one'])
    ->name('day-1');

Route::get('day-2', [DayController::class, 'two'])
    ->name('day-2');
