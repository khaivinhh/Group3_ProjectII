@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/table.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">

@section('mycss')
@endsection

@section('contents')
<style>
    .confirm {
        float: right;
        border: none;
        background-color: #00a0ff;
        border-radius: 5px
    }
    .confirm a{
        text-decoration: none;
        color:white;
        padding: 10px;
        display: block;
    }
</style>
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Order Detail List</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class=body>
        <h3>Order Detail Lists</h3>
        <hr>
        <table border="1">
            <thead>
                <td>id</td>
                <td>order_id</td>
                <td>category_id</td>
                <td>product_id</td>
                <td>quantity</td>
                <td>price</td>
                <th>action</th>
            </thead>
            <tbody>
                @foreach($orderdetail as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->order_id}}</td>
                    <td>{{$item->categories->name}}</td>
                    <td>{{$item->product_id}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>${{$item->price}}</td>
                    <th>
                        <form action="{{route('orderdetail.destroy',$item->id)}}" method="post" style="display:inline">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fa-solid fa-delete-left"></i>
                            </button>
                        </form>
                    </th>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        <button class="confirm"><a href="{{route('confirm_order',$order_id)}}">confirm</a></button>
    </section>

</div>@endsection

@section('myjs')
@endsection