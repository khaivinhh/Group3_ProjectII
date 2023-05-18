@extends('frontend/layout/layout')
@section('contents')
<section class="order_history order_history_page">
    <h1>Order History</h1>
    <hr>
    @if(!isset($history_product))
    <h1 style="line-height:8;text-align:center">No Orders</h1>
    @else
    @foreach($history_product as $items)
    <section class="item">
        <p>Date : {{ date('Y-m-d', strtotime($items->updated_at)) }}</p>
        <table border="1">
            @php
            $total_history = 0;
            @endphp
            <thead>
                <tr>
                    <th colspan="2">Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items->orderdetails as $item)
                <tr>
                    <td><a href="{{route('iphone_detail',$item->iphones->id)}}"><img src="{{asset($item->iphones->image)}}" alt="" width="50"></a></td>
                    <td class="information_product">
                        <p>{{$item->iphones->categorydetails->name}}</p>
                        <p>{{$item->iphones->rams->name}}/{{$item->iphones->capacities->name}}/{{$item->iphones->colors->name}}</p>
                    </td>
                    <td>${{$item->iphones->price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>${{$item->iphones->price * $item->quantity }}</td>
                </tr>
                @php
                $total_history += $item->iphones->price * $item->quantity;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="total" colspan="5">
                        @if($items->discount_value != '')
                        <p>Discount : {{$items->discount_value}}%</p>
                        @else
                        <p>Discount : No</p>
                        @endif
                        <p>Transport Fee : {{$items->transport_fee}}$</p>
                        <p>Total : ${{$items->total}}</p>
                        <a href="{{route('re_order',$items->id)}}">Reorder</a>

                    </td>
                </tr>
            </tfoot>
        </table>
    </section>
    @endforeach
</section>
@endsection
@endif