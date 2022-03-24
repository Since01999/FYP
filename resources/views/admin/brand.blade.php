@extends('admin/layout');
@section('page_title','Brand')
@section('brand_selected','active')
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
<h1>Brands</h1>
<div class="md10">
    <a href="{{url('admin/brand/manage_brand')}}">
<button type="button" class="btn btn-success">Add Brand</button>
</a>
</div>
<div class="row m-t-30">
    <div class="col-md-12">
                <!-- DATA TABLE-->
        <div class="table-responsive m-b-40">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand</th>
                        <th>Image</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    
@foreach ($data as $item)


                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->image}}</td>
                      
                        <td>
                            <div class="table-data-feature">
                            
                               <a href="brand/manage_brand/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                            </a>
                            &nbsp;
                            @if ($item->status == 1)
                            <a href="brand/status/0/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-badge-check"></i>
                             </button>
                             @elseif($item->status == 0)
                             <a href="brand/status/1/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                <i class="zmdi zmdi-alert-triangle"></i>
                             </button> 
                    
                             @endif
                            </a>
                        
                            &nbsp;
                               <a href="branf/delete/{{$item->id}}"> <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </a>
                               
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
