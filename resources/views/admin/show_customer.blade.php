@extends('admin/layout');
@section('page_title', 'Customer Details')
@section('customer_selected', 'active')
@section('container')

    <h1>Customers Details</h1>
    <div class="md10">
        <a href="{{url('admin/customer')}}">
            <button type="button" class="btn btn-success">Back</button>
        </a>
    </div>
    <div class="md10">
    </div>
    <div class="row m-t-30">
        <div class="col-md-10">
            <!-- DATA TABLE-->
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><b>Name</b></td>
                            <td>{{ $show_customer_list->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>{{ $show_customer_list->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Moile</b></td>
                            <td>{{ $show_customer_list->mobile }}</td>
                        </tr>
                        <tr>
                            <td><b>Password</b></td>
                            <td>{{ $show_customer_list->password }}</td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>{{ $show_customer_list->address }}</td>
                        </tr>
                        <tr>
                            <td><b>City</b></td>
                            <td>{{ $show_customer_list->city }}</td>
                        </tr>
                        <tr>
                            <td><b>State</b></td>
                            <td>{{ $show_customer_list->state }}</td>
                        </tr>
                        <tr>
                            <td><b>Zip Code</b></td>
                            <td>{{ $show_customer_list->zip }}</td>
                        </tr>
                        <tr>
                            <td><b>Company</b></td>
                            <td>{{ $show_customer_list->company }}</td>
                        </tr>
                        <tr>
                            <td><b>GST Number</b></td>
                            <td>{{ $show_customer_list->gstin }}</td>
                        </tr>
                        <tr>
                            <td><b>Added On</b></td>
                            <td>{{ \Carbon\Carbon::parse($show_customer_list->created_at)->format('d-m-Y h:i') }}</td>
                        </tr>
                        <tr>
                            <td><b>Updated On</b></td>
                            <td>{{ \Carbon\Carbon::parse($show_customer_list->updated_at)->format('d-m-Y h:i') }}</td>
                        </tr>


                    </tbody>
                </table>
            </div>
            <!-- END DATA TABLE-->
        </div>
    </div>



@endsection
