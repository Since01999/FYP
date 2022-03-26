@extends('admin/layout');
@section('page_title', 'Manage Coupon')
@section('coupon_selected', 'active')
@section('container')
    <h1>Manage Coupon</h1>
    <div class="md10">
        <a href="{{ url('admin/coupon') }}">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="title" class="control-label mb-1">Coupon Title</label>
                                    <input id="title" name="title" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $title }}" required>
                                    @error('title')
                                        <br>
                                        <div class="alert alert-danger">

                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="code" class="control-label mb-1">Coupon Code</label>
                                    <input id="code" name="code" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $code }}" required>

                                    @error('code')
                                        <br>
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-6">
                                    <label for="value" class="control-label mb-1">Coupon Value</label>
                                    <input id="value" name="value" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{ $value }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="type" class="control-label mb-1">Type</label>
                                    <select id="type" name="type" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($type == 'Value')

                                    {{-- the values in the value field should be same as in the database --}}
                                    <option value="Value" selected>Value</option>
                                    <option value="Percentage" >Percentage</option>
                                    @elseif(($type == 'Percentage'))
                                     <option value="Value">Value</option>
                                    <option value="Percentage"  selected>Percentage</option>
                                    @else
                                    <option value="Value">Value</option>
                                    <option value="Percentage">Percentage</option>
                                    @endif
                                </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="min_order_amt" class="control-label mb-1">Minimum Order Amount</label>
                                    <input id="min_order_amt" name="min_order_amt" type="text" class="form-control" aria-required="true"
                                        aria-invalid="false" value="{{$min_order_amt}}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="is_one_time" class="control-label mb-1">Is One Time</label>
                                    <select id="is_one_time" name="is_one_time" type="text" class="form-control" aria-required="true"
                                    aria-invalid="false" required> 
                                    @if($is_one_time == '1')
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
