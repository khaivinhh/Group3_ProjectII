@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<style>
    .flex {
        display: flex;
        justify-content: space-around;
    }
</style>
<h1>checkout page</h1>
<div>
    <form class="flex" action="{{route('place_order')}}">
        <div class="infouser">
            <h1>Billing Details</h1>

            <h3>First_name</h3>
            <input type="text" value="{{$user->first_name}}">
            <h3>Last_name</h3>
            <input type="text" value="{{$user->last_name}}">
            <h3>Email</h3>
            <input type="email" value="{{$user->email}}">
            <h3>Address</h3>
            <input type="text" value="{{$user->address}}" name="address">
            <h3>Phone</h3>
            <input type="text" value="{{$user->phone}}">
        </div>

        <div class="infopro">
            <h1>your order</h1>
            @php
            $total = 0;
            @endphp
            <h3>product</h3>
            @foreach($cart as $item)
            <p>{{$item->product->categorydetails->name}} x {{$item->quantity}} : ${{$item->product->price*$item->quantity}}</p>
            @php
            $total += $item->product->price*$item->quantity;
            @endphp
            @endforeach
            <h2>Total : ${{$total}}</h2>
            <button type="submit">place order</button>
        </div>
    </form>
</div>



@endsection


@section('myjs')
@endsection