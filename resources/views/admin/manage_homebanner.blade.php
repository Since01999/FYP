@extends('admin/layout');
@section('page_title','Manage Home Banner')
@section('home_banner_selected','active')
@section('container')


{{-- for showing error related to Undefined image extensin --}}

{{-- @error('image')
    <div class="sufee-alert alert with-close alert-danger  alert-dismissible fade show">
        {{$message}} 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>       
    @enderror --}}

    <h1>Manage Home Banner</h1>
    <div class="md10">
        <a href="{{url('admin/homebanner')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>

    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('homebanner.manage_homebanner_process') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                        <div class="form-group">
                            <label for="btn_text" class="control-label mb-1">Enter Button Text</label>
                            <input id="btn_text" name="btn_text" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$btn_text}}">
                          
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="btn_link" class="control-label mb-1">Enter Button Link</label>
                            <input id="btn_link" name="btn_link" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$btn_link}}">
                           
                        </div>
                    </div>
                    </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-1">Home Banner</label>
                            <input id="image" name="image" type="file" class="form-control" aria-required="true"
                                aria-invalid="false" value="{{$image}}">
                            @error('image')
                                <br>
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if ($image != '')
                            <a href="{{ asset('storage/media/homebanner/'.$image) }}" target="_blank"><img width="100px" height="80px" src="{{ asset('storage/media/homebanner/'.$image) }}" /></a>
                        @endif
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
