<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\OnboardsController;

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
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('categories', CategoriesController::class);
    Route::resource('services', ServicesController::class);
    Route::get('get_services_by_category/{category_id}', [ServicesController::class, 'get_services_by_category']);
    Route::resource('onboards', OnboardsController::class);
    Route::get('about-us', [OnboardsController::class, 'about_us']);
    Route::post('about-us', [OnboardsController::class, 'about_us_update']);
});

