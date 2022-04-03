<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeBannerController extends Controller
{
    public function index()
    {
        $data = HomeBanner::all();
        return view("admin.homebanner", compact('data'));
    }
    public function manageHomeBanner(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = HomeBanner::where(['id'=>$id])->get();
            $result['image'] = $arr['0']->image;
            $result['btn_text'] = $arr['0']->btn_text;
            $result['btn_link'] = $arr['0']->btn_link;
            $result['id'] = $arr['0']->id;

        } else {
            //if we dont get the data then we will make two variable
            $result['image'] = '';
            $result['btn_text'] = '';
             $result['btn_link'] = '';
             $result['id'] = '';
        }
        return view('admin/manage_homebanner', $result);
    }

    //here we are using the same page for adding and updating size 
    //we can change both pages for simple code.
    public function manageHomeBannerProcess(Request $request)
    {
        //now validation of data
        if ($request->id > 0) {
            $image_validate = "mimes:jpg,png,jpeg";
        } else {
            $image_validate = "required|mimes:jpg,png,jpeg";
        }
        $request->validate([
             'image' => $image_validate,
        ]);
    
        if ($request->id > 0) {
            $model = HomeBanner::find($request->id);
            $message ="HomeBanner Updated";
        } else {
            $model = new HomeBanner(); 
            $message ="HomeBanner Inserted";
        }

        /*Uploading the Image Start*/
        if ($request->hasFile('image')) {
            if ($request->id > 0){
                $arrImage = DB::table('home_banners')->where(['id' => $request->id])->get();
                if (Storage::exists('public/media/homebanner/' . $arrImage[0]->image)) {
                    Storage::delete('public/media/homebanner/' . $arrImage[0]->image);
                }
            }
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media/homebanner', $image_name);
            $model->image = $image_name;
        }

        /*Uploading the Image End*/

        $model->btn_text = $request->btn_text;
        $model->btn_link = $request->btn_link;
        $model->status = 1;
        $model->save();
        $request->session()->flash('message',$message);
        return redirect('admin/homebanner');
    }
    public function deleteHomeBanner($id)
    {
        $data = HomeBanner::findOrfail($id);
        $data->delete();
        session()->flash('message', 'HomeBanner Deleted Successfully');
        return redirect('admin/homebanner');
    }
    public function statusHomeBanner(Request $request, $status , $id ){
        $data = HomeBanner::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'HomeBanner Status Updated');
        return redirect('admin/homebanner');

    }
}
