@extends('frontend/layout/layout')
@section('contents')
<section class="order_status order_status_page">
    <h1>Status Order</h1>
    <hr>
    @if(count($status_product)==0)
    <h1 style="line-height:8;text-align:center">No Orders</h1>
    @else
    @foreach($status_product as $items)
    <section class="item">
        <p>Order Date : {{ date('Y-m-d', strtotime($items->created_at)) }}</p>
        <table border="1">
            @php
            $total_status = 0;
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
                $total_status += $item->iphones->price * $item->quantity;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="total" colspan="5">
                        <p>Total : ${{$items->total}}</p>
                        @if($items->discount != '')
                        <p>Discount : {{floor(($total_status-$items->total)/($total_status/100))}}%</p>
                        @else
                        <p>Discount : No</p>
                        @endif
                        <p>Status : {{$items->status }}</p>
                    </td>
                </tr>
            </tfoot>
        </table>

    </section>
    @endforeach
</section>
@endsection
@endif