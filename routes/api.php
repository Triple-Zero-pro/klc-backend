<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\OnboardsController;
use App\Http\Controllers\OrdersController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('profile', 'profile');
    Route::post('profile', 'update');
    Route::post('send-verification-code', 'send_verification_code');
    Route::post('apply-verification-code/{phone_number}', 'apply_verification_code');
    Route::post('reset-password/{phone_number}', 'reset_password');
    Route::post('add-credit', 'add_credit');
    Route::get('delete-credit/{credit_id}', 'delete_credit');
    Route::get('all-credit', 'all_credit');
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('categories', CategoriesController::class)->except(['store','update','destroy']);
    Route::resource('services', ServicesController::class)->except(['store','update','destroy']);
    Route::get('get_services_by_category/{category_id}', [ServicesController::class, 'get_services_by_category']);
    Route::resource('onboards', OnboardsController::class)->only(['index','show']);
    Route::resource('orders', OrdersController::class)->except(['update','destroy','index','show']);
    //Route::post('orders/update-status/{order_id}', [OrdersController::class, 'update_status']);
    Route::get('user/orders', [OrdersController::class, 'get_orders_by_user_id']);
    Route::post('user/cancel-order/{order_id}', [AuthController::class, 'cancel_order']);
    Route::post('about-us', [OnboardsController::class, 'about_us_update']);
});

///////////////////////////// public routes //////////////////////////////
Route::get('about-us', [OnboardsController::class, 'about_us']);
