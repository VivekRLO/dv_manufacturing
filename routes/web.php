<?php

use App\Http\Controllers\DistributorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RouteNameController;
use App\Http\Controllers\StockCountController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\UserController;
use App\Models\Distributor;
use App\Models\RouteName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Auth::routes(['register' => false]);

Route::get('/home', [
    HomeController::class, 'index',
])->name('home');

Route::get('add_in_bulk', [App\Http\Controllers\UserController::class,'add_in_bulk'])->name('users.add_in_bulk');


Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('users/dse', [App\Http\Controllers\UserController::class,'dse_users'])->name('users.dse_users');
    Route::get('users/so', [App\Http\Controllers\UserController::class,'so_users'])->name('users.so_users');
    Route::post('users/filter', [App\Http\Controllers\UserController::class,'dse_filter'])->name('users.dse_filter'); 

    Route::get('users/rm', [App\Http\Controllers\UserController::class,'rm_users'])->name('users.rm_users');

    Route::get('users/outlets', [App\Http\Controllers\UserController::class,'outlets'])->name('users.outlets');

    Route::post('/user/daywiseRoute/store', [App\Http\Controllers\UserController::class, 'store_day_wise_route_setup'])->name('user.store_day_wise_route_setup');
    Route::patch('/user/daywiseRoute/{id}/update', [App\Http\Controllers\UserController::class, 'update_day_wise_route_setup'])->name('user.update_day_wise_route_setup');
    Route::post('/user/quotation/store', [App\Http\Controllers\UserController::class, 'monthly_quotation'])->name('user.monthly_quotation');
    
    Route::resource('user', App\Http\Controllers\UserController::class);
    Route::get('/user/{id}/daywiseRoute', [App\Http\Controllers\UserController::class, 'day_wise_route_setup'])->name('user.day_wise_route_setup');

    // Route::get('/download_db', [App\Http\Controllers\DBDController::class, 'download'])->name('download');

    //distributors
    Route::post('dse_assign_route',[App\Http\Controllers\DistributorController::class, 'dse_assign_route'])->name('dse_assign_route');

    Route::get('distributors/file-import-export', [App\Http\controllers\DistributorController::class, 'fileImportExport'])->name('distributors.bulk_create');
    Route::post('distributors/file-import', [App\Http\controllers\DistributorController::class, 'fileImport'])->name('distributors.file-import');
    Route::resource('distributors', App\Http\Controllers\DistributorController::class);

    
    //produts
    Route::get('file-import-export', [App\Http\controllers\ProductController::class, 'fileImportExport'])->name('products.bulk_create');
    Route::post('file-import', [App\Http\controllers\ProductController::class, 'fileImport'])->name('file-import');
    Route::get('file-export', [App\Http\controllers\ProductController::class, 'fileExport'])->name('file-export');

    Route::get('distributor-product-list',[App\Http\Controllers\DistributorController::class,'product_list'])->name('products.distributorwise_product');
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::post('products/filter', [App\Http\Controllers\ProductController::class, 'product_filter'])->name('product.product_filter');

    Route::resource('batches', App\Http\Controllers\BatchController::class);
    Route::resource('sales', App\Http\Controllers\SaleController::class, ['except' => ['edit']]);
    Route::resource('collections', App\Http\Controllers\CollectionController::class, ['except' => ['create', 'edit']]);
    Route::resource('appVersions', App\Http\Controllers\AppVersionController::class);
    Route::resource('banks', App\Http\Controllers\BankController::class);
    Route::resource('dailyLocations', App\Http\Controllers\DailyLocationController::class);
    Route::resource('monthlyTours', App\Http\Controllers\MonthlyTourController::class);

    Route::resource('outlets', App\Http\Controllers\OutletController::class);
    Route::get('outlets/{id}/flagupdate', [App\Http\Controllers\OutletController::class, 'flagUpdate'])->name('outlets.flagupdate');
    Route::get('outlets/{id}/changeRoute/{to}', [App\Http\Controllers\OutletController::class, 'changeRoute'])->name('outlets.changeRoute');
    Route::post('outlets/filter', [App\Http\Controllers\OutletController::class, 'outlet_filter'])->name('outlet.outlet_filter');
    Route::get('removeOutlet', [App\Http\Controllers\OutletController::class, 'outlet_remove'])->name('outlet.outlet_remove');
    Route::delete('outlets/{id}/outlet_destroy', [App\Http\Controllers\OutletController::class, 'outlet_destroy'])->name('outlet.outlet_destroy');

    // Route::resource('outlets', App\Http\Controllers\OutletController::class, ['except' => ['create']]);

    //outlets bulk add 
    Route::get('file-import-export-outlets', [App\Http\controllers\OutletController::class, 'fileImportExport'])->name('outlets.bulk_create');
    Route::post('file-import-outlets', [App\Http\controllers\OutletController::class, 'fileImport'])->name('file-import-outlets');

    Route::get('checkinout/map_report/get-outlet/{long}/{lat}', [App\Http\Controllers\OutletController::class, 'getoutlets'])->name('getoutlets');

    Route::resource('stockHistories', App\Http\Controllers\StockHistoryController::class, ['except' => ['create', 'edit']]);
    Route::get('batch_stock_history/{batch_id}', [StockHistoryController::class, 'batch_stock_history'])->name('batch_stock_history');

    Route::get('/search', [App\Http\Controllers\CheckInOutController::class, 'search'])->name('checkInOut.search');
    Route::resource('checkInOuts', App\Http\Controllers\CheckInOutController::class, ['except' => ['create', 'edit']]);
    Route::get('checkinout/map_report/{id}', [App\Http\Controllers\CheckInOutController::class, 'map_report'])->name('checkinout.map_report');
    Route::get('live_location', [App\Http\Controllers\CheckInOutController::class, 'live_location'])->name('live_location');

    Route::get('report/sales_officer_sales', [ReportController::class, 'sales_officer_sales'])->name('report.sales_officer_sales');
    Route::get('report/daily_sales_officer_sales', [ReportController::class, 'daily_sales_officer_sales'])->name('report.daily_sales_officer_sales');

    // Filter For Reports
    Route::get('users/{id}/user_filter', [UserController::class, 'user_filter'])->name('users.user_filter');
    Route::post('users', [UserController::class, 'user_filter_by_flag'])->name('users.user_filter_by_flag');
    Route::get('distributors/{id}/distributors_filter', [DistributorController::class, 'distributors_filter'])->name('distributors.distributors_filter');
    Route::get('route/{id}/route_filter', [RouteNameController::class, 'route_filter'])->name('route.route_filter');
    Route::get('product/{id}/product_filter', [ProductController::class, 'product_filter_by_id'])->name('product.product_filter_by_id');
    Route::get('outlets/{id}/outlet_filter', [OutletController::class, 'outlet_filter_by_id'])->name('outlets.outlet_filter_by_id');
    
    Route::get('outlets/{id}/outlet_filter_by_order', [OutletController::class, 'outlet_filter_by_order'])->name('outlets.outlet_filter_by_order');



    Route::post('report/sales_officer_report', [ReportController::class, 'report_sales_officer'])->name('report.report_sales_officer');
    Route::post('report/daily_sales_officer_report', [ReportController::class, 'daily_report_sales_officer'])->name('report.daily_report_sales_officer');
    Route::get('report/daily_sale_report', [ReportController::class, 'daily_sale_report'])->name('report.daily_sale_report');
    Route::post('report/day_wise_report', [ReportController::class, 'day_wise_report'])->name('report.day_wise_report');
    Route::get('report/detail_report', [ReportController::class, 'detail_report'])->name('report.detail_report');
    Route::post('report/single_detail_report', [ReportController::class, 'single_detail_report'])->name('report.single_detail_report');
    Route::post('report/dse_outlestwise_product_report', [ReportController::class, 'dse_outlestwise_product_report'])->name('report.dse_outlestwise_product_report');
    Route::get('report/routewise_outlet_status', [ReportController::class, 'routewise_outlet_status'])->name('report.routewise_outlet_status');
    Route::get('/report/outletwise_report',[ReportController::class,'outletwise_report'])->name('report.outletwise_report');
    Route::post('report/routewise_outlet_report', [ReportController::class, 'routewise_outlet_report'])->name('report.routewise_outlet_report');
    Route::get('report/detail_routewise_outlet_report/{routelog_id}', [ReportController::class, 'detail_routewise_outlet_report'])->name('report.detail_routewise_outlet_report');
    
    Route::get('/get_profile', ['uses' => 'App\Http\Controllers\ProfileController@get_profile', 'as' => 'get_profile']);
    Route::post('/update_profile', ['uses' => 'App\Http\Controllers\ProfileController@update_profile', 'as' => 'update_profile']);
    Route::get('/get_change_password', ['uses' => 'App\Http\Controllers\ProfileController@get_change_password', 'as' => 'get_change_password']);
    Route::post('/post_change_password', ['uses' => 'App\Http\Controllers\ProfileController@post_change_password', 'as' => 'post_change_password']);
    Route::post('/upload_photo', ['uses' => 'App\Http\Controllers\ProfileController@upload_photo', 'as' => 'upload_photo']);

    Route::get('/get-locations', [HomeController::class, 'getLocations'])->name('getlocations');

    Route::view('reportgrid', 'reportgrid')->name('report_menu');

    Route::get('distributor-stockreport', [StockCountController::class, 'distributor_index'])->name('stockCounts.distributor_index');
    Route::resource('stockCounts', App\Http\Controllers\StockCountController::class);
    Route::post('search-stockreport', [StockCountController::class, 'showreport'])->name('search-stockreport');
    Route::post('search-stockreport-distributor', [StockCountController::class, 'search_stockreport_distributor'])->name('search-stockreport-distributor');
    
    
    Route::get('/distributor-wise-order', [App\Http\Controllers\OrderController::class, 'distributorwise'])->name('orders.distributorwise');
    Route::get('/distributor-wise-order-detail/{orrder_id}', [App\Http\Controllers\OrderController::class, 'distributorshow'])->name('orders.distributorshow');
    Route::resource('orders', App\Http\Controllers\OrderController::class);

    //distributor-wise
    Route::get('/getorderForm', [App\Http\Controllers\OrderController::class, 'getorderForm'])->name('getorderForm');
    Route::get('/orderForm/{order_id}', [App\Http\Controllers\OrderController::class, 'orderForm'])->name('orderForm');
    Route::post('/store_order_from', [App\Http\Controllers\OrderController::class, 'store_order_form'])->name('store_order_form');

      //salereturn
  Route::get('bulk-sale-return', [App\Http\Controllers\SaleReturnController::class, 'create_bulk_entry'])->name('saleReturns.create_bulksalereturn');
  Route::post('store-bulk-sale-return', [App\Http\Controllers\SaleReturnController::class, 'store_bulk_entry'])->name('saleReturns.store_bulksalereturn');
  Route::resource('saleReturns', App\Http\Controllers\SaleReturnController::class);

  Route::prefix('quotation')->name('quotation.')->group(function () {
    Route::get('/', [App\Http\Controllers\QuotationController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\QuotationController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\QuotationController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\QuotationController::class, 'edit'])->name('edit');
    Route::patch('/update/{id}', [App\Http\Controllers\QuotationController::class, 'update'])->name('update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\QuotationController::class, 'destroy'])->name('destroy');
    Route::get('/dse_view/{date}', [App\Http\Controllers\QuotationController::class, 'dse_view'])->name('dse_view');

  });
  
  Route::resource('channels', App\Http\Controllers\ChannelController::class);
  Route::resource('categories', App\Http\Controllers\CategoryController::class);
  Route::resource('zones', App\Http\Controllers\ZoneController::class);
  Route::resource('towns', App\Http\Controllers\TownController::class);
  Route::resource('routeName', App\Http\Controllers\RouteNameController::class);
  Route::get('/routeNames/{id}/outlet_map_plot', [App\Http\Controllers\RouteNameController::class, 'outlet_map_plot'])->name('routeNames.outlet_map_plot');
  Route::get('/routeNames/{id}/outlet_list', [App\Http\Controllers\RouteNameController::class, 'outlet_list'])->name('routeNames.outlet_list');
  Route::resource('routelogs', App\Http\Controllers\RouteLogsController::class);
});

