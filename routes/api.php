<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;

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

Route::group(['prefix' => 'v1'], function () {

    Route::get('/token', [TokenController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [RegisterController::class, 'store']);

    Route::get('/users/{user_id}', [UserController::class, 'show']);

    Route::get('/positions', [PositionController::class, 'index']);

});
