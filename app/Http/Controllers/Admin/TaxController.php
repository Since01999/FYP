<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Tax::all();
        return view("admin.tax", compact('data'));
    }
    public function manageTax(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Tax::FindOrFail($id);
            $result['tax_desc'] = $arr->tax_desc;
            $result['tax_value'] = $arr->tax_value;
            $result['status'] = $arr->status;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['tax_desc'] = '';
            $result['tax_value'] = ' ';
            $result['status'] = ' ';
            $result['id'] = 0;
        }
        return view('admin/manage_tax', $result);
    }

    //here we are using the same page for adding and updating Tax 
    //we can change both pages for simple code.
    public function manageTaxProcess(Request $request)
    {
        //now validation of data
        
        $request->validate([
            
            'tax_value' => 'required | unique:taxes,tax_value,'. $request->post('id')  //unique in Tax table.
        ]);
    
        if ($request->id > 0) {
            $model = Tax::find($request->id);
            $message ="Tax Updated";
        } else {
            $model = new Tax(); 
            $message ="Tax Inserted";
        }
        $model->tax_desc = $request->tax_desc;
        $model->tax_value = $request->tax_value;
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/tax');
    }
    public function deleteTax($id)
    {
        $data = Tax::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Tax Deleted Successfully');
        return redirect('admin/tax');
    }
    public function statusTax(Request $request, $status , $id ){
        $data = Tax::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Tax Status Updated');
        return redirect('admin/tax');

    }
}
