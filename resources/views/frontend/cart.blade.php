@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<h1>cart page</h1>
<form action="{{route('update_cart')}}" method="POST">
    @csrf
    <table>
        <thead>
            <th>img</th>
            <th>name</th>
            <th>color</th>
            <th>capacity</th>
            <th>quantity</th>
            <th>price</th>
            <th>action</th>
            <th>total</th>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp
            @if(isset($cart))
            @foreach($cart as $item)
            <tr>
                <td>
                    <img src="{{ asset($item->product->image) }}" alt="" width="50" height="50">
                </td>
                <td>{{$item->product->categorydetails->name}}</td>
                <td>{{$item->product->colors->name}}</td>
                <td>{{$item->product->capacitys->name}}</td>



                <td><input type="number" value="{{$item->quantity}}" name="qty[]"></td>
                <td>{{$item->product->price}}</td>
                <td>
                    <button type="submit"><a href="{{route('remove_cart',$loop->index)}}">Delete</a></button>
                </td>

                <td>{{$item->product->price*$item->quantity}}</td>
            </tr>
            @php
            $total += $item->product->price*$item->quantity;
            @endphp
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <h3>Total : {{$total}}</h3>
                </td>
            </tr>
        </tfoot>
    </table>
    <button type="submit">update cart</button>
    <button><a href="{{route('checkout')}}">Check Out</a></button>
</form>


@endsection

@section('myjs')

@endsection