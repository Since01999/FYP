@extends('front/layout')
@section('page_title', 'My Order')
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
        <div class="col-md-12">
          <div class="cart-view-area">
            <div class="cart-view-table">
              <form action="">
                  
                <div class="table-responsive">
                   <table class="table">
                     <thead>
                       <tr>
                         <th>Order ID</th>
                         <th>Order Status</th>
                         <th>Payment Type</th>
                         <th>Total Amount</th>
                         <th>Payment ID</th>
                         <th>Placed At</th>
                       </tr>
                     </thead>
                     <tbody>
                      @foreach($orders as $list)
                      <tr>
                        <td class="order_id_btn"><a href="{{url('order_detail')}}/{{$list->id}}"><b>{{$list->id}}</b></a></td>
                        <td>{{$list->orders_status}}</td>
                        <td>{{$list->payment_type}}</td>
                        <td>{{$list->total_amount}}</td>
                        <td>{{$list->payment_id}}</td>
                        <td>{{$list->added_on}}</td>
                        </tr>    
                            
                    @endforeach
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
