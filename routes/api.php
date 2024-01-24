<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\PlayerController;
use App\Http\Middleware\TokenValidation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('users/auth', [AuthController::class, 'login']);

Route::middleware(TokenValidation::class)->group(function (){
    Route::resource('users', ActorController::class);
});
Route::resource('players', PlayerController::class);
