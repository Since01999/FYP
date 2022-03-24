@extends('admin/layout');
@section('page_title', 'Manage Product')
@section('product_selected', 'active')
@section('container')

    @if ($id > 0)
        {{ $image_required = '' }}
    @else
        <?php $image_required = 'required'; ?>
    @endif
    <h1>Manage Product</h1>

    @if (session()->has('sku_error'))
        <div class="sufee-alert alert with-close alert-danger  alert-dismissible fade show">
            {{ session('sku_error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    {{-- error for attribute image --}}
    @error('attr_image.*.image')
        <div class="sufee-alert alert with-close alert-danger  alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @enderror
    {{-- error for Multiple image --}}
    @error('pro_image.*.image')
        <div class="sufee-alert alert with-close alert-danger  alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @enderror


    <div class="md10">
        <a href="{{ url('admin/product') }}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
        {{-- adding cke editor and initializing path in layout.blade --}}
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('product.manage_product_process') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name" class="control-label mb-1">Product Name</label>
                            <input id="name" name="name" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $name }}" required>

                            @error('name')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror


                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label mb-1">Product Slug</label>
                            <input id="slug" name="slug" type="text" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $slug }}" required>

                            @error('slug')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Product Image</label>
                            <input id="image" name="image" type="file" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $image }}" {{ $image_required }}>

                            @error('image')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="category" class="control-label mb-1">Category </label>

                                    <select id="category_id" name="category_id" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" required>
                                        <option value="" selected>Select Category</option>
                                        @foreach ($category as $list)
                                            @if ($category_id == $list->id)
                                                <option selected value="{{ $list->id }}">
                                                @else
                                                <option value="{{ $list->id }}">
                                            @endif
                                            {{ $list->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="brand" class="control-label mb-1"> Brand</label>

                                    <select id="brand" name="brand" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" required>
                                        <option value="" selected>Select Brand</option>
                                        @foreach ($brands as $list)
                                            @if ($brand == $list->id)
                                                <option selected value="{{ $list->id }}">
                                                @else
                                                <option value="{{ $list->id }}">
                                            @endif
                                            {{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="model" class="control-label mb-1">Model</label>
                                    <input id="model" name="model" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $model }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="short_desc" class="control-label mb-1">Short Description</label>
                            <textarea id="short_desc" name="short_desc" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                required cols="10" rows="3">{{ $short_desc }}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="desc" class="control-label mb-1">Description</label>
                            <textarea id="desc" name="desc" type="text" class="form-control" aria-required="true" aria-invalid="false" required
                                cols="10" rows="3">{{ $desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="keywords" class="control-label mb-1">Keywords</label>
                            <textarea id="keywords" name="keywords" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                required cols="10" rows="3">{{ $keywords }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="uses" class="control-label mb-1">Product Uses</label>
                            <textarea id="uses" name="uses" type="text" class="form-control" aria-required="true" aria-invalid="false" required
                                cols="10" rows="3">{{ $uses }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="technical_specification" class="control-label mb-1">Technical Specifications</label>
                            <textarea id="technical_specification" name="technical_specification" type="text" class="form-control"
                                aria-required="true" aria-invalid="false" required cols="10"
                                rows="3">{{ $technical_specification }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="warranty" class="control-label mb-1">Warranty</label>
                            <textarea id="warranty" name="warranty" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                required cols="10" rows="3">{{ $warranty }}</textarea>
                        </div>

                        {{-- from here we are adding additional features related to the product managemnet --}}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="model" class="control-label mb-1">Lead Time</label>
                                    <input id="lead_time" name="lead_time" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $lead_time }}">

                                </div>
                                <div class="col-md-4">
                                    <label for="model" class="control-label mb-1">Tax</label>
                                    <input id="tax" name="tax" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $tax }}">

                                </div>
                                <div class="col-md-4">
                                    <label for="model" class="control-label mb-1">Tax Type</label>
                                    <input id="tax_type" name="tax_type" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $tax_type }}">

                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="model" class="control-label mb-1">Is Promo</label>
                                    <select id="is_promo" name="is_promo" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($is_promo == '1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                       @else
                                     <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                @endif
                                </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="model" class="control-label mb-1">Is Featured</label>
                                    <select id="is_featured" name="is_featured" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($is_featured == '1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                       @else
                                     <option value="1">Yes</option>
                                    <option value="0"  selected>No</option>
                                @endif
                                </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="model" class="control-label mb-1">Is Discounted</label>
                                    <select id="is_discounted" name="is_discounted" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($is_discounted == '1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                       @else
                                     <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                @endif
                                </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="model" class="control-label mb-1">Is Trending</label>
                                    <select id="is_trending" name="is_trending" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($is_trending == '1')
                                    <option value="1" selected>Yes</option>
                                    <option value="0" >No</option>
                                       @else
                                     <option value="1">Yes</option>
                                    <option value="0"  selected>No</option>
                                @endif
                                </select>
                                </div>
                            </div>
                        </div>

                        {{-- product Images started --}}
                        <h2 class="md10">Product Images</h2>
                        <div id="">
                            <div class="card md10">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="row md10" id="product_images_box">

                                            <?php $loop_count_num = 1;
                                            ?>
                                            @foreach ($productImagesArr as $key => $val)
                                                {{-- now here we will use type casting in order to convert object into array --}}
                                                <?php
                                                $loop_count_prev = $loop_count_num;
                                                $pIArr = (array) $val;
                                                
                                                ?>
                                                <input id="pro_image_id" name="pro_image_id[]" type="hidden"
                                                    class="form-control" value="{{ $pIArr['id'] }}" multiple>



                                                <div class="col-md-4 product_images_{{ $loop_count_num++ }}">
                                                    <label for="images" class="control-label mb-1">Images</label>
                                                    <input id="images" name="images[]" type="file" class="form-control"
                                                        aria-required="true" aria-invalid="false" multiple>

                                                    @if ($pIArr['images'] != '')
                                                        <a href="{{ asset('storage/media/' . $pIArr['images']) }}"
                                                            target="_blank"><img width="50px" height="50px"
                                                                src="{{ asset('storage/media/' . $pIArr['images']) }}" /></a>
                                                    @endif
                                                </div>
                                                <div class="col-md-2 col-sm">
                                                    @if ($loop_count_num == 2)
                                                        <label for=""
                                                            class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label>
                                                        <button type="button" onclick="add_image_more()"
                                                            class="btn btn-success">
                                                            <i class="fa fa-plus"></i>&nbsp;Add</button>
                                                    @else
                                                        <div class="col-md-2 col-sm"><label for="mrp"
                                                                class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label>
                                                            <a
                                                                href="{{ url('admin/product_images_delete/') }}/{{ $pIArr['id'] }}/{{ $id }}">
                                                                <button type="button" class="btn btn-danger">
                                                                    <i class="fa fa-minus"></i>&nbsp; Remove</button></a>
                                                        </div>';
                                                    @endif

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        {{-- product Images End --}}











                        {{-- product Attributes started --}}
                        <h2 class="md10">Product Attributes</h2>
                        <div id="product_attr_box">
                            <?php $loop_count_num = 1;
                            ?>
                            @foreach ($productAttrArr as $key => $val)
                                {{-- now here we will use type casting in order to convert object into array --}}
                                <?php
                                $loop_count_prev = $loop_count_num;
                                $pAArr = (array) $val;
                                
                                ?>

                                <input id="pro_attr_id" name="pro_attr_id[]" type="hidden" class="form-control"
                                    value="{{ $pAArr['id'] }}" multiple>

                                <div class="card md10" id="product_attr_{{ $loop_count_num++ }}">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row md10">
                                                <div class="col-md-2">
                                                    <label for="price" class="control-label mb-1">Price</label>
                                                    <input id="price" name="price[]" type="text" class="form-control"
                                                        aria-required="true" aria-invalid="false"
                                                        value="{{ $pAArr['price'] }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="mrp" class="control-label mb-1">MRP</label>
                                                    <input id="mrp" name="mrp[]" type="text" class="form-control"
                                                        aria-required="true" aria-invalid="false"
                                                        value="{{ $pAArr['mrp'] }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="sku" class="control-label mb-1">SKU</label>
                                                    <input id="sku" name="sku[]" type="text" class="form-control"
                                                        aria-required="true" aria-invalid="false"
                                                        value="{{ $pAArr['sku'] }}" required>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="sizes" class="control-label mb-1">Size</label>
                                                    <select id="size_id" name="size_id[]" type="text" class="form-control"
                                                        aria-required="true" aria-invalid="false">
                                                        <option value="" selected>Select</option>
                                                        @foreach ($sizes as $list)
                                                            @if ($pAArr['size_id'] == $list->id)
                                                                <option value="{{ $list->id }}" selected>
                                                                    {{ $list->size }} </option>
                                                            @else
                                                                <option value="{{ $list->id }}">
                                                                    {{ $list->size }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="colors" class="control-label mb-1">Color</label>
                                                    <select id="color_id" name="color_id[]" type="text"
                                                        class="form-control" aria-required="true" aria-invalid="false">
                                                        <option value="" selected>Select</option>
                                                        @foreach ($colors as $list)
                                                            @if ($pAArr['color_id'] == $list->id)
                                                                <option value="{{ $list->id }}" selected>
                                                                    {{ $list->color }} </option>
                                                            @else
                                                                <option value="{{ $list->id }}">
                                                                    {{ $list->color }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="qty" class="control-label mb-1">Quantity</label>
                                                    <input id="qty" name="qty[]" type="text" class="form-control"
                                                        aria-required="true" aria-invalid="false"
                                                        value="{{ $pAArr['qty'] }}" required>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="attr_image" class="control-label mb-1">Images</label>
                                                    <input id="attr_image" name="attr_image[]" type="file"
                                                        class="form-control" aria-required="true" aria-invalid="false">
                                                    @if ($pAArr['attr_image'] != '')
                                                        <img width="50px" height="50px"
                                                            src="{{ asset('storage/media/' . $pAArr['attr_image']) }}" />
                                                    @endif
                                                </div>
                                                <div class="col-md-2 col-sm">
                                                    @if ($loop_count_num == 2)
                                                        <label for="mrp"
                                                            class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label>
                                                        <button type="button" onclick="add_more()" class="btn btn-success">
                                                            <i class="fa fa-plus"></i>&nbsp;Add</button>
                                                    @else
                                                        <div class="col-md-2 col-sm"><label for="mrp"
                                                                class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label>
                                                            <a
                                                                href="{{ url('admin/product_attr_delete/') }}/{{ $pAArr['id'] }}/{{ $id }}">
                                                                <button type="button" class="btn btn-danger">
                                                                    <i class="fa fa-minus"></i>&nbsp;
                                                                    Remove</button></a>
                                                        </div>';
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- product Attributes End --}}
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">Submit</span>
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}">

                    </form>
                </div>

            </div>
            <script>
                var loop_count = 1;

                function add_more() {
                    loop_count++;
                    var html =
                        '<input id="pro_attr_id" name="pro_attr_id[]" type="hidden" class="form-control"><div class="card md10" id="product_attr_' +
                        loop_count + '"><div class="card-body"><div class="form-group"><div class="row md10">';
                    html +=
                        '<div class="col-md-2"><label for="price" class="control-label mb-1">Price</label><input id="price" name="price[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
                    html +=
                        '<div class="col-md-2"><label for="mrp" class="control-label mb-1">MRP</label><input id="mrp" name="mrp[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
                    html +=
                        '<div class="col-md-2"><label for="sku" class="control-label mb-1">SKU</label><input id="sku" name="sku[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
                    var size_id_html = jQuery('#size_id').html();
                    size_id_html = size_id_html.replace("selected", " ");
                    html +=
                        '<div class="col-md-3"><label for="size_id" class="control-label mb-1">Size</label> <select id="size_id" name="size_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false">' +
                        size_id_html + '</select></div>';
                    var color_id_html = jQuery('#color_id').html();
                    color_id_html = color_id_html.replace("selected", " ");
                    html +=
                        '<div class="col-md-3"><label for="color_id" class="control-label mb-1">Color</label> <select id="color_id" name="color_id[]" type="text" class="form-control" aria-required="true" aria-invalid="false">' +
                        color_id_html + '</select></div>';
                    html +=
                        '<div class="col-md-3"><label for="qty" class="control-label mb-1">Quantity</label><input id="qty" name="qty[]" type="text" class="form-control" aria-required="true" aria-invalid="false" required></div>';
                    html +=
                        '<div class="col-md-4"><label for="attr_image" class="control-label mb-1">Image</label><input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" required></div>';
                    html +=
                        ' <div class="col-md-2 col-sm"><label for="mrp" class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label><button type="button" onclick=remove_more("' +
                        loop_count + '") class="btn btn-danger"><i class="fa fa-minus"></i>&nbsp; Remove</button> </div>';
                    html += '</div></div></div></div>';
                    jQuery('#product_attr_box').append(html);
                }

                function remove_more(loop_count) {
                    jQuery('#product_attr_' + loop_count).remove();
                }
                loop_image_count = 1;

                function add_image_more() {
                    loop_image_count++;
                    var html =
                        '<input id="pro_image_id" name="pro_image_id[]" type="hidden" class="form-control" multiple><div class="col-md-4 product_images_' +
                        loop_image_count +
                        '" ><label for="images" class="control-label mb-1">Image</label><input id="images" name="images[]" type="file" class="form-control" aria-required="true" aria-invalid="false" multiple></div>';
                    html += ' <div class="col-md-2 col-sm product_images_' + loop_image_count +
                        '"><label for="" class="control-label mb-1">&nbsp;&nbsp;&nbsp;Action</label><button type="button" onclick=remove_image_more("' +
                        loop_image_count + '") class="btn btn-danger"><i class="fa fa-minus"></i>&nbsp; Remove</button> </div>';
                    jQuery('#product_images_box').append(html);

                }

                function remove_image_more(loop_image_count) {
                    // '.' because here we are using the class 
                    jQuery('.product_images_' + loop_image_count).remove();
                }
                //  you can add it anywhere according to the name of the input field
                CKEDITOR.replace('short_desc');
                CKEDITOR.replace('desc');
                CKEDITOR.replace('technical_specification');
            </script>

        @endsection
