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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//login gg
Route::get('/google_login', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('google_login');
Route::get('/google_login_callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

//thong tin user
Route::get('/user', [App\Http\Controllers\UserViewController::class, 'index'])->name('user');
Route::get('/user/{id}', [App\Http\Controllers\UserViewController::class, 'getImage'])->name('add_avatar');
Route::post('/user/{id}', [App\Http\Controllers\UserViewController::class, 'postImage']);
