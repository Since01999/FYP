<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FrontController extends Controller
{
    
    public function index(Request $request)
    {
         $result['home_category'] = DB::table('categories')
         ->where(['status'=> 1])
         ->where(['is_home'=> 1])
         ->get();
           return view('front.index',$result);
        
    }
}
