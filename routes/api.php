<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StateController;
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

Route::get('/test', function () {
    return "Welcome";
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('product', ProductController::class);
Route::apiResource('state', StateController::class);
Route::apiResource('customer', CustomerController::class);



Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [ApiController::class, 'user']);
});

// Route::group(['middleware' => ['auth:api', 'role:super']], function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
//Route::apiResource('/notification', NotificationController::class)->only(['store', 'index', 'show']);
// });
