<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index()
    {
        $data = Color::all();
        return view("admin.color", compact('data'));
    }
    public function manageColor(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Color::FindOrFail($id);
            $result['color'] = $arr->color;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['color'] = '';
            $result['id'] = 0;
        }
        return view('admin/manage_color', $result);
    }

    //here we are using the same page for adding and updating size 
    //we can change both pages for simple code.
    public function manageColorProcess(Request $request)
    {
        //now validation of data
        
        $request->validate([
         'color' => 'required | unique:colors,color,'  //unique in size table.
        ]);
    
        if ($request->id > 0) {
            $model = Color::find($request->id);
            $message ="Color Updated";
        } else {
            $model = new Color(); 
            $message ="Color Inserted";
        }
        $model->color = $request->color;
   
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/color');
    }
    public function deleteColor($id)
    {
        $data = Color::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Color Deleted Successfully');
        return redirect('admin/color');
    }
    public function statusColor(Request $request, $status , $id ){
        $data = Color::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Color Status Updated');
        return redirect('admin/color');

    }

}
