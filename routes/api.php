<?php

use App\Http\Controllers\BannersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\OnboardsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServiceAttributesController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\BannerTypesController;
use App\Http\Controllers\AirportsController;
use App\Http\Controllers\Dashboard\CategoriesController as DashCategoriesController;
use App\Http\Controllers\Dashboard\AirportsController as DashAirportsController;
use App\Http\Controllers\Dashboard\ServicesController as DashServicesController;
use App\Http\Controllers\Dashboard\OnboardsController as DashOnboardsController;
use App\Http\Controllers\Dashboard\OrdersController as DashOrdersController;
use App\Http\Controllers\Dashboard\ServiceAttributesController as DashServiceAttributesController;

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
    //////////////////////////// category ///////////////////////////////
    Route::resource('categories', CategoriesController::class)->except(['store','update','destroy']);


    //////////////////////////// service ///////////////////////////////
    Route::resource('services', ServicesController::class)->except(['store','update','destroy']);
    Route::post('services/{id}', [ServicesController::class, 'update']);
    Route::get('get_services_by_category/{category_id}', [ServicesController::class, 'get_services_by_category']);
    Route::get('get_services_by_name/{service_name}', [ServicesController::class, 'get_services_by_name']);


    //////////////////////////// service-attributes ///////////////////////////////
    Route::get('service-attributes/{service_id}', [ServiceAttributesController::class,'index']);
    Route::post('service-attributes/{service_id}', [ServiceAttributesController::class,'store']);
    Route::delete('service-attributes/{service_id}', [ServiceAttributesController::class,'destroy']);


    //////////////////////////// orders ///////////////////////////////
    Route::resource('orders', OrdersController::class)->except(['update','destroy','index','show']);
    Route::get('user/orders', [OrdersController::class, 'get_orders_by_user_id']);
    Route::post('user/cancel-order/{order_id}', [AuthController::class, 'cancel_order']);
    Route::post('orders/update-status/{order_id}', [OrdersController::class, 'update_status']);


    //////////////////////////// OnboardsController ///////////////////////////////
    Route::post('about-us', [OnboardsController::class, 'about_us_update']);

    //////////////////////////// banners /////////////////////////////////
    Route::resource('banners', BannersController::class)->except(['store','update','destroy']);

    //////////////////////////// banners type /////////////////////////////////
    Route::resource('bannerTypes', BannerTypesController::class)->except(['store','update','destroy']);

    //////////////////////////// Airports /////////////////////////////////
    Route::resource('airports', AirportsController::class)->except(['store','update','destroy']);

});

///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Dashboard ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////// login admin /////////////////////////
Route::post('loginAdmin',[AuthController::class,'loginAdmin']);


Route::group(['middleware' => 'auth:admins','prefix' => 'admin/dashboard','as'=> 'dashboard.'], function () {
    //////////////////////////// categories ///////////////////////////////
    Route::resource('categories', DashCategoriesController::class);
    Route::post('categories/{id}', [DashCategoriesController::class, 'update']);


    //////////////////////////// service ///////////////////////////////
    Route::resource('services', DashServicesController::class);
    Route::post('services/{id}', [DashServicesController::class, 'update']);
    Route::get('get_services_by_category/{category_id}', [DashServicesController::class, 'get_services_by_category']);
    Route::get('get_services_by_name/{service_name}', [DashServicesController::class, 'get_services_by_name']);


    //////////////////////////// service-attributes ///////////////////////////////
    Route::get('service-attributes/{service_id}', [DashServiceAttributesController::class,'index']);
    Route::post('service-attributes/{service_id}', [DashServiceAttributesController::class,'store']);
    Route::delete('service-attributes/{service_id}', [DashServiceAttributesController::class,'destroy']);


    //////////////////////////// orders ///////////////////////////////
    Route::resource('orders', DashOrdersController::class);
    Route::get('user/orders', [DashOrdersController::class, 'get_orders_by_user_id']);
    Route::post('user/cancel-order/{order_id}', [AuthController::class, 'cancel_order']);
    Route::post('orders/update-status/{order_id}', [DashOrdersController::class, 'update_status']);


    //////////////////////////// OnboardsController ///////////////////////////////
    Route::resource('onboards', DashOnboardsController::class);
    Route::post('about-us', [DashOnboardsController::class, 'about_us_update']);


    //////////////////////////// banners type /////////////////////////////////
    Route::resource('bannerTypes', BannerTypesController::class);
    Route::post('bannerTypes/{id}', [BannerTypesController::class, 'update']);

    //////////////////////////// banners /////////////////////////////////
    Route::resource('banners', BannersController::class);
    Route::post('banners/{id}', [BannersController::class, 'update']);



    //////////////////////////// clients /////////////////////////////////
    Route::resource('clients', ClientsController::class);
    Route::post('clients/{id}', [ClientsController::class, 'update']);




    //////////////////////////// Airports /////////////////////////////////
    Route::resource('airports', DashAirportsController::class);
    Route::post('airports/{id}', [DashAirportsController::class, 'update']);

});


///////////////////////////// public routes //////////////////////////////
Route::get('about-us', [OnboardsController::class, 'about_us']);
//////////////////////////// onboards ///////////////////////////////////
Route::resource('onboards', OnboardsController::class)->except(['store','update','destroy']);
