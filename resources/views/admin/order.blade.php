




@extends('admin/layout');
@section('page_title','Order')
@section('order_selected','active')
@section('container')
   
<h1>Orders</h1>

<div class="row m-t-30">
    <div class="col-md-12">
                <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Details</th>
                        <th>Amount</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Payment Type</th>
                        <th>Order Date</th>
                        {{-- <th>ACTION</th> --}}
                    </tr>
                </thead>
                <tbody>
                    
@foreach ($orders as $item)
                    <tr>
                        <td class="order_detail_txt"><a href="{{url('/admin/order_detail')}}/{{$item->id}}">{{$item->id}}</a></td>
                        <td>
                            {{-- Customer Details --}}
                            {{$item->name}} <br>
                            {{$item->email}} <br>
                            {{$item->mobile}} <br>
                            {{$item->address}} ,{{$item->city}},{{$item->state}},{{$item->pincode}}
                        </td>
                        <td>{{$item->total_amount}}</td>
                        <td>{{$item->orders_status}}</td>
                        <td>{{$item->payment_status}}</td>
                        <td>{{$item->payment_type}}</td>
                        
                        <td>{{$item->added_on}}</td>
                        {{-- <td>
                            <div class="table-data-feature">
                            
                               <a href="tax/manage_tax/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                            </a>
                            &nbsp;
                            @if ($item->status == 1)
                            <a href="tax/status/0/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-badge-check"></i>
                             </button>
                             @elseif($item->status == 0)
                             <a href="tax/status/1/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-alert-triangle"></i>
                             </button> 
                    
                             @endif
                            </a>
                        
                            &nbsp;
                               <a href="tax/delete/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </a>
                               
                            </div>
                        </td> --}}
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>
 

    
@endsection
