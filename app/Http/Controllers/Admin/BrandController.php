<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $result['is_home'] = $arr->is_home;
            $result['is_home_selected'] = '';
            if($arr->is_home == 1){
                $result['is_home_selected'] = "checked";
            }
            $result['id'] = $arr->id;
        } else {
            //if we dont get the data then we will make two variable
            $result['name'] = '';
            $result['image'] = '';
            $result['is_home_selected'] = '';
            $result['is_home'] = ' ';
            $result['id'] = 0;
        }
        return view('admin/manage_brand', $result);
    }

    //here we are using the same page for adding and updating size 
    //we can change both pages for simple code.
    public function manageBrandProcess(Request $request)
    {
        //now validation of data
        if ($request->id > 0) {
            $image_validate = "mimes:jpg,png,jpeg";
        } else {
            $image_validate = "required|mimes:jpg,png,jpeg";
        }
        $request->validate([
         'name' => 'required | unique:brands,name,'.$request->post('id'), //unique in size table.
         'image' => $image_validate,
        ]);
    
        if ($request->id > 0) {
            $model = Brand::find($request->id);
            $message ="Brand Updated";
        } else {
            $model = new Brand(); 
            $message ="Brand Inserted";
        }

        /*Uploading the Image Start*/
        if ($request->hasFile('image')) {
            if ($request->id > 0){
                $arrImage = DB::table('brands')->where(['id' => $request->id])->get();
                if (Storage::exists('public/media/brand/' . $arrImage[0]->image)) {
                    Storage::delete('public/media/brand/' . $arrImage[0]->image);
                }
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/brand', $image_name);
            $model->image = $image_name;
        }

        /*Uploading the Image End*/

        $model->name = $request->name;
        $model->status = 1;
        $model->is_home = 0;
        if( $request->is_home !==null){
            $model->is_home = 1;
        }
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
