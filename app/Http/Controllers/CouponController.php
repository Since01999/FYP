<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $data = Coupon::all();
        return view("admin.coupon", compact('data'));
    }
    public function manageCoupon(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Coupon::FindOrFail($id);
            $result['title'] = $arr->title;
            $result['code'] = $arr->code;
            $result['value'] = $arr->value;
            $result['type'] = $arr->type;
            $result['min_order_amt'] = $arr->min_order_amt;
            $result['is_one_time'] = $arr->is_one_time;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['title'] = '';
            $result['code'] = '';
            $result['value'] = '';
            $result['type'] = '';
            $result['min_order_amt'] = '';
            $result['is_one_time'] = '';
            $result['id'] = 0;
        }
        return view('admin/manage_coupon', $result);
    }

    //here we are using the same page for adding and updating category 
    //we can change both pages for simple code.
    public function manageCouponProcess(Request $request)
    {
        //now validation of data
        //category_Slug should be unique
        $request->validate([
            'title' => 'required',
            'code' => 'required | unique:coupons,code,'.$request->id,  //unique in Coupon table.
            'value' => 'required',
        ]);
    
        if ($request->id > 0) {
            $model = Coupon::find($request->id);
            $message ="Coupon Updated";
        } else {
            $model = new Coupon();
            $message ="Coupon Inserted";
            $model->status = 1;
        }
        $model->title = $request->title;
        $model->code = $request->code;
        $model->value= $request->value;
        $model->type= $request->type;
        $model->min_order_amt= $request->min_order_amt;
        $model->is_one_time= $request->is_one_time;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/coupon');
    }
    public function deleteCoupon($id)
    {
        $data = coupon::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Coupon Deleted Successfully');
        return redirect('admin/coupon');
    }
    public function statusCoupon(Request $request, $status , $id ){
        $data = Coupon::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', ' Coupon Status Updated');
        return redirect('admin/coupon');

    }
}
