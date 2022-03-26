<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::all();
        return view("admin.customer", compact('data'));
    }
    public function show(Request $request, $id = '')
    {
        
        $arr = Customer::where(['id'=>$id])->get();
        $result['show_customer_list'] = $arr['0'];
        return view('admin/show_customer', $result);
    }

    public function statusCustomer(Request $request, $status , $id ){
        $data = Customer::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Customer Status Updated');
        return redirect('admin/customer');

    }
}
