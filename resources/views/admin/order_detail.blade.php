@extends('admin/layout');
@section('page_title', 'Order Detail')
@section('order_selected', 'active')
@section('container')

    <h1>Orders - {{ $order_details[0]->id }}</h1>

    <div class="row m-t-30 whitebg">
        <div class="row">
            <div class="col-md-6">
                <div class="order_detail">
                    <h3>Details Address</h3>
                    {{ $order_details[0]->name }} <br>
                    {{ $order_details[0]->mobile }} <br>
                    {{ $order_details[0]->address }} <br>
                    {{ $order_details[0]->city }} <br>
                    {{ $order_details[0]->state }} <br>
                    {{ $order_details[0]->pincode }} <br>
                </div>

            </div>
            <div class="col-md-6">
                <div class="order_detail">
                    <h3>Order Details</h3>
                    Order Status : {{ $order_details[0]->orders_status }} <br>
                    Payment Status : {{ $order_details[0]->payment_status }} <br>
                    Payment Type : {{ $order_details[0]->payment_type }} <br>
                    <?php if ($order_details[0]->payment_id != '') {
                        echo 'Payment ID :' . $order_details[0]->payment_id . '<br>';
                    }
                    ?>
                </div>

            </div>

            <div class="col-md-12">
                <div class="cart-view-area">
                    <div class="cart-view-table">

                        <div class="table-responsive">
                            <table class="table  table-bordered order_detail">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>Total</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalAmt = 0;
                                    ?>
                                    @foreach ($order_details as $list)
                                        <?php
                                        $totalAmt = $totalAmt + $list->price * $list->qty;
                                        ?>
                                        <tr>
                                            <td> {{ $list->pname }}</td>
                                            <td><img src="{{ asset('storage/media/' . $list->attr_image) }}" alt=""></td>
                                            <td>{{ $list->price }}</td>
                                            <td>{{ $list->size }}</td>
                                            <td>{{ $list->color }}</td>
                                            <td>{{ $list->qty }}</td>
                                            <td>{{ $list->price * $list->qty }}</td>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"> &nbsp;<b>Amount</b></td>
                                        <td colspan="7"><b>{{ $totalAmt }}/-</b></td>

                                    </tr>
                                    <?php
                                    if ($order_details[0]->coupon_value > 0) {
                                        echo '<tr>
                                                             <td colspan="6"> &nbsp;<b>Coupon
                                                              <span class="coupon_apply_txt">(' .
                                            $order_details[0]->coupon_code .
                                            ')</span>
                                                              </b></td>
                                                             <td colspan="7"><b>' .
                                            $order_details[0]->coupon_value .
                                            '/-</b></td>   
                                                          </tr>';
                                        $totalAmt = $totalAmt - $order_details[0]->coupon_value;
                                        echo '<tr>
                                                             <td colspan="6"> &nbsp;<b>Total Amount</b></td>
                                                             <td colspan="7"><b>' .
                                            $totalAmt .
                                            '/-</b></td>   
                                                          </tr>';
                                    }
                                    
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Total view -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="order_operation">

        <h4>Update Order Status</h4>
        <div class="main_select_div">
            <select name="" id="order_status" class="form-control" onchange="update_order_status({{$order_details[0]->id}})">
                <?php   
                 foreach($order_status as $list){
 
                     //here we are getting data in the form of the array ($list) so we need some additional code    
                    if( $order_details[0]->order_status == $list->id){
                     echo "<option value='".$list->id."' selected>".$list->orders_status."</option>";
                    }else{
                     echo "<option value='".$list->id."'>".$list->orders_status."</option>";   
                    }
                 }
                 ?>
                 
             </select>
    </div>
    <h4>Update Payment Status</h4>
    <div class="main_select_div">
    <select name="" id="payment_status" class="form-control" onchange="update_payment_status({{$order_details[0]->id}})">
       <?php   

        foreach($payment_status as $list){
           if( $order_details[0]->payment_status == $list){
            echo "<option value='$list' selected>$list</option>";
           }else{
            echo "<option value='$list'>$list</option>";   
           }
        }
        ?>
        
    </select>
</div>
    <h4>Track Details</h4>
    <form method="post">
        <textarea name="track_details" id="track_details" class="form-control" cols="3" rows="3" required>{{$order_details[0]->track_details}}</textarea>
        <br>
        <button type="submit"  class="btn btn-info">Update Tracking</button>
        @csrf
    </form>

    </div>
@endsection
