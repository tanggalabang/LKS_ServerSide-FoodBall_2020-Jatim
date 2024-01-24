<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ActorController;
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


// Route::post('users/auth', [AuthController::class, 'login']);

// Route::middleware(TokenValidation::class)->group(function (){
//     Route::resource('users', ActorController::class);
// });
// // Route::resource('players', PlayerController::class);

// Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
// Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
// /**
//  * route "/user"
//  * @method "GET"
//  */
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');



use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\PlayerController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
Route::post('/users/auth', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

// User resource routes
Route::middleware('auth:api')->resource('/users', UserController::class);

// Player resource routes
Route::resource('/players', PlayerController::class)->only([
    'index'
]);

Route::resource('/players', PlayerController::class)->only([
    'store', 'show', 'update', 'destroy'
])->middleware('auth:api');








