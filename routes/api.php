<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BothController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\HelpController;
 use App\Http\Controllers\PriceController;
use App\Http\Controllers\LineChartController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MergeReportsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\ProductSearch;
use App\Http\Controllers\ProductSellController;
use App\Http\Controllers\ProductsListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\purchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\searchProduct;
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TempPrintController;
use App\Http\Controllers\UserBuyReportsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagement;
use App\Http\Controllers\UserPurchaseReportsController;
use App\Http\Controllers\UserReportsController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WorkController;
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

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

     Route::resource('/user-managment',UserManagement::class);
     Route::resource('/user-reports', UserReportsController::class);
     Route::get('/reports', [CartController::class, 'userReports']);
     Route::resource('/user-buy-reports', UserBuyReportsController::class);
     Route::resource('/user-purchase-reports', UserPurchaseReportsController::class);
     Route::post('/update-date',[UserManagement::class,'updateDate']);

     Route::resource('/users', UserController::class);

});


Route::middleware('auth:sanctum')->group(function () {




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ AuthController::class, 'getUser']);
    Route::post('/logout', [ AuthController::class, 'logout']);
    Route::post('/register', [ AuthController::class, 'register']);
    Route::get('/user-compare', [ AuthController::class, 'compare']);
    Route::resource('/members', SupplierController::class);
    Route::resource('/warehouses', WarehouseController::class);

    Route::resource('/category', CategoryController::class);
    Route::resource('/temp-print', TempPrintController::class);
    Route::post('/delete-cart', [TempPrintController::class, 'delete']);
     Route::resource('/details', DetailsController::class);
     Route::resource('/merge-reports', MergeReportsController::class);
     Route::resource('/linechart-reports', LineChartController::class);

    Route::get('/products-stock', [ ProductListController::class, 'index']);
    Route::get('/categories', [ CategoryController::class, 'index']);
    Route::get('/livesearch', [SurveyController::class, 'index']);
    Route::post('/product-stockIn', [CartController::class, 'StockIn']);
    Route::get('/product-date', [CartController::class, 'todayCart']);
    Route::post('/deleteAll-history', [CartController::class, 'deleteAll']);
    Route::get('/temp-cart', [CartController::class, 'tempCart']);
    Route::get('/getCount', [CartController::class, 'getCount']);
    Route::get('/getSum', [CartController::class, 'getSum']);
    Route::get('/get-stocked-sum', [CartController::class, 'getStockedSum']);
    Route::get('/product-stockin', [CartController::class, 'getStockIn']);
    Route::get('/get-stockin-sum', [CartController::class, 'getStockInSum']);
    Route::resource('/purchase', purchaseController::class);
   // Route::get('/purchase/{id}', [purchaseController::class],'getById');
   Route::post('/delete-all-purchase',[purchaseController::class,'deleteAllProduct']);

   Route::post('/member/delete-all-member',[SupplierController::class,'deleteAllMember']);

    Route::get('/stockedData-month', [ChartController::class, 'filterByMonth']);
    Route::resource('/stockedData', ChartController::class);

    Route::resource('/survey', SurveyController::class);

    Route::get('/sales-month', [SalesController::class, 'filterByMonth']);
    Route::resource('/sales', SalesController::class);
    Route::resource('/user-payments', PaymentsController::class);

    Route::resource('/product-cart', CartController::class);


    Route::get('products/export/{products}',[CartController::class,'export']);
    Route::get('/products/all',[CartController::class,'allProducts']);

// routes/api.php


    Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/product/delete-all-product',[SurveyController::class,'deleteAllProduct']);
        Route::post('/details/delete-all-detail',[DetailsController::class,'deleteAllDetail']);
        Route::post('/product-Once',[SurveyController::class,'ProductOnce']);
        Route::post('/category-Once',[CategoryController::class,'CategoryOnce']);

    Route::put('/change-password',[ProfileController::class,'updatePassword']);
    Route::put('/update-profile',[ProfileController::class,'updateProfile']);
    Route::put('/update-data',[ProfileController::class,'update']);

    Route::post('/member-orders',[MemberController::class,'addOrder']);
    Route::resource('/order-price', \App\Http\Controllers\OrderController::class);
    Route::get('/member-search',[MemberController::class,'search']);
    Route::resource('/logo', \App\Http\Controllers\LogoController::class);
    Route::get('/get-logo',[LogoController::class,'getLogo']);
    Route::post('/logo/deleteall',[LogoController::class,'deleteAll']);
    Route::post('/field/deleteall/',[FieldController::class,'deleteAll']);
    Route::resource('/product', ProductController::class);
    Route::resource('all-product', ProductSellController::class);
    Route::resource('/search', ProductSearch::class);


    Route::get('/get-payment',[MemberController::class,'getPayment']);

///work

    Route::resource('/work', WorkController::class);


///
    Route::post('/users/deleteAllUser',[UserController::class,'deleteAllUser']);

    Route::get('/sumPayment', [MemberController::class, 'sumPayment']);

  Route::get('/activeMembers', [MemberController::class, 'activeMembers']);
  Route::get('/InactiveMembers', [MemberController::class, 'InactiveMembers']);

  Route::get('/activeUsers', [UserManagement::class, 'activeUsers']);
  Route::get('/InactiveUsers', [UserManagement::class, 'InactiveUsers']);

 Route::get('/activeProducts', [ProductController::class, 'activeProducts']);
  Route::get('/InactiveProducts', [ProductController::class, 'InactiveProducts']);
  Route::get('/product-all', [ProductController::class, 'productAll']);

  Route::put('/product-update', [CartController::class, 'update']);

// UserDashboard Routes
   Route::get('/user-payment', [UserManagement::class, 'getUserPayemnt']);

   Route::post('/user/delete-user-payment',[PlanController::class,'deleteAllPayment']);
   Route::get('/dashboard', [DashboardController::class, 'index']);

   Route::get('/dashboard/usersIncome-count', [DashboardController::class, 'totalPriceIncome']);
   Route::get('/dashboard/users-count', [DashboardController::class, 'totalUser']);
   Route::get('/dashboard/UserYear-count', [DashboardController::class, 'UserYear']);
   Route::get('/dashboard/monthUser-count', [DashboardController::class, 'monthUser']);
   Route::get('/dashboard/todayUser-count', [DashboardController::class, 'todayUser']);
   Route::get('/dashboard/products-count', [DashboardController::class, 'yearProductCount']);

   // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
   Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
   Route::get('/dashboard/top-members', [DashboardController::class, 'topMembers']);
   Route::get('/dashboard/latest-members', [DashboardController::class, 'latestMembers']);
   Route::get('/dashboard/month', [DashboardController::class, 'month']);
   Route::get('/dashboard/today', [DashboardController::class, 'today']);
   Route::get('/dashboard/year', [DashboardController::class, 'year']);
   Route::get('/dashboard/inactiveCustomers-count', [DashboardController::class, 'inactiveCustomers']);
   Route::get('/dashboard/users-expired', [DashboardController::class, 'expired']);
   Route::get('/price-ditail', [PlanController::class, 'priceDetail']);
   Route::resource('/price', PriceController::class);
   Route::post('/price/deleteAll',[PriceController::class,'deleteAll']);
   Route::resource('/help', HelpController::class);
   Route::post('/help/deleteAll',[HelpController::class,'deleteAll']);
   Route::post('/member/delete-member-payment',[MemberController::class,'deleteAllPayment']);
   Route::get('/export',[MemberController::class,'export']);
   Route::get('students/export/{students}',[MemberController::class,'export']);

   Route::get('/products/products-count', [ProductController::class, 'totalPrice']);
   Route::get('/products/profit-count', [ProductController::class, 'totalProfit']);
   Route::get('/products/sold-count', [ProductController::class, 'totalSold']);
   Route::get('/products/year-count', [DashboardController::class, 'yearProduct']);

   Route::get('/getproduct/{id}', [ProductController::class,'getProductdetails']);
   Route::put('/all-product/{id}', [ProductSellController::class,'updateProduct']);

   Route::resource('/plan',PlanController::class);


 });
});
  Route::get('/getuserdata/{id}', [UserController::class,'getUserdetails']);


//reset password
Route::post('/validate-token', [ AuthController::class, 'validateToken']);
Route::post('/reset-password', [ AuthController::class, 'resetPassword']);
Route::post('/send-token', [ AuthController::class, 'sendToken']);

//reset secretword
Route::post('/validate-Resettoken', [ AuthController::class, 'validateResettoken']);
Route::post('/reset-Resettoken', [ AuthController::class, 'resetResettoken']);
Route::post('/send-Resettoken', [ AuthController::class, 'sendResettoken']);


Route::get('/payment',[PlanController::class,'getStudent']);
Route::get('/payment/all',[PlanController::class,'allStudents']);


Route::get('/print-print',[MemberController::class,'Print']);

 Route::get('/get-help',[HelpController::class,'getHelp']);

 Route::get('/price', [PriceController::class,'index']);

Route::resource('/save-plan',PlanController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/product-by-slug/{product:slug}', [ProductController::class, 'showForGuest']);

Route::get('/member/export/{id}',[MemberController::class,'export']);
 Route::get('/purchase/{slug}', 'App\Http\Controllers\purchaseController@show');
