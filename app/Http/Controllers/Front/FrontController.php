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

        //here we are fetching data related to the product review
        $result['product_review'] = 
        DB::table('product_review')
        ->leftJoin('customers','customers.id','=','product_review.customer_id')
        ->where(['product_review.products_id' => $result['product'][0]->id])
        ->where(['product_review.status' => 1])
        ->orderBy('product_review.added_on','DESC')
        ->select('product_review.rating','product_review.review','product_review.added_on','customers.name')
        ->get();
      
    }

    return view('front.product', $result);
  }
  public function add_to_cart(Request $request)
  {
    if ($request->session()->has('FRONT_USER_LOGIN')) {
      $uid = $request->session()->get('FRONT_USER_ID');
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


      //here we are getting the product qty and total qty of the product 
      $getAvailableQty = getAvailableQty($products_id,$product_attr_id);
      $finalAvailable = $getAvailableQty[0]->pqty - $getAvailableQty[0]->qty;
      if($pqty > $finalAvailable){
        return response()->json(['msg' => "not_available", 'data' =>"Only $finalAvailable products left!"]);
      }
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
      $uid = $request->session()->get('FRONT_USER_ID');
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

    if ($request->session()->has('FRONT_USER_LOGIN') != null) {
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
      $rand_id = rand(111111111, 999999999);
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


        $data = ['name' => $request->name, 'rand_id' => $rand_id];
        $user['to'] = $request->email;
        Mail::send('front.email_verification', $data, function ($messages) use ($user) {
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
      ->where(['email' => $request->str_login_email])
      ->get();
    if (isset($result[0])) {
      $db_pwd = Crypt::decrypt($result[0]->password);
      $status = $result[0]->status;
      $is_verify = $result[0]->is_verify;
      if ($is_verify == 0) {
        return response()->json(['status' => "error", 'msg' => "Please Verify Your Email!"]);
      }
      if ($status == 0) {
        return response()->json(['status' => "error", 'msg' => "Your Account has Been Deactivated!"]);
      }
      if ($db_pwd == $request->str_login_password) {

        //here making the cookie if the remember me option is selected 
        if ($request->rememberme === null) {
          //now if user donot click on the remember me ..then we can delete the cookie by some past time putting in the cookie 
          setcookie('login_email', $request->str_login_email, 100);  //100 is specifying the past time  
          setcookie('login_pwd', $request->str_login_password, 100);
        } else {
          setcookie('login_email', $request->str_login_email, time() + 60 * 60);
          setcookie('login_pwd', $request->str_login_password, time() + 60 * 60);
        }
        $request->session()->put('FRONT_USER_LOGIN', true);
        $request->session()->put('FRONT_USER_ID', $result[0]->id);
        $request->session()->put('FRONT_USER_NAME', $result[0]->name);
        $status = "success";
        $msg = "";

        //if user had added some items in the cart and he is not registered but after adding 2 to 3 products , he registered himself then we should change the cart table column from not-Reg to Reg .... so for that 

        $getTempUserID = getUserTempId();
        DB::table('cart')
          ->where(['user_id' => $getTempUserID, 'user_type' => 'Not-Reg'])
          ->update(['user_id' => $result[0]->id, 'user_type' => 'Reg']);
      } else {
        $status = "error";
        $msg = "Please Enter Valid Password";
      }
    } else {
      $status = "error";
      $msg = "Please Enter Valid Email Id";
    }
    return response()->json(['status' => $status, 'msg' => $msg]);
  }
  function email_verification(Request $request, $rand_id)
  {

    $result = DB::table('customers')
      ->where(['rand_id' => $rand_id])
      ->where(['is_verify' => 0])
      ->get();
    if (isset($result[0])) {
      $result = DB::table('customers')
        ->where(['id' => $result[0]->id])
        ->update(['is_verify' => 1, 'rand_id' => '']);
      return view('front.verification');
    } else {
      return redirect('/');
    }
  }
  //function for the forgot password 
  public function forgot_password(Request $request)
  {
    $result = DB::table('customers')
      ->where(['email' => $request->str_forgot_email])
      ->get();
    $rand_id = rand(111111111, 999999999);
    if (isset($result[0])) {
      $result = DB::table('customers')
        ->where(['email' => $request->str_forgot_email])
        ->update(['is_forgot_password' => 1, 'rand_id' => $rand_id]);

      $data = ['rand_id' => $rand_id];
      $user['to'] = $request->str_forgot_email;
      Mail::send('front.forgot_email', $data, function ($messages) use ($user) {
        $messages->to($user['to']);
        $messages->subject("Forgot Password");
      });
      return response()->json(['status' => "success", 'msg' => "Please Check Your Email Id for Password!"]);
    } else {
      return response()->json(['status' => "error", 'msg' => "Email Id not Registered!"]);
    }
  }
  function forgot_password_change(Request $request, $rand_id)
  {

    $result = DB::table('customers')
      ->where(['rand_id' => $rand_id])
      ->where(['is_verify' => 1])
      ->get();
    if (isset($result[0])) {
      $request->session()->put('FORGOT_PASSWORD_USER_ID', $result[0]->id);
      return view('front.forgot_password_change');
    } else {
      return redirect('/');
    }
  }
  //the process when user sets new password
  function forgot_password_change_process(Request $request)
  {
    $result = DB::table('customers')
      ->where(['id' => $request->session()->get('FORGOT_PASSWORD_USER_ID')])
      ->update(
        [
          'is_forgot_password' => 0,
          'password' => Crypt::encrypt($request->password),
          'rand_id' => '',
        ]
      );
    return response()->json(['status' => "success", 'msg' => "Password Changed Successfully!"]);
  }

  function checkout(Request $request)
  {
    //here first we check wheather user add something in the cart or not
    //caling the function from the common (where all functions are public) 
    $result['cart_data'] = getAddToCartTotalItem();

    if (isset($result['cart_data'][0])) {
      if ($request->session()->has('FRONT_USER_LOGIN')) {
        $uid = $request->session()->get('FRONT_USER_ID');
        $customer_info = DB::table('customers')
          ->where(['id' => $uid])
          ->get();
        $result['customers']['name'] = $customer_info[0]->name;
        $result['customers']['email'] = $customer_info[0]->email;
        $result['customers']['mobile'] = $customer_info[0]->mobile;
        $result['customers']['address'] = $customer_info[0]->address;
        $result['customers']['city'] = $customer_info[0]->city;
        $result['customers']['state'] = $customer_info[0]->state;
        $result['customers']['zip'] = $customer_info[0]->zip;
      } else {
        $result['customers']['name'] = "";
        $result['customers']['email'] = "";
        $result['customers']['mobile'] = "";
        $result['customers']['address'] = "";
        $result['customers']['city'] = "";
        $result['customers']['state'] = "";
        $result['customers']['zip'] = "";
      }
      return view('front.checkout', $result);
    } else {
      return redirect('/');
    }
  }
  //functionality related to the coupon code 
  public function apply_coupon_code(Request $request)
  {
    $arr = apply_coupon_code($request->coupon_code);
    $arr = json_decode($arr, true);

    return response()->json(['status' => $arr['status'], 'msg' => $arr['msg'], 'totalPrice' => $arr['totalPrice']]);
  }
  //function for removing the coupon code 
  function remove_coupon_code(Request $request)
  {

    $totalPrice = 0;
    $result = DB::table('coupons')
      ->where(['code' => $request->coupon_code])
      ->get();
    $getAddToCartTotalItem = getAddToCartTotalItem();
    //now getting the total price of all the items in the cart

    foreach ($getAddToCartTotalItem as $list) {
      $totalPrice = $totalPrice + ($list->qty * $list->price);
    }


    return response()->json(['status' => "success", 'msg' => "Coupon Code Removed", 'totalPrice' => $totalPrice]);
  }

  //function for placing the order 
  function place_order(Request $request)
  {
    $payment_url = '';
    $rand_id = rand(111111111, 999999999);
    if ($request->session()->has('FRONT_USER_LOGIN')) {
    } else {
      $valid = Validator::make($request->all(), [
        "email" => 'required|email|unique :customers,email',
      ]);
      if (!$valid->passes()) {
        return response()->json(['status' => 'error', 'msg' => "The Email has been Already Taken"]);
      } else {

        $arr = [
          "name"      => $request->name,
          "email"     => $request->email,
          "address"     => $request->address,
          "city"     => $request->city,
          "state"     => $request->state,
          "zip"     => $request->zip,
          "password"  => Crypt::encrypt($rand_id),
          "mobile"    => $request->mobile,
          "status"    => 1,
          "is_verify" => 1,
          "rand_id" => $rand_id,    //this will be unique number for verifiying the user
          "created_at" => date('Y-m-d h:i:s'),
          "updated_at" => date('Y-m-d h:i:s'),
          "is_forgot_password" => 0
        ];
        $user_id = DB::table('customers')->insertGetId($arr);

        //logging in the user 
        $request->session()->put('FRONT_USER_LOGIN', true);
        $request->session()->put('FRONT_USER_ID',  $user_id);
        $request->session()->put('FRONT_USER_NAME', $request->name);

        //sending mail to the Guest User for his password
        $data = ['name' => $request->name, 'password' => $rand_id];
        $user['to'] = $request->email;
        Mail::send('front.password_send', $data, function ($messages) use ($user) {
          $messages->to($user['to']);
          $messages->subject("New Password");
        });

        $getTempUserID = getUserTempId();
        DB::table('cart')
          ->where(['user_id' => $getTempUserID, 'user_type' => 'Not-Reg'])
          ->update(['user_id' => $user_id, 'user_type' => 'Reg']);
      }
    }


    $coupon_value = 0;
    if ($request->coupon_code != '') {
      $arr = apply_coupon_code($request->coupon_code);
      $arr = json_decode($arr, true);
      if ($arr['status'] == 'success') {
        $coupon_value = $arr['coupon_code_value'];
      } else {
        return response()->json(['status' => 'error', 'msg' => $arr['msg']]);
      }
    }
    $uid = $request->session()->get('FRONT_USER_ID');
    //getting total price of the cart   
    $totalPrice = 0;
    $getAddToCartTotalItem = getAddToCartTotalItem();
    foreach ($getAddToCartTotalItem as $list) {
      $totalPrice = $totalPrice + ($list->qty * $list->price);
    }
    $arr = [
      'customers_id' => $uid,
      "name"      => $request->name,
      "email"     => $request->email,
      "mobile"    => $request->mobile,
      "address"    => $request->address,
      "city"    => $request->city,
      "state"    => $request->state,
      'coupon_value' => $coupon_value,
      //in the database we used pincode instead of zip 
      "pincode"    => $request->zip,
      "coupon_code"    => $request->coupon_code,
      "payment_type"    => $request->payment_type,
      "payment_status"    => "Pending",
      'total_amount' => $totalPrice,
      'order_status'  => 1,
      "added_on" => date('Y-m-d h:i:s'),

    ];
    $order_id = DB::table('orders')->insertGetId($arr); //this will insert the data and get that specific id.
    //sending email to the guest user with his/her password



    if ($order_id > 0) {
      foreach ($getAddToCartTotalItem as $list) {
        $productDetailArr['product_id'] = $list->pid;
        $productDetailArr['products_attr_id'] = $list->attr_id;
        $productDetailArr['price'] = $list->price;
        $productDetailArr['qty'] = $list->qty;
        $productDetailArr['orders_id'] = $order_id;
        DB::table('orders_detail')->insert($productDetailArr);
      }
      //integrating instamojo payment gateways 

      if ($request->payment_type == 'Gateway') {


        // *******************INSTAMOJO PAYMENT GATEWAY**********************

        $final_amt = $totalPrice - $coupon_value;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
          $ch,
          CURLOPT_HTTPHEADER,
          array(
            "X-Api-Key:test_cffc88fc38618172a4900f8dc9a",
            "X-Auth-Token:test_94f5b0165f980d0f373ac18412a"
          )
        );
        $payload = array(
          'purpose' => 'Buy Product',
          'amount' => $final_amt,
          'buyer_name' => $request->name,
          'email' => $request->email,
          'phone' => $request->mobile,
          'redirect_url' => 'http://127.0.0.1:8000/instamojo_payment_redirect',
          'send_email' => 'True',
          'send_sms' => 'True',
          'allow_repeated_payments' => 'False',
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        if (isset($response->payment_request->id)) {
          $txn_id = $response->payment_request->id;
          DB::table('orders')
            ->where(['id' => $order_id])
            ->update(['txn_id' => $txn_id]);
          $payment_url = $response->payment_request->longurl;
        } else {
          $msg = " ";

          foreach ($request->message as $key => $val) {
            $msg .= strtoupper($key) . ": " . $val[0] . "</br>";
          }
          return response()->json(['status' => "error", 'msg' => "", 'payment_url' =>  ""]);
        }
      }

      //here when the order is placed we will empty the cart and proceed to the order page
      DB::table('cart')->where(['user_id' => $uid, 'user_type' => 'Reg'])->delete();
      //now setting the session for the Thankyou page corresponding to the orders id 
      $request->session()->put('ORDER_ID', $order_id);
      $status = "success";
      $msg = "Order Placed";
    } else {
      $status = "error";
      $msg = "Please Order After Sometime";
    }


    return response()->json(['status' => $status, 'msg' => $msg, 'payment_url' => $payment_url]);
  }

  //function for confirming the order 
  function order_placed(Request $request)
  {
    if ($request->session()->has('ORDER_ID')) {
      return view('front.order_placed');
    } else {
      return redirect('/');
    }
  }
  function order_failed(Request $request)
  {
    if ($request->session()->has('ORDER_ID')) {
      return view('front.order_failed');
    } else {
      return redirect('/');
    }
  }

  function instamojo_payment_redirect(Request $request)
  {
    if ($request->get('payment_id') !== null  && $request->get('payment_status') !== null && $request->get('payment_request_id') !== null) {
      if ($request->get('payment_status')  == 'Credit') {
        $status = 'Success';
        $redirect_url = '/order_placed';
      } else {
        $status = 'Failed';
        $redirect_url = '/order_failed';
      }
      $request->session()->put('ORDER_STATUS', $status);
      DB::table('orders')
        ->where(['txn_id' => $request->get('payment_request_id')])
        ->update(['payment_status' => $status, 'payment_id' => $request->get('payment_id')]);
      return redirect($redirect_url);
    } else {
      die('Something Went Wrong');
    }
  }
  function order(Request $request)
  {
    $result['orders'] =
      DB::table('orders')
      ->select('orders.*', 'orders_status.orders_status')
      ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
      ->where(['orders.customers_id' => $request->session()->get('FRONT_USER_ID')])
      ->get();
    return view('front.order', $result);
  }
  function order_detail(Request $request,$id)
  {
    $result['order_details']=
    DB::table('orders_detail')
    ->select('orders.*','orders_detail.price','orders_detail.qty','products.name as pname','products_attr.attr_image','sizes.size','colors.color','orders_status.orders_status')
    ->leftJoin('orders', 'orders.id', '=', 'orders_detail.orders_id')
    ->leftJoin('products_attr', 'products_attr.id', '=', 'orders_detail.products_attr_id')
    ->leftJoin('products', 'products.id', '=', 'products_attr.products_id')
    ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
    ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
    ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
    ->where(['orders.id' => $id])
    ->where(['orders.customers_id' => $request->session()->get('FRONT_USER_ID')])
    ->get();  
    if(!isset($result['order_details'][0])){
      return redirect('/');
    }
    return view('front.order_detail', $result);
  }


  //function for product review
  function product_review_process(Request $request)
  {
    //now here we will get all the data using the post 
    if ($request->session()->has('FRONT_USER_LOGIN')) {
      $uid = $request->session()->get('FRONT_USER_ID');
      $arr= [
        "rating" => $request->rating,
        "review" => $request->review,
        "products_id" => $request->product_id,
        "customer_id" => $uid,
        "status" => 1,
        "added_on" =>date('Y-m-d h:i:s') 
      ];
      $query = DB::table('product_review')->insert($arr);
      $status = "success";
      $msg = "Thankyou for providing your review";
      //after this we are getting all the data from product review table on line 141
    } else {
      $status = "error";
      $msg = "Please login to submit your review ";
    }
    //this data is going in the custom.js result
         return response()->json(['status'=>$status,'msg'=>$msg]);
  }
  
}
