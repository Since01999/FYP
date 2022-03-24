@extends('admin/layout');
@section('page_title','Manage Coupon')
@section('coupon_selected','active')
@section('container')
    <h1>Manage Coupon</h1>
    <div class="md10">
        <a href="{{url('admin/coupon')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('coupon.manage_coupon_process') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="control-label mb-1">Coupon Title</label>
                            <input id="title" name="title" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$title}}" required>

                            @error('title')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror

                          
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label mb-1">Coupon Code</label>
                            <input id="code" name="code" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$code}}"  required>

                            @error('code')
                                <br>
                                <div class="alert alert-danger">

                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="value" class="control-label mb-1">Coupon Value</label>
                            <input id="value" name="value" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$value}}"  required>

                            @error('value')
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
