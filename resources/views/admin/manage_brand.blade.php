@extends('admin/layout');
@section('page_title','Manage Brand')
@section('brand_selected','active')
@section('container')

 {{-- for image required on update or delete  --}}
@if ($id > 0)
{{ $image_required = '' }}
@else
<?php $image_required = 'required'; ?>
@endif

{{-- for showing error related to Undefined image extensin --}}

{{-- @error('image')
    <div class="sufee-alert alert with-close alert-danger  alert-dismissible fade show">
        {{$message}} 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>       
    @enderror --}}

    <h1>Manage Brand</h1>
    <div class="md10">
        <a href="{{url('admin/brand')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>

    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('brand.manage_brand_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label mb-1">Enter brand</label>
                            <input id="brand" name="name" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$name}}" required>
                            @error('name')
                                <br>
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Brand Image</label>
                            <input id="image" name="image" type="file" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{ $image }}" {{ $image_required }}>

                            @error('image')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror


                            <a href="{{ asset('storage/media/brand/' . $image) }}" target="_blank"><img width="100px" height="80px" src="{{ asset('storage/media/brand/' . $image) }}" /></a>
                        </div>

                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">

                                <span id="payment-button-amount">Submit</span>
                            </button>
                        </div>
                        <input type="hidden" name="id" value="{{$id}}">
                    </form>


                </div>
            </div>
        @endsection
