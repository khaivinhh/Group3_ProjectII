@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/checkout.css')}}">

@endsection

@section('contents')

<div class="header_link">
    <a href="">Home</a>
    <span class="arrow">></span>
    <span>Check Out</span>
</div>
<h1 class="title">Check Out</h1>
<div class="order">
    <form class="form" action="{{route('place_order')}}">
        <h3>Billing Details</h1>
            <hr>
            <div class="infouser">

                <div class="f-l-name">
                    <div>
                        <label for="">First name</label><br>
                        <input type="text" value="{{$user->first_name}}">
                    </div>
                    <div>
                        <label for="">Last name</label><br>
                        <input type="text" value="{{$user->last_name}}">
                    </div>
                </div>

                <div>
                    <label for="">Email</label><br>
                    <input type="email" value="{{$user->email}}">
                </div>
                <div>
                    <label for="">Address</label><br>
                    <input type="text" value="{{$user->address}}" name="address">
                </div>
                <div>
                    <label for="">Phone</label><br>
                    <input type="text" value="{{$user->phone}}">
                </div>
            </div>
    </form>
    <div class="infopro">
        <h3>Your Order</h3>
        <hr>
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Total</td>
                </tr>

            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>{{$item->product->categorydetails->name}} x {{$item->quantity}}</td>
                    <td>${{$item->product->price * $item->quantity}}</td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        Total Price :
                    </td>
                </tr>
            </tfoot>
        </table>
        <button type="submit">place order</button>
    </div>
</div>



@endsection


@section('myjs')
@endsection