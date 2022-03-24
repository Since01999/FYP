@extends('admin/layout');
@section('page_title','Manage Color')
@section('color_selected','active')
@section('container')
    <h1>Manage Color</h1>
    <div class="md10">
        <a href="{{url('admin/color')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('color.manage_color_process') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="color" class="control-label mb-1">Enter Color</label>
                            <input id="color" name="color" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$color}}" required>
                            @error('color')
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
