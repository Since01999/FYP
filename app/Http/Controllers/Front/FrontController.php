<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class FrontController extends Controller
{

  public function index(Request $request)
  {
    $result['home_category'] = DB::table('categories')
      ->where(['status' => 1])
      ->where(['is_home' => 1])
      ->get();
    //loop for product related to the categories 
    foreach ($result['home_category'] as $list) {
      $result['home_category_product'][$list->id] = DB::table('products')
        ->where(['status' => 1])
        ->where(['category_id' => $list->id])
        ->get();
      //loop for product and product attributes
      foreach ($result['home_category_product'][$list->id] as $list1) {
        $result['home_product_attr'][$list1->id] =
          DB::table('products_attr')
          ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
          ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
          ->where('products_attr.products_id', '=', $list1->id)
          ->get();
      }
    }

    $result['home_brand'] = DB::table('brands')
      ->where(['status' => 1])
      ->where(['is_home' => 1])
      ->get();


    //getting data of the featured product

    $result['home_featured_product'][$list->id] = DB::table('products')
      ->where(['status' => 1])
      ->where(['is_featured' => 1])
      ->get();
    //loop for product and product attributes
    foreach ($result['home_featured_product'][$list->id] as $list1) {
      $result['home_featured_product_attr'][$list1->id] =
        DB::table('products_attr')
        ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        ->where('products_attr.products_id', '=', $list1->id)
        ->get();
    }


    //getting data of the Trending product
    
    $result['home_trending_product'][$list->id] = DB::table('products')
      ->where(['status' => 1])
      ->where(['is_trending' => 1])
      ->get();
    //loop for product and product attributes
    foreach ($result['home_trending_product'][$list->id] as $list1) {
      $result['home_trending_product_attr'][$list1->id] =
        DB::table('products_attr')
        ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        ->where('products_attr.products_id', '=', $list1->id)
        ->get();
    }


    //getting data of the Discouted product
    
    $result['home_discounted_product'][$list->id] = DB::table('products')
      ->where(['status' => 1])
      ->where(['is_discounted' => 1])
      ->get();
    //loop for product and product attributes
    foreach ($result['home_discounted_product'][$list->id] as $list1) {
      $result['home_discounted_product_attr'][$list1->id] =
        DB::table('products_attr')
        ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        ->where('products_attr.products_id', '=', $list1->id)
        ->get();
    }

    // data  related to home Banner
    $result['home_banner'] = DB::table('home_banners')
      ->where(['status' => 1])
      ->get();
    return view('front.index', $result);
  }
  public function product(Request $request,$slug){
    $result['product']= DB::table('products')
      ->where(['status' => 1])
      ->where(['slug' => $slug])
      ->get();
    //loop for product and product attributes
    foreach ($result['product'] as $list1) {
      $result['product_attr'][$list1->id] =
        DB::table('products_attr')
        ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        ->where('products_attr.products_id', '=', $list1->id)
        ->get();
    }
    /******* Multiple Products Images Section ********/
    foreach ($result['product'] as $list1) {
      $result['product_images'][$list1->id] =
        DB::table('products_images')
        ->where('products_images.products_id', '=', $list1->id)
        ->get();
    }
      /*******Related Products Section ********/
    $result['related_product']= DB::table('products')
      ->where(['status' => 1])
      ->where('slug','!=', $slug)
      ->where(['category_id' => $result['product'][0]->category_id])
      ->skip(0)->take(4)
      ->get();
    //loop for categories id and related categories products 
    foreach ($result['related_product'] as $list1) {
      $result['related_product_attr'][$list1->id] =
        DB::table('products_attr')
        ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
        ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
        ->where('products_attr.products_id', '=', $list1->id)
        ->get();
    }
    
    return view('front.product', $result);
    
  }
  public function add_to_cart(Request $request){
    if($request->session()->has('FRONT_USER_LOGIN')){
      $uid = $request->session()->get('FRONT_USER_LOGIN');
      $user_type = 'Reg';
    }else{
      $uid = getUserTempId();
      $user_type = "Not-Reg";
      }
echo $uid;
echo $user_type;
    }
}

