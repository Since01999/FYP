<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
  public function product(Request $request, $slug)
  {
    $result['product'] = DB::table('products')
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
    $result['related_product'] = DB::table('products')
      ->where(['status' => 1])
      ->where('slug', '!=', $slug)
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
  public function add_to_cart(Request $request)
  {
    if ($request->session()->has('FRONT_USER_LOGIN')) {
      $uid = $request->session()->get('FRONT_USER_LOGIN');
      $user_type = 'Reg';
    } else {
      $uid = getUserTempId(); //this is a helper function for random user id in common file..
      $user_type = "Not-Reg";
    }
    //here we are getting this data from ajax that is implemented in cutom.js
    $size_id = $request->post('size_id');
    $color_id = $request->post('color_id');
    $pqty = $request->post('pqty');
    $products_id = $request->post('product_id');
    //now we will fetch product attribute data from size and color id.
    $result = DB::table('products_attr')
      ->select('products_attr.id')
      ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
      ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
      ->where(['products_id' => $products_id])
      ->where(['sizes.size' => $size_id])
      ->where(['colors.color' => $color_id])
      ->get();
    // prx($result[0]->id); this is the id of our product_attr
    //now storing it in a variable.
    $product_attr_id = $result[0]->id;

    //now we got everything to put it in the cart page for purchasing.
    // ********************************************
    //if this $chek exist in the database then we will update it.
    $check = DB::table('cart')
      ->where(['user_id' => $uid])
      ->where(['user_type' => $user_type])
      ->where(['product_id' => $products_id])
      ->where(['product_attr_id' => $product_attr_id])
      ->get();
    if (isset($check[0])) {
      $update_id = $check[0]->id;
      if ($pqty == 0) {
        DB::table('cart')
          ->where(['id' => $update_id])
          ->delete();
        $msg = "removed";
      } else {
        DB::table('cart')
          ->where(['id' => $update_id])
          ->update(['qty' => $pqty]);
        $msg = "updated";
      }
    } else {
      $id = DB::table('cart')
        //for adding and retrieving id at the same time.
        ->insertGetId([
          'user_id' => $uid,
          'user_type' => $user_type,
          'product_id' => $products_id,
          'product_attr_id' => $product_attr_id,
          'qty' => $pqty,
          'added_on' => date('Y-m-d h:i:s')
        ]);
      $msg = "added";
    }
    //now returning the data in json format to custom.js for checking 
    $result = DB::table('cart')
      ->leftJoin('products', 'products.id', '=', 'cart.product_id')
      ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
      ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
      ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
      ->where(['user_id' => $uid])
      ->where(['user_type' => $user_type])
      ->select(
        'cart.qty',
        'products.name',
        'products.image',
        'sizes.size',
        'colors.color',
        'products_attr.price',
        'products.slug',
        'products.id as pid',
        'products_attr.id as attr_id'
      )
      ->get();
    return response()->json(['msg' => $msg, 'data' => $result, 'totalItem' => count($result)]);
  }

  public function cart(Request $request)
  {

    if ($request->session()->has('FRONT_USER_LOGIN')) {
      $uid = $request->session()->get('FRONT_USER_LOGIN');
      $user_type = 'Reg';
    } else {
      $uid = getUserTempId(); //this is a helper function for random user id in common file..
      $user_type = "Not-Reg";
    }
    $result['list'] = DB::table('cart')
      ->leftJoin('products', 'products.id', '=', 'cart.product_id')
      ->leftJoin('products_attr', 'products_attr.id', '=', 'cart.product_attr_id')
      ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
      ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
      ->where(['user_id' => $uid])
      ->where(['user_type' => $user_type])
      ->select(
        'cart.qty',
        'products.name',
        'products.image',
        'sizes.size',
        'colors.color',
        'products_attr.price',
        'products.slug',
        'products.id as pid',
        'products_attr.id as attr_id'
      )
      ->get();

    return view('front.cart', $result);
  }

  public function category(Request $request, $slug)
  {
    //now here we are doing the category page filtering according to the url 
    $sort = "";
    $sort_txt = "";
    $filter_price_start = "";
    $filter_price_end = "";
    $color_filter = " ";
    $colorFilterArr = [];
    if ($request->get('sort') !== '') {
      $sort = $request->sort;
    }
    //now  if we want to sort data on the basis of date and name we will use these query.
    $query = DB::table('products');
    $query = $query->distinct()->select('products.*');
    $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id'); //error is here 
    $query = $query->where(['products.status' => 1]);
    $query = $query->where(['categories.category_slug' => $slug]);
    //now sorting acorrding to the name
    if ($sort == 'name') {
      $query = $query->orderBy('products.name', 'ASC');
      $sort_txt = "Product Name";
    }
    if ($sort == 'date') {
      $query = $query->orderBy('products.id', 'desc');
      $sort_txt = "Date";
    }
    $query = $query->leftJoin('products_attr', 'products_attr.products_id', '=', 'products.id');
    if ($sort == 'price_desc') {
      $query = $query->orderBy('products_attr.price', 'desc');
      $sort_txt = "Price In Descending Order";
    }
    //this is for the price 
    if ($request->get('filter_price_start') !== null  && $request->get('filter_price_end') !== null) {
      $filter_price_start = $request->get('filter_price_start');
      $filter_price_end = $request->get('filter_price_end');

      if ($filter_price_start > 0 &&  $filter_price_end > 0) {
        $query = $query->whereBetween('products_attr.price', [$filter_price_start, $filter_price_end]);
      }
    }
    // this is for the color 
    if ($request->get('color_filter') !== null) {
      $color_filter =  $request->get('color_filter');
      $colorFilterArr = explode(":", $color_filter); // this will convert the str into array on the basis of " : ".
      $colorFilterArr = array_filter($colorFilterArr); //this will remove empty elements
      $query = $query->where(['products_attr.color_id' => $request->get('color_filter')]);
    }

    if ($sort == 'price_asc') {
      $query = $query->orderBy('products_attr.price', 'asc');
      $sort_txt = "Price In Ascending Order";
    }
    $query = $query->get();
    $result['product'] = $query;

    //this is for the sorting of the price
    // loop for product and product attributes
    foreach ($result['product'] as $list1) {
      $query  = DB::table('products_attr');
      $query = $query->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
      $query = $query->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
      $query = $query->where('products_attr.products_id', '=', $list1->id);
      $query = $query->get();
      $result['product_attr'][$list1->id] = $query;
    }
    //for fetching all the colors to show in the category page
    $result['colors'] = DB::table('colors')
      ->where(['status' => 1])
      ->get();

    //for fetching all the categories to show in the side bar 
    $result['category_left'] = DB::table('categories')
      ->where(['status' => 1])
      ->get();

    $result['slug'] = $slug;
    $result['sort'] = $sort;
    $result['sort_txt'] = $sort_txt;
    $result['filter_price_start'] = $filter_price_start;
    $result['filter_price_end'] = $filter_price_end;
    $result['color_filter'] = $color_filter;
    $result['colorFilterArr'] = $colorFilterArr;

    return view('front.category', $result);
  }

  //function for searching the products
  public function search(Request $request, $str)
  {
    $query = DB::table('products');
    $query = $query->distinct()->select('products.*');
    $query = $query->leftJoin('categories', 'categories.id', '=', 'products.category_id'); //error is here 
    $query = $query->where(['products.status' => 1]);
    $query = $query->where('name', 'like', "%$str%");
    $query = $query->orwhere('model', 'like', "%$str%");
    $query = $query->orwhere('short_desc', 'like', "%$str%");
    $query = $query->orwhere('desc', 'like', "%$str%");
    $query = $query->orwhere('technical_specification', 'like', "%$str%");
    $query = $query->orwhere('keywords', 'like', "%$str%");
    $query = $query->get();
    $result['product'] = $query;

    foreach ($result['product'] as $list1) {
      $query  = DB::table('products_attr');
      $query = $query->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id');
      $query = $query->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id');
      $query = $query->where('products_attr.products_id', '=', $list1->id);
      $query = $query->get();
      $result['product_attr'][$list1->id] = $query;
    }
    return view('front.search', $result);
  }
  public function registration(Request $request)
  {

    if($request->session()->has('FRONT_USER_LOGIN') != null){
      return redirect('/');
    }
    $result = [];
    return view('front.registration', $result);
  }
  //function for the registration process
  public function registration_process(Request $request)
  {
    $valid = Validator::make($request->all(), [
      "name" => 'required',
      "email" => 'required|email|unique :customers,email', //here we are making the email unique from the customers table
      "password" => 'required',
      "mobile" => 'required|numeric|digits:11'
    ]);

    if (!$valid->passes()) {
      return response()->json(['status' => 'error', 'error' => $valid->errors()->toArray()]);
    } else {
       $rand_id = rand(111111111,999999999);
      $arr = [
        "name"      => $request->name,
        "email"     => $request->email,
        "password"  => Crypt::encrypt($request->password),
        "mobile"    => $request->mobile,
        "status"    => 1,
        "is_verify" => 0,
        "rand_id" => $rand_id,    //this will be unique number for verifiying the user
        "created_at" => date('Y-m-d h:i:s'),
        "updated_at" => date('Y-m-d h:i:s')
      ];
      $query = DB::table('customers')->insert($arr);
      if ($query) {
        //code for sending the email to the customer


        $data =['name'=>$request->name,'rand_id'=>$rand_id];
        $user['to'] =$request->email;
        Mail::send('front.email_verification', $data, function($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject("Email ID Verification");
        });
        
        return response()->json(['status' => 'success', 'msg' => "Registration successfull! Please Check your Email ID for Verification"]);
      }
    }
  }
  //funtion for the Login Process

  public function login_process(Request $request)
  {

    $result = DB::table('customers')
    ->where(['email'=>$request->str_login_email])
    ->get();
    if(isset($result[0])){
      $db_pwd = Crypt::decrypt($result[0]->password);  
      $status = $result[0]->status;
      $is_verify = $result[0]->is_verify;
      if($is_verify == 0){
        return response()->json(['status'=>"error",'msg'=>"Please Verify Your Email!"]);
      }
      if($status == 0){
        return response()->json(['status'=>"error",'msg'=>"Your Account has Been Deactivated!"]);        
      }
      if($db_pwd == $request->str_login_password){

        //here making the cookie if the remember me option is selected 
        if($request->rememberme === null){
          //now if user donot click on the remember me ..then we can delete the cookie by some past time putting in the cookie 
          setcookie('login_email',$request->str_login_email,100);  //100 is specifying the past time  
          setcookie('login_pwd',$request->str_login_password,100);

        }else{
          setcookie('login_email',$request->str_login_email,time()+60*60);
          setcookie('login_pwd',$request->str_login_password,time()+60*60);
        }
        $request->session()->put('FRONT_USER_LOGIN',true);
        $request->session()->put('FRONT_USER_ID',$result[0]->id);
        $request->session()->put('FRONT_USER_NAME',$result[0]->name);
        $status = "success";
        $msg = "";
      }else{
        $status = "error";
        $msg = "Please Enter Valid Password";
      }
    }else{
      $status = "error";
        $msg = "Please Enter Valid Email Id";
    }
    return response()->json(['status'=>$status,'msg'=>$msg]);
    
  }
  function email_verification(Request $request,$rand_id){

    $result = DB::table('customers')
    ->where(['rand_id' =>$rand_id])
    ->get();
    if(isset($result[0])){
      $result = DB::table('customers')
      ->where(['id' =>$result[0]->id])
      ->update(['is_verify' => 1 , 'rand_id' => '']);
      return view('front.verification');
    }else{
      return redirect('/');
    }
  }
}
