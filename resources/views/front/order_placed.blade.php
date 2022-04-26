@extends('front/layout')
@section('page_title', 'Order Placed')
@section('container')
    <!-- product category -->
    <section id="aa-product-category">
        <div class="container">
            <div class="row" style="text-align: center">
                <br><br><br>    

                <h2>Your Order is Been Placed </h2>
                <h2>Order ID :- {{session()->get('ORDER_ID')}}</h2>

                <br><br><br>
            </div>
        </div>
    </section>
@endsection
