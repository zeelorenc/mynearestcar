<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\AdminProfileController;
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

Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function() {
    Route::put('/', [UserController::class, 'update'])
        ->name('profile.update');
    Route::get('edit', [UserController::class, 'edit'])
        ->name('profile.edit');
});

Route::get('admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'auth.admin']], function() {
    Route::get('/', [AdminController::class, 'index'])
        ->name('admin.index');

    // admin user profile editing
    Route::group(['prefix' => 'profile/{user}'], function() {
        Route::get('/', [AdminProfileController::class, 'index'])
            ->name('admin.profile');
        Route::get('edit', [AdminProfileController::class, 'edit'])
            ->name('admin.profile.edit');
        Route::put('update', [AdminProfileController::class, 'update'])
            ->name('admin.profile.update');
    });
});


/* Those are just template links. They can be changed if you are develop those feature. */
Route::get('admin/register', function () {
    return view('admin.auth.register');
})->name('admin.register');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'auth.admin']], function() {
    Route::get('/vehicle/list', function () {
        return view('admin.vehicle.list');
    })->name('admin.vehicle.list');

    Route::get('/vehicle/add', function () {
        return view('admin.vehicle.add');
    })->name('admin.vehicle.add');

    Route::get('/parking/list', function () {
        return view('admin.parking.list');
    })->name('admin.parking.list');

    Route::get('/parking/add', function () {
        return view('admin.parking.add');
    })->name('admin.parking.add');

    Route::get('/order/search', function () {
        return view('admin.order.search');
    })->name('admin.order.search');

    Route::get('/user/search', function () {
        return view('admin.user.search');
    })->name('admin.user.search');
});
