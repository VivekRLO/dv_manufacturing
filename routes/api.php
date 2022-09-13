<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [App\Http\Controllers\API\UserAPIController::class, 'login']);

// Route::get('/get-address', [App\Http\Controllers\API\OutletAPIController::class, 'getAddressList']);
// Route::resource('outlets', OutletAPIController::class)->middleware('auth:api');

Route::get('/route_wise_outlet', [App\Http\Controllers\API\OutletAPIController::class, 'route_wise_outlet'])->middleware('auth:api');
Route::get('/channel_list', [App\Http\Controllers\API\AddressAPIController::class, 'channel_list'])->middleware('auth:api');
Route::get('/category_list', [App\Http\Controllers\API\AddressAPIController::class, 'category_list'])->middleware('auth:api');
Route::get('/town_list', [App\Http\Controllers\API\AddressAPIController::class, 'town_list'])->middleware('auth:api');
Route::get('/getalloutlets', [App\Http\Controllers\API\OutletAPIController::class, 'getalloutlets'])->middleware('auth:api');
Route::resource('outlets', OutletAPIController::class);

Route::get('/routelist', [App\Http\Controllers\API\UserAPIController::class, 'routelist'])->middleware('auth:api');
Route::get('/user_report/{id}', [App\Http\Controllers\API\UserAPIController::class, 'userReport'])->middleware('auth:api');
Route::post('/outlet_delete_request', [App\Http\Controllers\API\UserAPIController::class, 'outlet_delete_request'])->middleware('auth:api');
Route::get('/get-data', [App\Http\Controllers\API\UserAPIController::class, 'getLocationList']);
Route::get('/get_day_wise_route', [App\Http\Controllers\API\UserAPIController::class, 'day_wise_route'])->middleware('auth:api');
Route::get('/get-distributor', [App\Http\Controllers\API\DistributorAPIController::class, 'getdistributorList']);
Route::get('/gettownlist', [App\Http\Controllers\API\DistributorAPIController::class, 'gettownlist']);
Route::get('/getroutelist', [App\Http\Controllers\API\DistributorAPIController::class, 'getroutelist']);
Route::get('/getdselist', [App\Http\Controllers\API\DistributorAPIController::class, 'getdselist']);

Route::get('/get-date', [App\Http\Controllers\API\StockCountAPIController::class, 'getdatelist']);

// new route
Route::post('/routelogs', [App\Http\Controllers\API\RouteLogAPIController::class, 'store'])->middleware('auth:api');
Route::get('/distributor-wise-route/{distributor_id}', [App\Http\Controllers\API\OutletAPIController::class, 'distributor_route']);
// Route::get('/get-regionalmanager', [App\Http\Controllers\API\UserAPIController::class, 'getregionalmanager']);

Route::resource('distributors', DistributorAPIController::class)->middleware('auth:api');

Route::resource('products', ProductAPIController::class)->middleware('auth:api');

Route::resource('batches', BatchAPIController::class);

Route::resource('stock_histories', StockHistoryAPIController::class);

Route::resource('sales', SaleAPIController::class)->middleware('auth:api');

Route::resource('collections', CollectionAPIController::class)->middleware('auth:api');

Route::resource('check_in_outs',CheckInOutAPIController::class)->middleware('auth:api');
Route::post('/checkout', [App\Http\Controllers\API\CheckInOutAPIController::class, 'checkout'])->middleware('auth:api');

Route::resource('app_versions', AppVersionAPIController::class)->middleware('auth:api');

Route::resource('banks', BankAPIController::class)->middleware('auth:api');

Route::resource('daily_locations', DailyLocationAPIController::class)->middleware('auth:api');

Route::resource('monthly_tours', MonthlyTourAPIController::class)->middleware('auth:api');

Route::resource('stock_counts', StockCountAPIController::class)->middleware('auth:api');

Route::resource('addresses', AddressAPIController::class);
Route::get('/get-locations', [App\Http\Controllers\API\AddressAPIController::class, 'getLocations']);

Route::resource('sale_returns', SaleReturnAPIController::class);
