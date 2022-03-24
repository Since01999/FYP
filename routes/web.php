<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
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
    return view('welcome');
});

Route::get('admin',[AdminController::class,'index'])->name('admin.index');
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');


 //this is a group middleware
 //here we will create a group middleware named as AdminAuth for the login functionalities of
//the admin.

 
Route::group(['middleware'=>'admin_auth'],function(){

Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('admin/category',[CategoryController::class,'index'])->name('category.index');
Route::get('admin/category/manage_category',[CategoryController::class,'manageCategory'])->name('category.manage_category');
//here we are editing the category using the same function
Route::get('admin/category/manage_category/{id}',[CategoryController::class,'manageCategory'])->name('category.manage_category');
Route::get('admin/logout',function(){
    session()->forget('ADMIN_LOGIN'); 
    session()->forget('ADMIN_ID'); 
    session()->flash('error',"Logout Successfully");
    return redirect('admin');  
});
Route::Post('admin/category/manage_category_process',[CategoryController::class,'manageCategoryProcess'])->name('category.manage_category_process');
Route::get('admin/category/delete/{id}',[CategoryController::class,'deleteCategory'])->name('category.delete');
Route::get('admin/category/status/{status}/{id}',[CategoryController::class,'statusCategory'])->name('category.status');


//coupon routes

Route::get('admin/coupon',[CouponController::class,'index'])->name('coupon.index');
Route::get('admin/coupon/manage_coupon',[CouponController::class,'manageCoupon'])->name('coupon.manage_coupon');
//here we are editing the category using the same function
Route::get('admin/coupon/manage_coupon/{id}',[CouponController::class,'manageCoupon'])->name('coupon.manage_coupon');
Route::Post('admin/coupon/manage_coupon_process',[CouponController::class,'manageCouponProcess'])->name('coupon.manage_coupon_process');
Route::get('admin/coupon/delete/{id}',[CouponController::class,'deleteCoupon'])->name('coupon.delete');
Route::get('admin/coupon/status/{status}/{id}',[CouponController::class,'statusCoupon'])->name('coupon.status');

//size routes

Route::get('admin/size',[SizeController::class,'index'])->name('size.index');
Route::get('admin/size/manage_size',[SizeController::class,'manageSize'])->name('size.manage_size');
//here we are editing the size using the same function
Route::get('admin/size/manage_size/{id}',[SizeController::class,'manageSize'])->name('size.manage_size');
Route::Post('admin/size/manage_size_process',[SizeController::class,'manageSizeProcess'])->name('size.manage_size_process');
Route::get('admin/size/delete/{id}',[SizeController::class,'deleteSize'])->name('size.delete');
Route::get('admin/size/status/{status}/{id}',[SizeController::class,'statusSize'])->name('size.status');


//color Routes 


Route::get('admin/color',[ColorController::class,'index'])->name('color.index');
Route::get('admin/color/manage_color',[ColorController::class,'manageColor'])->name('color.manage_color');
//here we are editing the color using the same function
Route::get('admin/color/manage_color/{id}',[ColorController::class,'manageColor'])->name('color.manage_color');
Route::Post('admin/color/manage_color_process',[ColorController::class,'manageColorProcess'])->name('color.manage_color_process');
Route::get('admin/color/delete/{id}',[ColorController::class,'deleteColor'])->name('color.delete');
Route::get('admin/color/status/{status}/{id}',[ColorController::class,'statusColor'])->name('color.status');

//products route


Route::get('admin/product',[ProductController::class,'index'])->name('product.index');
Route::get('admin/product/manage_product',[ProductController::class,'manageProduct'])->name('product.manage_product');
//here we are editing the product using the same function
Route::get('admin/product/manage_product/{id}',[ProductController::class,'manageProduct'])->name('product.manage_product');
Route::Post('admin/product/manage_product_process',[ProductController::class,'manageProductProcess'])->name('product.manage_product_process');
Route::get('admin/product/delete/{id}',[ProductController::class,'deleteProduct'])->name('product.delete');
Route::get('admin/product/status/{status}/{id}',[ProductController::class,'statusProduct'])->name('product.status');
//deleting product Attribute
Route::get('admin/product_attr_delete/{pro_attr_id}/{pro_id}',[ProductController::class,'product_attr_delete'])->name('product.product_attr_delete');
//for deleting the product image (multiple)
Route::get('admin/product_images_delete/{pro_image_id}/{pro_id}',[ProductController::class,'product_images_delete'])->name('product.product_images_delete');



});

