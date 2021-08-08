<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\UserController;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('profile/edit', [UserController::class, 'editProfile'])
    ->middleware('auth')
    ->name('edit.profile');
Route::put('profile/update', [UserController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('update.profile');


Route::group(['prefix' => 'admin'], function()
{
    Route::get('/', [AdminController::class, 'index'])
        ->middleware('auth.admin')
        ->name('admin.index');
    Route::get('login', [AdminController::class, 'login'])
        ->name('admin.login');
});


