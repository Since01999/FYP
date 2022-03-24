@extends('admin/layout');
@section('page_title','Manage Brand')
@section('brand_selected','active')
@section('container')
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

                    <form action="{{ route('brand.manage_brand_process') }}" method="post">
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
