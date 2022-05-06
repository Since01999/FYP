@extends('front/layout')
@section('page_title', 'Order Details')
@section('container')
  <!-- catg header banner section -->
  <section id="aa-catg-head-banner">
    <div class="aa-catg-head-banner-area">
      <div class="container">
      
      </div>
    </div>
   </section>
   <!-- / catg header banner section -->
 
  <!-- Cart view section -->
  <section id="cart-view">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="order_detail">
            <h3>Details Address</h3>
            {{$order_details[0]->name}} <br>
            {{$order_details[0]->mobile}} <br>
            {{$order_details[0]->address}} <br>
            {{$order_details[0]->city}} <br>
            {{$order_details[0]->state}} <br>
            {{$order_details[0]->pincode}} <br>
          </div>
          
        </div>
        <div class="col-md-6">
          <div class="order_detail">
            <h3>Order Details</h3>
            Order Status :  {{$order_details[0]->orders_status}} <br>
            Payment Status :  {{$order_details[0]->payment_status}} <br>
            Payment Type :  {{$order_details[0]->payment_type}} <br>
            Track Details :  {{$order_details[0]->track_details}} <br>
            <?php if($order_details[0]->payment_id != '') 
           echo 'Payment ID :'.$order_details[0]->payment_id.'<br>'
            ?>
          </div>
          
        </div>



        <div class="col-md-12">
          <div class="cart-view-area">
            <div class="cart-view-table">
              <form action="">
                  
                <div class="table-responsive">
                   <table class="table">
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
                        $totalAmt = $totalAmt + ($list->price * $list->qty) ;
                        ?>
                       <tr>
                        <td> {{$list->pname}}</td>   
                        <td><img src="{{asset('storage/media/'. $list->attr_image)}}" alt=""></td>   
                        <td>{{$list->price}}</td>   
                        <td>{{$list->size}}</td>   
                        <td>{{$list->color}}</td>   
                        <td>{{$list->qty}}</td>   
                        <td>{{$list->price * $list->qty}}</td>   
                      
                      </tr>    

                       @endforeach
                       <tr>
                         <td colspan="6"> &nbsp;<b>Amount</b></td>
                         <td colspan="7"><b>{{$totalAmt}}/-</b></td>   
                      
                      </tr> 
                      <?php 
                      if ($order_details[0]->coupon_value > 0) {
                        echo '<tr>
                         <td colspan="6"> &nbsp;<b>Coupon
                          <span class="coupon_apply_txt">('.$order_details[0]->coupon_code.')</span>
                          </b></td>
                         <td colspan="7"><b>'.$order_details[0]->coupon_value.'/-</b></td>   
                      </tr>';
                      $totalAmt = $totalAmt - $order_details[0]->coupon_value;
                      echo '<tr>
                         <td colspan="6"> &nbsp;<b>Total Amount</b></td>
                         <td colspan="7"><b>'.$totalAmt.'/-</b></td>   
                      </tr>';
                      }

                      ?>
                    
                    </tbody>
                   </table>
                 </div>
               
                </form>
              <!-- Cart Total view -->
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Cart view section -->

@endsection
