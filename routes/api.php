<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DriversMoniesController;
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
use App\Http\Controllers\BannersController;
use App\Http\Controllers\Dashboard\CategoriesController as DashCategoriesController;
use App\Http\Controllers\Dashboard\AirportsController as DashAirportsController;
use App\Http\Controllers\Dashboard\ServicesController as DashServicesController;
use App\Http\Controllers\Dashboard\OnboardsController as DashOnboardsController;
use App\Http\Controllers\Dashboard\OrdersController as DashOrdersController;
use App\Http\Controllers\Dashboard\DriverController as DashDriverController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ServiceAttributesController as DashServiceAttributesController;
use App\Http\Controllers\Driver\AuthController as DriverAuthController;

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
    Route::post('update-password/{phone_number}', 'update_password');
    Route::post('add-credit', 'add_credit');
    Route::get('delete-credit/{credit_id}', 'delete_credit');
    Route::get('all-credit', 'all_credit');
    Route::get('get-balance', 'get_balance');
    Route::post('add-balance', 'add_balance');
    Route::post('update-balance', 'update_balance');
});
Route::group(['middleware' => 'auth:api'], function () {
    //////////////////////////// category ///////////////////////////////
    Route::resource('categories', CategoriesController::class)->except(['store', 'update', 'destroy']);


    //////////////////////////// service ///////////////////////////////
    Route::resource('services', ServicesController::class)->except(['store', 'update', 'destroy']);
    Route::post('services/{id}', [ServicesController::class, 'update']);
    Route::get('get_services_by_category/{category_id}', [ServicesController::class, 'get_services_by_category']);
    Route::get('get_services_by_name/{service_name}', [ServicesController::class, 'get_services_by_name']);


    //////////////////////////// service-attributes ///////////////////////////////
    Route::get('service-attributes/{service_id}', [ServiceAttributesController::class, 'index']);
    Route::post('service-attributes/{service_id}', [ServiceAttributesController::class, 'store']);
    Route::delete('service-attributes/{service_id}', [ServiceAttributesController::class, 'destroy']);


    //////////////////////////// orders ///////////////////////////////
    Route::resource('orders', OrdersController::class)->except(['update', 'destroy', 'index', 'show']);
    Route::get('user/orders', [OrdersController::class, 'get_orders_by_user_id']);
    Route::post('user/cancel-order/{order_id}', [AuthController::class, 'cancel_order']);
    Route::post('orders/update-status/{order_id}', [OrdersController::class, 'update_status']);
    Route::post('orders/wallet', [OrdersController::class, 'store_by_wallet']);
    Route::get('notifications', [AuthController::class, 'notifications']);
    Route::get('orders/confirmPay/{order_id}', [OrdersController::class, 'confirmPay']);



    //////////////////////////// OnboardsController ///////////////////////////////
    Route::post('about-us', [OnboardsController::class, 'about_us_update']);

    //////////////////////////// banners /////////////////////////////////
    Route::resource('banners', BannersController::class)->except(['store', 'update', 'destroy']);

    //////////////////////////// banners type /////////////////////////////////
    Route::resource('bannerTypes', BannerTypesController::class)->except(['store', 'update', 'destroy']);

    //////////////////////////// Airports /////////////////////////////////
    Route::resource('airports', AirportsController::class)->except(['store', 'update', 'destroy']);

});

///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Dashboard ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////

////////////////////////////// login admin /////////////////////////
Route::post('loginAdmin', [AuthController::class, 'loginAdmin']);


Route::group(['middleware' => 'auth:admins', 'prefix' => 'admin/dashboard', 'as' => 'dashboard.'], function () {
    //////////////////////////// Dashboard ///////////////////////////////
    Route::get('home', [HomeController::class, 'index']);

    //////////////////////////// categories ///////////////////////////////
    Route::resource('categories', DashCategoriesController::class);
    Route::post('categories/{id}', [DashCategoriesController::class, 'update']);


    //////////////////////////// service ///////////////////////////////
    Route::resource('services', DashServicesController::class);
    Route::post('services/{id}', [DashServicesController::class, 'update']);
    Route::get('get_services_by_category/{category_id}', [DashServicesController::class, 'get_services_by_category']);
    Route::get('get_services_by_name/{service_name}', [DashServicesController::class, 'get_services_by_name']);
    Route::get('categories_statistics', [DashServicesController::class, 'categories_statistics']);
    Route::get('services_by_categories_statistics/{cat_id}', [DashServicesController::class, 'services_by_categories_statistics']);


    //////////////////////////// service-attributes ///////////////////////////////
    Route::get('service-attributes/{service_id}', [DashServiceAttributesController::class, 'index']);
    Route::post('service-attributes/{service_id}', [DashServiceAttributesController::class, 'store']);
    Route::delete('service-attributes/{service_id}', [DashServiceAttributesController::class, 'destroy']);


    //////////////////////////// orders ///////////////////////////////
    Route::resource('orders', DashOrdersController::class);
    Route::get('user/orders', [DashOrdersController::class, 'get_orders_by_user_id']);
    Route::post('user/cancel-order/{order_id}', [AuthController::class, 'cancel_order']);
    Route::post('orders/update-status/{order_id}', [DashOrdersController::class, 'update_status']);
    Route::post('orders/assign_order_to_driver/{order_id}', [DashOrdersController::class, 'assign_order_to_driver']);



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
    Route::get('client_orders/{client_id}', [ClientsController::class, 'client_orders']);
    Route::get('client-banned/{client_id}', [ClientsController::class, 'client_banned']);


    //////////////////////////// Airports /////////////////////////////////
    Route::resource('airports', DashAirportsController::class);
    Route::post('airports/{id}', [DashAirportsController::class, 'update']);

    /////////////////////////// Drivers /////////////////////////////////
    Route::get('drivers', [DashDriverController::class, 'drivers']);
    Route::post('driver/register', [DashDriverController::class, 'register']);
    Route::get('driver/profile/{driver_id}', [DashDriverController::class, 'profile']);
    Route::post('driver/profile/{driver_id}', [DashDriverController::class, 'update']);
    Route::post('driver/update-status/{driver_id}', [DashDriverController::class, 'update_status']);
    Route::get('driver/{driver_id}/orders', [DashDriverController::class, 'get_orders_by_user_id']);

    /////////////////////////// driversMonies /////////////////////////////////
    Route::resource('driversMonies', DriversMoniesController::class);


    /////////////////////////// admins /////////////////////////////////
    Route::get('moderators', [AdminController::class, 'admins']);
    Route::post('moderators/register', [AdminController::class, 'register']);
    Route::get('moderators/{admin_id}', [AdminController::class, 'profile']);
    Route::post('moderators/{admin_id}', [AdminController::class, 'update']);
    Route::post('moderators/update-status/{admin_id}', [AdminController::class, 'update_status']);

});

///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// Drivers ////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
Route::group(['prefix' => 'driver', 'as' => 'drivers.'], function () {
    Route::post('login', [DriverAuthController::class, 'login']);
    Route::post('register', [DriverAuthController::class, 'register']);
    Route::post('logout', [DriverAuthController::class, 'logout']);
    Route::post('refresh', [DriverAuthController::class, 'refresh']);
    Route::get('profile', [DriverAuthController::class, 'profile']);
    Route::post('profile', [DriverAuthController::class, 'update']);
    Route::post('update-status', [DriverAuthController::class, 'update_status']);
    Route::post('update-location', [DriverAuthController::class, 'update_location']);
    Route::get('orders', [DriverAuthController::class, 'get_orders_by_user_id']);
    Route::get('orders/{driver_status}', [DriverAuthController::class, 'get_orders_by_driver_status']);
    Route::post('orders/pending/{order_id}', [DriverAuthController::class, 'pending']);
    Route::post('orders/accepted/{order_id}', [DriverAuthController::class, 'accepted']);
    Route::post('orders/refused/{order_id}', [DriverAuthController::class, 'refused']);
    Route::post('orders/servant-delivered/{order_id}', [DriverAuthController::class, 'servant_delivered']);
    Route::post('orders/servant-delivering/{order_id}', [DriverAuthController::class, 'servant_delivering']);
    Route::post('send-verification-code', [DriverAuthController::class, 'send_verification_code']);
    Route::post('apply-verification-code/{phone_number}', [DriverAuthController::class, 'apply_verification_code']);
    Route::post('update-password/{phone_number}', [DriverAuthController::class, 'update_password']);
    Route::get('notifications', [DriverAuthController::class, 'notifications']);
    Route::get('fcm_token/{fcm_token}', [DriverAuthController::class, 'fcm_token']);
});


///////////////////////////// public routes //////////////////////////////
Route::get('about-us', [OnboardsController::class, 'about_us']);
//////////////////////////// onboards ///////////////////////////////////
Route::resource('onboards', OnboardsController::class)->except(['store', 'update', 'destroy']);
