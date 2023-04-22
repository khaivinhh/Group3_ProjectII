@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/table.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Image List</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class=body>
        <h3>Image Lists</h3>
        <hr>
        <table border="1">
            <thead>
                <td>id</td>
                <td>customer_id</td>
                <td>image</td>
                <td>address</td>
                <td>date</td>
                <td>status</td>
                <td>total</td>
                <th>action</th>
            </thead>
            <tbody>
                @foreach($order as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->customer_id}}</td>
                    <td><img src="{{asset($item->image)}}" alt="" width="50" height="50" style="border-radius:50%"></td>
                    <td>{{$item->address}}</td>
                    <td>{{$item->date}}</td>
                    <td>{{$item->status}}</td>
                    <td>${{$item->total}}</td>
                    <th>
                        <form action="{{route('order.destroy',$item->id)}}" method="post" style="display:inline">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fa-solid fa-delete-left"></i>
                            </button>
                        </form>
                        <button><a href="{{route('order.show',$item->id)}}"  style="color:blue"><i class="fa-solid fa-circle-info"></i></a></button>
                    </th>
                </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    </section>

</div>@endsection

@section('myjs')
@endsection