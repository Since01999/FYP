@extends('admin/layout');
@section('page_title', 'Manage Category')
@section('category_selected', 'active')
@section('container')

    <h1>Manage Category</h1>
    <div class="md10">
        <a href="{{ url('admin/category') }}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('category.manage_category_process') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_name" class="control-label mb-1">Category Name</label>
                                    <input id="category_name" name="category_name" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $category_name }}" required>

                                    @error('category_name')
                                        <br>
                                        <div class="alert alert-danger">

                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parent_category_id" class="control-label mb-1">Parent Category </label>
                                    <select id="parent_category_id" name="parent_category_id" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" required>
                                        <option value="0" selected>Select Category</option>
                                        @foreach ($category as $list)
                                            @if ($parent_category_id == $list->id)
                                                <option selected value="{{ $list->id }}">
                                                @else
                                                <option value="{{ $list->id }}">
                                            @endif
                                            {{ $list->category_name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_slug" class="control-label mb-1">Category Slug</label>
                                    <input id="category_slug" name="category_slug" type="text" class="form-control"
                                        aria-required="true" aria-invalid="false" value="{{ $category_slug }}" required>

                                    @error('category_slug')
                                        <br>
                                        <div class="alert alert-danger">

                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_image" class="control-label mb-1">Category Image</label>
                                    <input id="category_image" name="category_image" type="file" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $category_image }}">
                                    @error('category_image')
                                        <br>
                                        <div class="alert alert-danger">
        
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    @if ($category_image != '')
                                    <a href="{{ asset('storage/media/category/' .$category_image) }}"
                                        target="_blank"><img width="50px" height="50px"
                                            src="{{ asset('storage/media/category/' . $category_image) }}" /></a>
                                @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category_image" class="control-label mb-1">Show in Home Page</label>
                                    <input id="is_home" name="is_home" type="checkbox" aria-required="true"
                                        aria-invalid="false" {{$is_home_selected}}>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">

                                <span id="payment-button-amount">Submit</span>
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}">
                    </form>


                </div>
            </div>
        @endsection
