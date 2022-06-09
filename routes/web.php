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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Web LOGIN
|--------------------------------------------------------------------------
|
|
*/
Route::get('/google_login', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('google_login');
Route::get('/google_login_callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

//Route::get('/user/{id}', [App\Http\Controllers\UserViewController::class, 'getImage'])->name('add_avatar');
//Route::post('/user/{id}', [App\Http\Controllers\UserViewController::class, 'postImage']);

//get server user
//Route::get('/user', [App\Http\Controllers\UserViewController::class, 'index'])->name('user');
//Route::post('/login', [App\Http\Controllers\UserViewController::class, 'postlogin'])->name('postlogin');

/*
|--------------------------------------------------------------------------
| Web POST
|--------------------------------------------------------------------------
|
|
*/
Route::post('/login', [App\Http\Controllers\UserViewController::class, 'login_local'])->name('login_local');

//get local
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [App\Http\Controllers\UserViewController::class, 'index_local'])->name('user');
    Route::get('/category', [App\Http\Controllers\CategoryViewController::class, 'index']);
    Route::get('/category/create', [App\Http\Controllers\CategoryViewController::class, 'create']);
});

