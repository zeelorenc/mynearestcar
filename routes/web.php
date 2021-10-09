<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\VehicleController;
use \App\Http\Controllers\OrderController;
use \App\Http\Controllers\OrderExportController;
use \App\Http\Controllers\RentController;
use \App\Http\Controllers\FavouritesController;

use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\Admin\ProfileController;
use \App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use \App\Http\Controllers\Admin\CarparkController as AdminCarparkController;
use \App\Http\Controllers\Admin\OrderController as AdminOrderController;
use \App\Http\Controllers\Admin\UserController as AdminUserController;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/rent', [RentController::class, 'index'])->name('rent.index');


Route::group(['prefix' => 'favourites', 'middleware' => 'auth'], function() {
    Route::get('/', [FavouritesController::class, 'index'])->name('favourites.index');
});

Route::group(['prefix' => 'profile/{user}', 'middleware' => 'auth'], function() {
    Route::get('/', [UserController::class, 'index'])
        ->name('profile.index');
    Route::put('/', [UserController::class, 'update'])
        ->name('profile.update');
//    Route::get('edit', [UserController::class, 'edit'])
//        ->name('profile.index');
    Route::put('password', [UserController::class, 'password'])
        ->name('profile.password');
});

Route::group(['prefix' => 'order', 'middleware' => 'auth'], function() {
    Route::get('history', [OrderController::class, 'history'])
        ->name('order.history');
    Route::get('export', [OrderExportController::class, 'export'])
        ->name('order.export');
    Route::get('current', [OrderController::class, 'current'])
        ->name('order.current');
    Route::get('{order}', [OrderController::class, 'show'])
        ->name('order.show');
    Route::get('{order}/return', [OrderController::class, 'return'])
        ->name('order.return');
});

/**
 *
 *      Admin Routes
 *
 */
Route::get('admin/login', [AdminController::class, 'login'])
    ->name('admin.login');

Route::get('admin/register', [AdminController::class, 'register'])
    ->name('admin.register');

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
        Route::put('password', [ProfileController::class, 'password'])
            ->name('admin.profile.password');
    });

    // admin carpark management
    Route::group(['prefix' => 'carpark', 'middleware' => ['auth', 'auth.admin']], function() {
        Route::get('/', [AdminCarparkController::class, 'index'])
            ->name('admin.carpark.index');
        Route::get('create', [AdminCarparkController::class, 'create'])
            ->name('admin.carpark.create');
        Route::post('store', [AdminCarparkController::class, 'store'])
            ->name('admin.carpark.store');
        Route::get('{carpark}/edit', [AdminCarparkController::class, 'edit'])
            ->name('admin.carpark.edit');
        Route::delete('{carpark}/destroy', [AdminCarparkController::class, 'destroy'])
            ->name('admin.carpark.destroy');
        Route::put('{carpark}/update', [AdminCarparkController::class, 'update'])
            ->name('admin.carpark.update');
    });

    // admin vehicle management
    Route::group(['prefix' => 'vehicle', 'middleware' => ['auth', 'auth.admin']], function() {
        Route::get('/', [AdminVehicleController::class, 'index'])
            ->name('admin.vehicle.index');
        Route::get('create', [AdminVehicleController::class, 'create'])
            ->name('admin.vehicle.create');
        Route::post('store', [AdminVehicleController::class, 'store'])
            ->name('admin.vehicle.store');
        Route::get('{vehicle}/edit', [AdminVehicleController::class, 'edit'])
            ->name('admin.vehicle.edit');
        Route::put('{vehicle}/update', [AdminVehicleController::class, 'update'])
            ->name('admin.vehicle.update');
    });

    // admin order management
    Route::group(['prefix' => 'order', 'middleware' => ['auth', 'auth.admin']], function() {
        // Route::get('/', [AdminOrderController::class, 'index'])
        //     ->name('admin.order.index');
        Route::get('search', [AdminOrderController::class, 'search'])
            ->name('admin.order.search');
        Route::put('{order}/update', [AdminOrderController::class, 'update'])
            ->name('admin.order.update');
        Route::put('{order}/complete', [AdminOrderController::class, 'complete'])
            ->name('admin.order.complete');
    });

    //admin user management
    Route::group(['prefix' => 'user', 'middleware' => ['auth', 'auth.admin']], function() {
        Route::get('search', [AdminUserController::class, 'search'])
            ->name('admin.user.search');
    });
});





/* Those are just template links. They can be changed if you are develop those feature. */
