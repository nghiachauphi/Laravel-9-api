<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/token', function () {
//    return csrf_token();
//});

//Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout']);
Route::post('/create/user', [App\Http\Controllers\UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
    Route::get('/user/all', function (Request $request) {
        return \App\Models\User::all();
    });
    Route::post('/change_password', [App\Http\Controllers\UserController::class, 'change_password']);
});
