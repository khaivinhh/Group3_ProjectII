<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;

use App\Http\Controllers\Admin\IphoneController;
use App\Http\Controllers\Admin\MacbookController;
use App\Http\Controllers\Admin\AppwatchController;

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategorydetailController;
use App\Http\Controllers\Admin\OrderdetailController;
use App\Http\Controllers\Frontend\CustomerinterfaceController;
use App\Models\Orderdetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('test', [HomeController::class, 'test'])->name('test');

Route::prefix('admin')->group(function () {
    Route::get('login', [HomeController::class, 'login'])->name('login');
    Route::post('checklogin', [HomeController::class, 'checklogin'])->name('checklogin');
    Route::post('createaccount', [UserController::class, 'store'])->name('createaccount');
});

//admin
Route::prefix('admin')->middleware('checkUserRole')->group(function () {

    Route::Resource('/admin', UserController::class);
    Route::Resource('/customer', CustomerController::class);

    Route::Resource('/iphone', IphoneController::class);
    Route::Resource('/macbook', MacbookController::class);
    Route::Resource('/appwatch', AppwatchController::class);

    Route::Resource('/category', CategoryController::class);
    Route::Resource('/categorydetail', CategorydetailController::class);
    Route::Resource('/image', ImageController::class);
    Route::Resource('/order', OrderController::class);
    Route::Resource('/orderdetail', OrderdetailController::class);

    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('searchcustomer', [CustomerController::class, 'searchcustomer'])->name('searchcustomer');
    Route::get('searchiphone', [IphoneController::class, 'searchiphone'])->name('searchiphone');
    Route::get('searchmacbook', [MacbookController::class, 'searchmacbook'])->name('searchmacbook');
    Route::get('searchappwatch', [AppwatchController::class, 'searchappwatch'])->name('searchappwatch');
    Route::get('searchcategorydetail', [CategorydetailController::class, 'searchcategorydetail'])->name('searchcategorydetail');
    Route::get('searchimage', [ImageController::class, 'searchimage'])->name('searchimage');

    Route::get('editprofile', [HomeController::class, 'editprofile'])->name('editprofile');
    Route::get('confirm_order/{order_id}', [HomeController::class, 'confirm_order'])->name('confirm_order');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');
});


//frontend
Route::prefix('frontend')->group(function () {
    Route::get('home', [CustomerinterfaceController::class, 'home'])->name('home');
    Route::get('shop/{category_product}', [CustomerinterfaceController::class, 'shop'])->name('shop');
    Route::get('about', [CustomerinterfaceController::class, 'about'])->name('about');
    Route::get('contact', [CustomerinterfaceController::class, 'contact'])->name('contact');
    Route::get('cart', [CustomerinterfaceController::class, 'cart'])->name('cart');
    Route::get('myaccount', [CustomerinterfaceController::class, 'myaccount'])->name('myaccount');
    Route::get('profile', [CustomerinterfaceController::class, 'profile'])->name('profile');
    Route::get('search_by_name', [CustomerinterfaceController::class, 'search_by_name'])->name('search_by_name');


    Route::post('create_user', [CustomerinterfaceController::class, 'create_user'])->name('create_user');
    Route::post('signin_user', [CustomerinterfaceController::class, 'signin_user'])->name('signin_user');
    Route::get('signout_user', [CustomerinterfaceController::class, 'signout_user'])->name('signout_user');
    Route::get('checkout', [CustomerinterfaceController::class, 'checkout'])->name('checkout');

    Route::get('iphone_detail/{id}', [CustomerinterfaceController::class, 'iphone_detail'])->name('iphone_detail');
    Route::get('macbook_detail/{id}', [CustomerinterfaceController::class, 'macbook_detail'])->name('macbook_detail');
    Route::get('appwatch_detail/{id}', [CustomerinterfaceController::class, 'appwatch_detail'])->name('appwatch_detail');
    Route::get('search_price', [CustomerinterfaceController::class, 'search_price'])->name('search_price');
    Route::get('sort_by/{category_product}', [CustomerinterfaceController::class, 'sort_by'])->name('sort_by');


    Route::get('category_detail/{id}/{category_id}', [CustomerinterfaceController::class, 'category_detail'])->name('category_detail');

    Route::post('add_to_cart', [CustomerinterfaceController::class, 'add_to_cart'])->name('add_to_cart');
    Route::post('update_cart', [CustomerinterfaceController::class, 'update_cart'])->name('update_cart');
    Route::get('remove_cart/{index}', [CustomerinterfaceController::class, 'remove_cart'])->name('remove_cart');
    Route::post('check_coupon', [CustomerinterfaceController::class, 'check_coupon'])->name('check_coupon');
    Route::post('place_order', [CustomerinterfaceController::class, 'place_order'])->name('place_order');
    Route::post('add_review', [CustomerinterfaceController::class, 'add_review'])->name('add_review');

    Route::get('purchase_history', [CustomerinterfaceController::class, 'purchase_history'])->name('purchase_history');
    Route::get('order_status', [CustomerinterfaceController::class, 'order_status'])->name('order_status');
    Route::post('re_order', [CustomerinterfaceController::class, 're_order'])->name('re_order');
    Route::put('update_profile', [CustomerinterfaceController::class, 'update_profile'])->name('update_profile');
    Route::delete('delete_customer/{id}', [CustomerinterfaceController::class, 'delete_customer'])->name('delete_customer');

    Route::get('delete_cart', [CustomerinterfaceController::class, 'delete_cart'])->name('delete_cart');
    Route::get('view_cart', [CustomerinterfaceController::class, 'view_cart'])->name('view_cart');
});
