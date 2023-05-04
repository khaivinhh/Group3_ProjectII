@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/purchase_history.css')}}">

@endsection

@section('contents')


<div class="header_link">
    <a href="">Home</a>
    <span class="arrow">></span>
    <span>Purchase History</span>
</div>
<h1 class="title">Purchase History</h1>





@foreach($purchase_history as $items)
    <form action="{{ route('re_order')}}" method="post">
    @csrf
    @foreach($items as $item)
    <img src="{{asset($item->image)}}" width="150">
    <span>{{$item->quantity_product}}</span>
    <input style="display:none" type="text" name="cart_id" value="{{$item->cart_id}}">
    @endforeach
    <button type="submit">Dat Lai</button>
</form>
<hr>
@endforeach





@endsection
@section('myjs')

@endsection