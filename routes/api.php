<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CarparkController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('carparks', CarparkController::class, [
    'as' => 'api',
]);

Route::get('/carparks/{carpark}/vehicles', [CarparkController::class, 'vehicles'])
    ->name('api.carparks.vehicles');

Route::get('/carparks/{carpark}/vehicles', [CarparkController::class, 'vehicles'])
    ->name('api.carparks.vehicles');

Route::group(['prefix' => 'order'], function() { // @todo auth api
    Route::post('create', [OrderController::class, 'create'])
        ->name('api.order.create');
    Route::post('{order}/payment', [OrderController::class, 'payment'])
        ->name('api.order.payment');
});
