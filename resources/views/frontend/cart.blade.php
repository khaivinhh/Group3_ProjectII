@extends('frontend/layout/layout')


@section('contents')
<div class="cart">
    <section class="title">
        <h1>Cart</h1>
        <a href="">Home</a>
        <span>/</span>
        <a href="">Cart</a>
    </section>

    <table border="1">
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
                        <a href="{{route('iphone_detail',$item->product->id)}}"><img src="{{ asset($item->product->image) }}" alt="" width="50"></a>
                    </td>
                    <td>
                        <p>{{$item->product->categorydetails->name}}</p>
                        <p class="capacity_color">{{$item->product->rams->name}} /{{$item->product->capacities->name}} / {{$item->product->colors->name}}</p>
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
                    <h2 class="total">Total Price :${{$total}}</h1>
                        <div class="update_cart">
                            <button><a href="{{route('checkout')}}">Check Out</a></button>
                            <button class="submit">Update Cart</button>
                        </div>

                </td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection