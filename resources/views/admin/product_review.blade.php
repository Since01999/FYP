@extends('admin/layout');
@section('page_title', 'Product Review')
@section('product_review_selected', 'active')
@section('container')
    <div class="alert-success">
        <div class="alert-success">
            @if (session()->has('message'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <h1>Product Review</h1>

    <div class="row m-t-30">
        <div class="col-md-12">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User </th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Added On</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($product_review as $item)
                            <tr>
                                <td>{{ $item->id}}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->pname }}</td>
                                <td>{{ $item->rating }}</td>
                                <td>{{ $item->review }}</td>
                                <td>{{ getCustomDate($item->added_on)}}</td>
                                <td>
                                    <div class="table-data-feature">


                                        </a>
                                        &nbsp;
                                        @if ($item->status == 1)
                                            <a href="update_product_review_status/0/{{ $item->id }}"> <button class="item"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="Delete">
                                                    <i class="zmdi zmdi-badge-check"></i>
                                                </button>
                                            @elseif($item->status == 0)
                                                <a href="update_product_review_status/1/{{ $item->id }}"> <button class="item"
                                                        data-toggle="tooltip" data-placement="top" title=""
                                                        data-original-title="Delete">
                                                        <i class="zmdi zmdi-alert-triangle"></i>
                                                    </button>
                                        @endif
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
