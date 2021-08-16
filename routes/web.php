<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\Admin\ProfileController;
use \App\Http\Controllers\Admin\CarparkController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\Admin\VehicleController;


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

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/', function () {
    return view('index');
})->name('index');


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
        Route::get('/', [ProfileController::class, 'index'])
            ->name('admin.profile.index');
        Route::get('edit', [ProfileController::class, 'edit'])
            ->name('admin.profile.edit');
        Route::put('update', [ProfileController::class, 'update'])
            ->name('admin.profile.update');
    });

    // admin carpark management
    Route::group(['prefix' => 'carpark', 'middleware' => ['auth', 'auth.admin']], function() {
        Route::get('/', [CarparkController::class, 'index'])
            ->name('admin.carpark.index');
        Route::get('create', [CarparkController::class, 'create'])
            ->name('admin.carpark.create');
        Route::post('store', [CarparkController::class, 'store'])
            ->name('admin.carpark.store');
        Route::get('{carpark}/edit', [CarparkController::class, 'edit'])
            ->name('admin.carpark.edit');
    });

    // admin vehicle management
    Route::group(['prefix' => 'vehicle', 'middleware' => ['auth', 'auth.admin']], function() {
        Route::get('/', [VehicleController::class, 'index'])
            ->name('admin.vehicle.index');
        Route::get('create', [VehicleController::class, 'create'])
            ->name('admin.vehicle.create');
        Route::post('store', [VehicleController::class, 'store'])
            ->name('admin.vehicle.store');
        Route::get('{vehicle}/edit', [VehicleController::class, 'edit'])
            ->name('admin.vehicle.edit');
    });

});





/* Those are just template links. They can be changed if you are develop those feature. */
Route::get('contactus', function () {
    return view('contactus');
})->name('contactus');

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

    Route::get('/order/search', function () {
        return view('admin.order.search');
    })->name('admin.order.search');

    Route::get('/user/search', function () {
        return view('admin.user.search');
    })->name('admin.user.search');
});
