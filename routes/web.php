<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\HomeBannerController;
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

//loading the main view of the store 
// *************FrontEnd Views **************
Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('category/{id}', [FrontController::class, 'category'])->name('front.category');
Route::get('product/{id}', [FrontController::class, 'product'])->name('front.product');
//add to cart route 
Route::post('add_to_cart', [FrontController::class, 'add_to_cart'])->name('front.add_to_cart');
//route for the search bar 
Route::get('search/{str}', [FrontController::class, 'search'])->name('front.search');
//route for registration page of the user 
Route::get('registration', [FrontController::class, 'registration'])->name('front.registration');
//route for registring the user  (posting the data to the frontcontroller from ajax in custom.js)
Route::post('registration_process', [FrontController::class, 'registration_process'])->name('registration.registration_process');
//route for the email verification of the user 
Route::get('/verification/{id}', [FrontController::class, 'email_verification']);
// route for the Post request of the Logging in the user 
Route::post('login_process', [FrontController::class, 'login_process'])->name('login.login_process');
//route for the user forgot passwordv
Route::post('forgot_password', [FrontController::class, 'forgot_password'])->name('forgot.forgot_password');
//link for changing the password that is sent in the mail 
Route::get('forgot_password_change/{id}', [FrontController::class, 'forgot_password_change'])->name('forgot.forgot_password_change');
//Route when customer sets his/her new Password
Route::post('/forgot_password_change_process', [FrontController::class, 'forgot_password_change_process'])->name('forgot.forgot_password_change_process');
//Route for the checkout page
Route::get('/checkout', [FrontController::class, 'checkout'])->name('front.checkout');
//route for the coupon code 
Route::post('/apply_coupon_code', [FrontController::class, 'apply_coupon_code'])->name('front.apply_coupon_code');
//Route for removing the coupon code 
Route::post('/remove_coupon_code', [FrontController::class, 'remove_coupon_code'])->name('front.remove_coupon_code');
Route::post('/place_order', [FrontController::class, 'place_order'])->name('front.place_order');
//route when the order is placed
Route::get('/order_placed', [FrontController::class, 'order_placed'])->name('front.order_placed');
//route if the order is failed
Route::get('/order_failed', [FrontController::class, 'order_failed'])->name('front.order_failed');


//Route For the Payment Gateways 

// *******************************INSTAMOJO PAYMENT*****************************************
Route::get('/instamojo_payment_redirect ', [FrontController::class, 'instamojo_payment_redirect'])->name('Gateway.instamojo_payment_redirect');

/**********************************MIDDLEWARE FOR USER AUTH*********************** */
Route::group(['middleware' => 'user_auth'], function () {
    //Route for My orders Page
    Route::get('/order', [FrontController::class, 'order'])->name('front.order');
    //Route for order Details 
    Route::get('order_detail/{id}', [FrontController::class, 'order_detail'])->name('front.order_detail');
}); 

//route for Logging Out The User
Route::get('logout', function () {
    session()->forget('FRONT_USER_LOGIN');
    session()->forget('FRONT_USER_ID');
    session()->forget('FRONT_USER_NAME');
    session()->forget('USER_TEMP_ID');
    session()->flash('error', "Logout Successfully");
    return redirect('/');
});


//route for the cart page
Route::get('cart', [FrontController::class, 'cart'])->name('front.cart');


//loading the admin routes 
Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');


//this is a group middleware
//here we will create a group middleware named as AdminAuth for the login functionalities of
//the admin.


Route::group(['middleware' => 'admin_auth'], function () {

    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('admin/category/manage_category', [CategoryController::class, 'manageCategory'])->name('category.manage_category');
    //here we are editing the category using the same function
    Route::get('admin/category/manage_category/{id}', [CategoryController::class, 'manageCategory'])->name('category.manage_category');
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('error', "Logout Successfully");
        return redirect('admin');
    });
    Route::Post('admin/category/manage_category_process', [CategoryController::class, 'manageCategoryProcess'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('category.delete');
    Route::get('admin/category/status/{status}/{id}', [CategoryController::class, 'statusCategory'])->name('category.status');


    //coupon routes

    Route::get('admin/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('admin/coupon/manage_coupon', [CouponController::class, 'manageCoupon'])->name('coupon.manage_coupon');
    //here we are editing the category using the same function
    Route::get('admin/coupon/manage_coupon/{id}', [CouponController::class, 'manageCoupon'])->name('coupon.manage_coupon');
    Route::Post('admin/coupon/manage_coupon_process', [CouponController::class, 'manageCouponProcess'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}', [CouponController::class, 'deleteCoupon'])->name('coupon.delete');
    Route::get('admin/coupon/status/{status}/{id}', [CouponController::class, 'statusCoupon'])->name('coupon.status');

    //size routes

    Route::get('admin/size', [SizeController::class, 'index'])->name('size.index');
    Route::get('admin/size/manage_size', [SizeController::class, 'manageSize'])->name('size.manage_size');
    //here we are editing the size using the same function
    Route::get('admin/size/manage_size/{id}', [SizeController::class, 'manageSize'])->name('size.manage_size');
    Route::Post('admin/size/manage_size_process', [SizeController::class, 'manageSizeProcess'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{id}', [SizeController::class, 'deleteSize'])->name('size.delete');
    Route::get('admin/size/status/{status}/{id}', [SizeController::class, 'statusSize'])->name('size.status');


    //color Routes 


    Route::get('admin/color', [ColorController::class, 'index'])->name('color.index');
    Route::get('admin/color/manage_color', [ColorController::class, 'manageColor'])->name('color.manage_color');
    //here we are editing the color using the same function
    Route::get('admin/color/manage_color/{id}', [ColorController::class, 'manageColor'])->name('color.manage_color');
    Route::Post('admin/color/manage_color_process', [ColorController::class, 'manageColorProcess'])->name('color.manage_color_process');
    Route::get('admin/color/delete/{id}', [ColorController::class, 'deleteColor'])->name('color.delete');
    Route::get('admin/color/status/{status}/{id}', [ColorController::class, 'statusColor'])->name('color.status');

    //products route


    Route::get('admin/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('admin/product/manage_product', [ProductController::class, 'manageProduct'])->name('product.manage_product');
    //here we are editing the product using the same function
    Route::get('admin/product/manage_product/{id}', [ProductController::class, 'manageProduct'])->name('product.manage_product');
    Route::Post('admin/product/manage_product_process', [ProductController::class, 'manageProductProcess'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::get('admin/product/status/{status}/{id}', [ProductController::class, 'statusProduct'])->name('product.status');
    //deleting product Attribute
    Route::get('admin/product_attr_delete/{pro_attr_id}/{pro_id}', [ProductController::class, 'product_attr_delete'])->name('product.product_attr_delete');
    //for deleting the product image (multiple)
    Route::get('admin/product_images_delete/{pro_image_id}/{pro_id}', [ProductController::class, 'product_images_delete'])->name('product.product_images_delete');

    //brand Routes 

    Route::get('admin/brand', [BrandController::class, 'index'])->name('brand.index');
    Route::get('admin/brand/manage_brand', [BrandController::class, 'manageBrand'])->name('brand.manage_color');
    //here we are editing the color using the same function
    Route::get('admin/brand/manage_brand/{id}', [BrandController::class, 'manageBrand'])->name('brand.manage_brand');
    Route::Post('admin/brand/manage_brand_process', [BrandController::class, 'manageBrandProcess'])->name('brand.manage_brand_process');
    Route::get('admin/brand/delete/{id}', [BrandController::class, 'deleteBrand'])->name('brand.delete');
    Route::get('admin/brand/status/{status}/{id}', [BrandController::class, 'statusBrand'])->name('brand.status');


    //Tax Routes


    Route::get('admin/tax', [TaxController::class, 'index'])->name('tax.index');
    Route::get('admin/tax/manage_tax', [TaxController::class, 'manageTax'])->name('tax.manage_tax');
    //here we are editing the color using the same function
    Route::get('admin/tax/manage_tax/{id}', [TaxController::class, 'manageTax'])->name('tax.manage_tax');
    Route::Post('admin/tax/manage_tax_process', [TaxController::class, 'manageTaxProcess'])->name('tax.manage_tax_process');
    Route::get('admin/tax/delete/{id}', [TaxController::class, 'deleteTax'])->name('tax.delete');
    Route::get('admin/tax/status/{status}/{id}', [TaxController::class, 'statusTax'])->name('tax.status');


    //customer route 


    Route::get('admin/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('admin/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('admin/customer/status/{status}/{id}', [CustomerController::class, 'statusCustomer'])->name('customer.status');

    //home Banner Routes


    Route::get('admin/homebanner', [HomeBannerController::class, 'index'])->name('homebanner.index');
    Route::get('admin/homebanner/manage_homebanner', [HomeBannerController::class, 'manageHomeBanner'])->name('homebanner.manage_homebanner');
    //here we are editing the color using the same function
    Route::get('admin/homebanner/manage_homebanner/{id}', [HomeBannerController::class, 'manageHomeBanner'])->name('homebanner.manage_homebanner');
    Route::Post('admin/homebanner/manage_homebanner_process', [HomeBannerController::class, 'manageHomeBannerProcess'])->name('homebanner.manage_homebanner_process');
    Route::get('admin/homebanner/delete/{id}', [HomeBannerController::class, 'deleteHomeBanner'])->name('homebanner.delete');
    Route::get('admin/homebanner/status/{status}/{id}', [HomeBannerController::class, 'statusHomeBanner'])->name('homebanner.status');
});
