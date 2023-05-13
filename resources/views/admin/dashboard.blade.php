@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/dashboard.css')}}">

@section('mycss')
@endsection
@section('contents')
<div class="wrapper">
    <!-- <header>
        <h1>Dashboard</h1>
    </header> -->
    <h1>Dashboard</h1>

    <section class="columns">

        <div class="column">
            <div class="icon">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div class="content">
                <h2>1024</h2>
                <p>New Order</p>
            </div>
        </div>

        <div class="column">
            <div class="icon">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="content">
                <h2>1520</h2>
                <p>Visitors</p>
            </div>
        </div>

        <div class="column">
            <div class="icon">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
            <div class="content">
                @php
                $total = 0;
                @endphp
                @foreach($orders as $item)
                @php
                $total += $item->total;
                @endphp
                @endforeach
                <h2>${{$total}}</h2>
                <p>Total Sales</p>
            </div>
        </div>

    </section>




    <section class="recent">
        <div class="column recent_orders">
            <h2>Recent Orders</h2>
            <table>
                <thead>
                    <tr>
                        <td>User</td>
                        <td>Date</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $item)
                    <tr>
                        <td>
                            <div class="name_image_user">
                                <img src="{{asset($item->customers->image)}}" alt="" width="50" height="50" style="border-radius:50%">
                                <p>{{$item->customers->first_name.' '.$item->customers->last_name}}</p>
                            </div>
                        </td>
                        <td>{{ date('Y-m-d', strtotime($item->date)) }}</td>
                        <td class="status">
                            @if($item->status == 'complete')
                            <p class="complete">{{$item->status}}</p>
                            @else
                            <p class="process">{{$item->status}}</p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
        <div class="column recent_customers">
            <h2>Recent Customers</h2>
            @foreach($customers as $item)
            <div class="item">
                <img src="{{asset($item->image)}}">
                <div>
                    <p>{{$item->first_name.' '.$item->last_name}}</p>
                    <p>{{$item->address}}</p>
                </div>
            </div>
            @endforeach
        </div>

    </section>

</div>

@endsection