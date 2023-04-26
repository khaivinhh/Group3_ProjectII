@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/cart.css')}}">

@endsection

@section('contents')
<div class="header_link">
    <a href="">Home</a>
    <span class="arrow">></span>
    <span>Cart</span>
</div>
<h1 class="title">Cart</h1>
<table border="1" class="cart">
    <thead>
        <th colspan="2">PRODUCT</th>
        <th>PRICE</th>
        <th>QUANTITY</th>
        <th>ACTION</th>
        <th>TOTAL</th>

    </thead>
    <tbody>
        <form class="submit_cart" action="{{route('update_cart')}}" method="POST">
            @csrf
            @php
            $total = 0;
            @endphp
            @if(isset($cart))
            @foreach($cart as $index => $item)
            <tr>
                <td>
                    <img src="{{ asset($item->product->image) }}" alt="" width="50">
                </td>
                <td>
                    <p>{{$item->product->categorydetails->name}}</p>
                    <p class="capacity_color">{{$item->product->rams->name}} /{{$item->product->capacitys->name}} / {{$item->product->colors->name}}</p>
                </td>

                <td>${{$item->product->price}}</td>



                <td>
                    <div class="quantity">
                        <span class="subtraction" onclick="subtraction('{{$item->product->id}}','{{$item->product->categorydetail_id}}')">-</span>
                        <input type="text" class="quantity-{{$item->product->id}}-{{$item->product->categorydetail_id}}" value="{{$item->quantity}}" name="qty[]" min="1">
                        <span class="plus" onclick="plus('{{$item->product->id}}','{{$item->product->categorydetail_id}}')">+</span>
                    </div>
                </td>
                <td>
                    <a href="{{route('remove_cart',$index)}}" class="removeitem">x</a>
                </td>

                <td>${{$item->product->price*$item->quantity}}</td>
            </tr>
            @php
            $total += $item->product->price*$item->quantity;
            @endphp
            @endforeach
            @endif
        </form>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                @if(isset($newtotal))
                <h2 class="total">Total Price :${{$newtotal}}</h2>
                @else
                <h2 class="total">Total Price :${{$total}}</h1>
                    @endif
                    <div class="update_cart">
                        <form action="{{route('check_coupon',$total)}}" method="POST">
                            @csrf
                            <input type="text" name="name" placeholder="Enter your coupon code if you have one">
                            <button type="submit">Coupon</button>
                        </form>
                        <button><a href="{{route('checkout')}}">Check Out</a></button>

                        <button class="submit">Update Cart</button>
                    </div>

            </td>
        </tr>
    </tfoot>
</table>






@endsection

@section('myjs')
<script>
    var submit = $('.submit');
    submit.click(function() {
        $('.submit_cart').submit();
    });

    function subtraction(id, categorydetail_id) {
        let quantity = $('.quantity-' + id + '-' + categorydetail_id);
        if (quantity.val() > 1) {
            quantity.val(parseInt(quantity.val()) - 1);
        }
    }



    function plus(id, categorydetail_id) {
        let quantity = $('.quantity-' + id + '-' + categorydetail_id);
        quantity.val(parseInt(quantity.val()) + 1);
    }
</script>
@endsection