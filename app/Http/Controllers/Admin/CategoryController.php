<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use App\Models\Admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $result['parent_category_id'] = $arr->parent_category_id;
            $result['category_image'] = $arr->category_image;
            $result['is_home'] = $arr->is_home;
            $result['is_home_selected'] = '';
            if($arr->is_home == 1){
                $result['is_home_selected'] = "checked";
            }
            $result['id'] = $arr->id;
            $result['category'] = DB::table('categories')->where(['status' => 1])->where('id', '!=', $id)->get();
            return view('admin/manage_category', $result);
        } else {
            //if we dont get the data then we will make two variable
            $result['category_name'] = '';
            $result['category_slug'] = '';
            $result['parent_category_id'] = '';
            $result['category_image'] = '';
            $result['is_home'] = ' ';
            $result['is_home_selected'] = '';
            $result['id'] = 0;
            $result['category'] = DB::table('categories')->where(['status' => 1])->get();
            return view('admin/manage_category', $result);
        }
    }



    //here we are using the same page for adding and updating category 
    //we can change both pages for simple code.
    public function manageCategoryProcess(Request $request)
    {
        //now validation of data
        //category_Slug should be unique
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'mimes:jpg,png,jpeg',
            'category_slug' => 'required | unique:categories,category_slug,' . $request->id,  //unique in category table.
        ]);

        if ($request->id > 0) {
            $model = Category::find($request->id);
            $message = "Category Updated";
        } else {
            $model = new Category();
            $message = "Category Inserted";
        }
        $model->category_name = $request->category_name;
        $model->category_slug = $request->category_slug;
        $model->parent_category_id = $request->parent_category_id;
        //code for uploading the image
        if ($request->hasFile('category_image')) {
            if ($request->id > 0) {
                $arrImage = DB::table('categories')->where(['id' => $request->id])->get();
                if (Storage::exists('public/media/category/' . $arrImage[0]->category_image)) {
                    Storage::delete('public/media/category/' . $arrImage[0]->category_image);
                }
            }

            $image = $request->file('category_image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/category', $image_name);
            $model->category_image = $image_name;
        }
        $model->is_home = 0;

        if( $request->is_home !==null){
            $model->is_home = 1;
        }
        $model->status = 1;
        $model->save();
        $request->session()->flash('message', $message);
        return redirect('admin/category');
    }
    public function deleteCategory($id)
    {
        $data = Category::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Category Deleted Successfully');
        return redirect('admin/category');
    }
    public function statusCategory(Request $request, $status, $id)
    {
        $data = Category::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Category Status Updated');
        return redirect('admin/category');
    }
}
