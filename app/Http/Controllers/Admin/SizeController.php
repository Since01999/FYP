<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Size::all();
        return view("admin.size", compact('data'));
    }
    public function manageSize(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Size::FindOrFail($id);
            $result['size'] = $arr->size;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['size'] = '';
            $result['id'] = 0;
        }
        return view('admin/manage_size', $result);
    }

    //here we are using the same page for adding and updating size 
    //we can change both pages for simple code.
    public function manageSizeProcess(Request $request)
    {
        //now validation of data
        
        $request->validate([
            
            'size' => 'required | unique:sizes,size,'  //unique in size table.
        ]);
    
        if ($request->id > 0) {
            $model = Size::find($request->id);
            $message ="Size Updated";
        } else {
            $model = new Size(); 
            $message ="Size Inserted";
        }
        $model->size = $request->size;
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/size');
    }
    public function deleteSize($id)
    {
        $data = Size::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Size Deleted Successfully');
        return redirect('admin/size');
    }
    public function statusSize(Request $request, $status , $id ){
        $data = Size::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Size Status Updated');
        return redirect('admin/size');

    }
}
