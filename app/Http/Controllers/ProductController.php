<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return view("admin.product", compact('data'));
    }
    public function manageProduct(Request $request, $id = '')
    {
        if ($id > 0) {
            $arr = Product::FindOrFail($id);
            $result['category_id'] = $arr->category_id;
            $result['name'] = $arr->name;
            $result['image'] = $arr->image;
            $result['slug'] = $arr->slug;
            $result['brand'] = $arr->brand;
            $result['model'] = $arr->model;
            $result['short_desc'] = $arr->short_desc;
            $result['desc'] = $arr->desc;
            $result['keywords'] = $arr->keywords;
            $result['technical_specification'] = $arr->technical_specification;
            $result['uses'] = $arr->uses;
            $result['warranty'] = $arr->warranty;
            //here advance feature related to the product management
            $result['lead_time'] = $arr->lead_time;
            $result['tax'] = $arr->tax;
            $result['tax_type'] = $arr->tax_type;
            $result['is_promo'] = $arr->is_promo;
            $result['is_featured'] = $arr->is_featured;
            $result['is_discounted'] = $arr->is_discounted;
            $result['is_trending'] = $arr->is_trending;

            //here the normal code related to product management

            $result['status'] = $arr->warranty;
            $result['id'] = $arr->id;

            $result['productAttrArr'] = DB::table('products_attr')->where(['products_id' => $id])->get();
            $productImagesArr = DB::table('products_images')->where(['products_id' => $id])->get();

            if (!isset($productImagesArr)) {
                $result['productImagesArr'][0]['id'] = '';
                $result['productImagesArr'][0]['images'] = '';
            } else {
                $result['productImagesArr'] = $productImagesArr;
            }
        } else {
            //if we dont get the data then we will make two variable 
            //this code will be executed in case if we not updating the data or we are just adding the data for the first time.
            $result['category_id'] = '';
            $result['name'] = '';
            $result['image'] = '';
            $result['slug'] = '';
            $result['brand'] = '';
            $result['model'] = '';
            $result['short_desc'] = '';
            $result['desc'] = '';
            $result['keywords'] = '';
            $result['technical_specification'] = '';
            $result['uses'] = '';
            $result['warranty'] = '';
            $result['lead_time'] = ' ';
            $result['tax'] = ' ';
            $result['tax_type'] = ' ';
            $result['is_promo'] = ' ';
            $result['is_featured'] = ' ';
            $result['is_discounted'] = ' ';
            $result['is_trending'] = ' ';
            $result['status'] = '';
            $result['id'] = 0;
            $result['productAttrArr'][0]['id'] = '';
            $result['productAttrArr'][0]['products_id'] = '';
            $result['productAttrArr'][0]['sku']         = '';
            $result['productAttrArr'][0]['attr_image']  = '';
            $result['productAttrArr'][0]['mrp']         = '';
            $result['productAttrArr'][0]['qty']         = '';
            $result['productAttrArr'][0]['price']       = '';
            $result['productAttrArr'][0]['size_id']     = '';
            $result['productAttrArr'][0]['color_id']    = '';
            $result['productImagesArr'][0]['id'] = '';
            $result['productImagesArr'][0]['images'] = '';
        }

        $result['category'] = DB::table('categories')->where(['status' => 1])->get();
        $result['sizes'] = DB::table('sizes')->where(['status' => 1])->get();
        $result['colors'] = DB::table('colors')->where(['status' => 1])->get();
        $result['brands'] = DB::table('brands')->where(['status' => 1])->get();

        return view('admin/manage_product', $result);
    }

    //here we are using the same page for adding and updating Product 
    //we can change both pages for simple code.
    public function manageProductProcess(Request $request)
    {

        /*Testing code Starts */

        // echo "<pre>";
        // print_r($request->post());
        // die();

        /*Testing code Ends */
        /* ifelse for validating the image */
        if ($request->id > 0) {
            $image_validate = "mimes:jpg,png,jpeg";
        } else {
            $image_validate = "required|mimes:jpg,png,jpeg";
        }
        //now validation of data
        //Product_Slug should be unique
        $request->validate([
            'name' => 'required',
            'image' => $image_validate,
            'slug' => 'required | unique:products,slug,' . $request->id,  //unique in Product table.
            'attr_image.*.image' => 'mimes: jpg,jpeg,png',
            'pro_image.*.image' => 'mimes: jpg,jpeg,png'
        ]);

        $attr_id = $request->post('pro_attr_id');
        $skuArr = $request->sku;
        $mrpArr = $request->mrp;
        $priceArr = $request->price;
        $qtyArr = $request->qty;
        $size_idArr = $request->size_id;
        $color_idArr = $request->color_id;
        foreach ($skuArr as $key => $val) {
            $check = DB::table('products_attr')->where('sku', '=', $skuArr[$key])->where('id', '!=', $attr_id[$key])->get();

            if (isset($check[0])) {
                $request->session()->flash('sku_error', $skuArr[$key] . 'SKU already Used');
                return redirect(request()->headers->get('referer'));
            }
        }

        if ($request->id > 0) {
            $model = Product::find($request->id);
            $message = "Product Updated";
        } else {
            $model = new Product();
            $message = "Product Inserted";
        }
        //code for uploading the image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->extension();
            $image_name = time() . '.' . $ext;
            $image->storeAs('/public/media', $image_name);
            $model->image = $image_name;
        }
        $model->category_id = $request->category_id;
        $model->name = $request->name;
        $model->slug = $request->slug;
        $model->brand = $request->brand;
        $model->model = $request->model;
        $model->short_desc = $request->short_desc;
        $model->desc = $request->desc;
        $model->keywords = $request->keywords;
        $model->technical_specification = $request->technical_specification;
        $model->uses = $request->uses;
        $model->warranty = $request->warranty;
        //advance features related to the product management
        $model->lead_time = $request->lead_time;
        $model->tax = $request->tax;
        $model->tax_type = $request->tax_type;
        $model->is_promo = $request->is_promo;
        $model->is_featured = $request->is_featured;
        $model->is_discounted = $request->is_discounted;
        $model->is_trending = $request->is_trending;

        //heres the normal code for the product management

        $model->status = 1;
        $model->save();
        $pid = $model->id;

        /*Product Attr Start*/
        foreach ($skuArr as $key => $val) {
            $productAttrArr['products_id'] = $pid;
            $productAttrArr['sku'] = $skuArr[$key];

            $productAttrArr['mrp'] =(int)$mrpArr[$key];
            $productAttrArr['price'] =(int)$priceArr[$key];
            $productAttrArr['qty'] = (int)$qtyArr[$key];
            if (isset($color_idArr[$key])) {
                $productAttrArr['color_id'] = $color_idArr[$key];
            } else {
                $productAttrArr['color_id'] = 0;
            }
            if (isset($size_idArr[$key])) {
                $productAttrArr['size_id'] = $size_idArr[$key];
            } else {
                $productAttrArr['size_id'] = 0;
            }

            //condition for uplaoding the attr image

            // $productAttrArr['attr_image'] = 'test';

            if ($request->hasFile("attr_image.$key")) {
                $rand = rand('111111111', '9999999999');
                $attr_image = $request->file("attr_image.$key");
                $ext = $attr_image->extension();
                $image_name = $rand . '.' . $ext;
                $attr_image->storeAs('/public/media', $image_name);
                $productAttrArr['attr_image'] = $image_name;
            } else {
                $productAttrArr['attr_image'] = ' ';
            }
            if ($attr_id[$key] != "") {
                DB::table('products_attr')->where(['id' => $attr_id[$key]])->update($productAttrArr);
            } else {
                DB::table('products_attr')->insert($productAttrArr);
            }
        }

        /*Product Attr End*/

        /* Product Images Start */
        $pro_image_id = $request->post('pro_image_id');
        foreach ($pro_image_id as $key => $val) {
            $productImageArr['products_id'] = $pid;
            if ($request->hasFile("images.$key")) {
                $rand = rand('111111111', '9999999999');
                $images = $request->file("images.$key");
                $ext = $images->extension();
                $image_name = $rand . '.' . $ext;
                $request->file("images.$key")->storeAs('/public/media', $image_name);
                $productImageArr['images'] = $image_name;

                if ($pro_image_id[$key] != "") {
                    DB::table('products_images')->where(['id' => $pro_image_id[$key]])->update($productImageArr);
                } else {
                    DB::table('products_images')->insert($productImageArr);
                }
            } 
            else {
                $productImageArr['images'] = ' ';
            }
         
        }
        /* Product Images End */
        $request->session()->flash('message', $message);
        return redirect('admin/product');
    }
    public function deleteProduct($id)
    {
        $data = Product::findOrfail($id);
        $data->delete();
        session()->flash('message', 'Product Deleted Successfully');
        return redirect('admin/product');
    }
    //deleting the product attributes 
    public function product_attr_delete($pro_attr_id, $pro_id)
    {
        DB::table('products_attr')->where(['id' => $pro_attr_id])->delete();
        return redirect('admin/product/manage_product/' . $pro_id);
    }

    //product images delete 
    public function product_images_delete($pro_image_id, $pro_id)
    {
        DB::table('products_images')->where(['id' => $pro_image_id])->delete();
        return redirect('admin/product/manage_product/' . $pro_id);
    }
    public function statusProduct(Request $request, $status, $id)
    {
        $data = Product::findOrfail($id);
        $data->status = $status;
        $data->save();
        session()->flash('message', 'Product Status Updated');
        return redirect('admin/product');
    }
}
