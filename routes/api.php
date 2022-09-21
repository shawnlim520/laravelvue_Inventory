<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::controller(AuthController::class)->group(function (){
        Route::post('login', 'login');
        Route::post('signup', 'signup');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('me', 'me');
        Route::post('register', 'register');
    });


});

Route::apiResource('/employee',EmployeeController::class);
Route::apiResource('/supplier',SupplierController::class);
Route::apiResource('/category',CategoryController::class);
Route::apiResource('/product',ProductController::class);
Route::apiResource('/expense',ExpenseController::class);
Route::apiResource('/customer',CustomerController::class);

Route::controller(ProductController::class)->group(function (){
    Route::post('/stock/update/{id}','StockUpdate')->name('stock.update');
    Route::get('/today/stockout/','StockOut')->name('stock.out');

});
Route::controller(SalaryController::class)->group(function (){
    Route::post('/salary/paid/{id}','Paid')->name('salary.paid');
    Route::get('/salary','AllSalary')->name('salary.all');
    Route::get('/salary/view/{id}','ViewSalary')->name('salary.view');
    Route::get('/salary/edit/{id}','EditSalary')->name('salary.edit');
    Route::post('/salary/update/{id}','UpdateSalary')->name('salary.update');

});

Route::controller(PosController::class)->group(function (){
    Route::get('/product/getting/{id}','GetProduct')->name('product.get');
    Route::post('/orderdone','OrderDone')->name('orderdone');
    
});


Route::controller(CartController::class)->group(function (){
    Route::get('/addToCart/{id}','AddToCart')->name('addtocart');
    Route::get('/cart/product','CartProduct')->name('cartproduct');
    Route::get('/remove/cart/{id}','RemoveCart')->name('removecart');
    Route::get('/add/cart/{id}','AddCart')->name('addcart');
    Route::get('/minus/cart/{id}','MinusCart')->name('minuscart');
    Route::get('/vat','Vats')->name('vat');
});
    
Route::controller(OrderController::class)->group(function (){
    Route::get('/order','TodayOrder')->name('order');
    Route::get('/order/details/{id}','OrderDetails')->name('order-details');
    Route::get('/order/orderdetails/{id}','OrderDetailsAll')->name('order-orderdetails');
    Route::post('/search/order','SearchOrderDate')->name('search-order');
    Route::get('/today/sell','TodaySell')->name('today-sell');
    Route::get('/today/income','TodayIncome')->name('today-income');
    Route::get('/today/due','TodayDue')->name('today-due');
    Route::get('/today/expense','TodayExpense')->name('today-expense');
    
});



// Route::controller(EmployeeController::class)->group(function (){
//     Route::post('/employee/store', 'store');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');
//     Route::post('me', 'me');
//     Route::post('register', 'register');
// });