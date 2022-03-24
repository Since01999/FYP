<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::all();
        return view("admin.brand", compact('data'));
    }
    public function manageBrand(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Brand::FindOrFail($id);
            $result['name'] = $arr->name;
            $result['image'] = $arr->image;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['name'] = '';
            $result['image'] = '';
            $result['id'] = 0;
        }
        return view('admin/manage_brand', $result);
    }

    //here we are using the same page for adding and updating size 
    //we can change both pages for simple code.
    public function manageBrandProcess(Request $request)
    {
        //now validation of data
        
        $request->validate([
         'name' => 'required | unique:brands,name,'  //unique in size table.
        ]);
    
        if ($request->id > 0) {
            $model = Brand::find($request->id);
            $message ="Brand Updated";
        } else {
            $model = new Brand(); 
            $message ="Brand Inserted";
        }
        $model->name = $request->name;
        $model->image = $request->image;
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/brand');
    }
    public function deleteBrand($id)
    {
        $data = Brand::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Brand Deleted Successfully');
        return redirect('admin/brand');
    }
    public function statusBrand(Request $request, $status , $id ){
        $data = Brand::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Brand Status Updated');
        return redirect('admin/brand');

    }
}
