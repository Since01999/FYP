<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return view("admin.category", compact('data'));
    }
    public function manageCategory(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Category::FindOrFail($id);
            $result['category_name'] = $arr->category_name;
            $result['category_slug'] = $arr->category_slug;
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['category_name'] = '';
            $result['category_slug'] = '';
            $result['id'] = 0;
        }
        return view('admin/manage_category', $result);
    }

    //here we are using the same page for adding and updating category 
    //we can change both pages for simple code.
    public function manageCategoryProcess(Request $request)
    {
        //now validation of data
        //category_Slug should be unique
        $request->validate([
            'category_name' => 'required',
            'category_slug' => 'required | unique:categories,category_slug,'.$request->id,  //unique in category table.
        ]);
    
        if ($request->id > 0) {
            $model = Category::find($request->id);
            $message ="Category Updated";
        } else {
            $model = new Category();
            $message ="Category Inserted";
        }
        $model->category_name = $request->category_name;
        $model->category_slug = $request->category_slug;
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/category');
    }
    public function deleteCategory($id)
    {
        $data = Category::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Category Deleted Successfully');
        return redirect('admin/category');
    }
    public function statusCategory(Request $request, $status , $id ){
        $data = Category::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Category Status Updated');
        return redirect('admin/category');

    }
}
