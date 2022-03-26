@extends('admin/layout');
@section('page_title','Manage Tax')
@section('tax_selected','active')
@section('container')
    <h1>Manage Tax</h1>
    <div class="md10">
        <a href="{{url('admin/tax')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('tax.manage_tax_process') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="tax_value" class="control-label mb-1">Enter Tax Value</label>
                            <input id="tax_value" name="tax_value" type="text" class="form-control"
                                aria-required="true" aria-invalid="false"   value="{{$tax_value}}" required>
                            @error('tax_value')
                                <br>
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                          
                        </div>

                        <div class="form-group">
                            <label for="tax_desc" class="control-label mb-1">Enter Tax Description</label>
                            <textarea id="tax_desc" name="tax_desc" type="text" class="form-control" aria-required="true" aria-invalid="false"
                            required cols="10" rows="3">{{ $tax_desc }}</textarea>
                            @error('tax_desc')
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
                <script>
CKEDITOR.replace('tax_desc')
               </script>
            </div>
         
        @endsection
