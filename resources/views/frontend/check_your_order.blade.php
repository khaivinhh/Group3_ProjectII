@extends('frontend/layout/layout')
@section('contents')

<div class="check_your_order">
    <section class="status_order">
        <h1>Status Order</h1>
        <hr>
        @foreach($status_product as $items)
        <section class="item">
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
                            <p>Date : {{ date('Y-m-d', strtotime($items->created_at)) }}</p>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </section>
        @endforeach
    </section>
    <section class="order_history">
        <h1>Order History</h1>
        <hr>
        @foreach($history_product as $items)
        <section class="item">
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
                            <p>Total : ${{$items->total}}</p>
                            @if($items->discount != '')
                            <p>Discount : {{$items->total/($items->total-$total_history)}}%</p>
                            @else
                            <p>Discount : No</p>
                            @endif
                            <p>Status : {{$items->status }}</p>
                            <p>Date : {{ date('Y-m-d', strtotime($items->created_at)) }}</p>
                            <a href="{{route('re_order',$items->id)}}">Reorder</a>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </section>
        @endforeach
    </section>
</div>

@endsection