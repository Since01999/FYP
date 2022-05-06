<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    
    public function index()
    {
        $result['orders'] =
      DB::table('orders')
      ->select('orders.*', 'orders_status.orders_status')
      ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
      ->get();
      
    return view('admin.order', $result);
    }

    function order_detail(Request $request,$id)
    {
      //fetching payment status
      $result['order_details']=
      DB::table('orders_detail')
      ->select('orders.*','orders_detail.price','orders_detail.qty','products.name as pname','products_attr.attr_image','sizes.size','colors.color','orders_status.orders_status')
      ->leftJoin('orders', 'orders.id', '=', 'orders_detail.orders_id')
      ->leftJoin('products_attr', 'products_attr.id', '=', 'orders_detail.products_attr_id')
      ->leftJoin('products', 'products.id', '=', 'products_attr.products_id')
      ->leftJoin('sizes', 'sizes.id', '=', 'products_attr.size_id')
      ->leftJoin('colors', 'colors.id', '=', 'products_attr.color_id')
      ->leftJoin('orders_status', 'orders_status.id', '=', 'orders.order_status')
      ->where('orders.id', '=', $id)
      ->get();

      //now fetching the order status in order to change it at the admin panel
        $result['order_status'] = DB::table('orders_status')->get();

        
      $result['payment_status'] = ['Pending','Success','Fail'];
      return view('admin.order_detail', $result);
    }
    public function update_payment_status( Request $request ,$status , $id){
        DB::table('orders')
        ->where(['id' => $id])
        ->update(['payment_status' => $status]);
        // return ('/admin/order_detail/'.$id)   in case if below return not work we can use this
        return redirect()->back();
    }

    public function update_order_status( Request $request ,$status , $id){
      DB::table('orders')
      ->where(['id' => $id])
      ->update(['order_status' => $status]);
      // return ('/admin/order_detail/'.$id)   in case if below return not work we can use this
      return redirect()->back();
  }
  
    public function update_track_details(Request $request, $id){

      $track_details=$request->track_details;
      DB::table('orders')
      ->where(['id' => $id])
      ->update(['track_details' => $track_details]);
      // return ('/admin/order_detail/'.$id)   in case if below return not work we can use this
      return redirect()->back();

    }
    
}
