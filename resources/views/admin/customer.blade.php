@extends('admin/layout');
@section('page_title','Customer')
@section('customer_selected','active')
@section('container')
<div class="alert-success">
    <div class="alert-success">
        @if(session()->has('message'))
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
          {{session('message')}} 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>       
      @endif
    </div>         
  </div>
<h1>Customers</h1>
<div class="md10">
</div>
<div class="row m-t-30">
    <div class="col-md-12">
                <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>City</th>
                        {{-- <th>Password</th>
                        <th>Address</th>
                       
                        <th>State</th>
                        <th>Zip</th>
                        <th>Company</th>
                        <th>GST IN</th>
                        <th>STATUS</th> --}}
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
@foreach ($data as $item)


                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                         <td>{{$item->mobile}}</td>
                         <td>{{$item->city}}</td>
                        {{--<td>{{$item->password}}</td>
                        <td>{{$item->address}}</td>
                        
                        <td>{{$item->state}}</td>
                        <td>{{$item->zip}}</td>
                        <td>{{$item->company}}</td>
                        <td>{{$item->gstin}}</td>
                        <td>{{$item->status}}</td> --}}
                        <td>
                            <div class="table-data-feature">
                            
                               <a href="customer/show/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                    <i class="fa fa-user"></i>
                                </button>
                            </a>
                            &nbsp;
                            @if ($item->status == 1)
                            <a href="customer/status/0/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-badge-check"></i>
                             </button>
                             @elseif($item->status == 0)
                             <a href="customer/status/1/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-alert-triangle"></i>
                             </button> 
                    
                             @endif
                            </a>
                        
                            &nbsp;
                            
                            </div>
                        </td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>
 

    
@endsection
