@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/table.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Iphone List</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class=body>
        <h3>Iphone Lists</h3>
        <hr>
        <table border="1">
            <thead>
                <td>id</td>
                <td>name</td>
                <td>image</td>
                <td>color</td>
                <td>size</td>
                <td>capacity</td>
                <td>price</td>
                <td>quantity</td>
                <th><a href="{{route('iphone.create')}}" style="color:blue"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($product as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" alt=""  style="max-width:10%; height: auto">
                    </td>
                    <td>{{$item->colors->name}}</td>
                    <td>{{$item->sizes->name}}</td>
                    <td>{{$item->capacitys->name}}</td>
                    <td>{{$item->price}}$</td>
                    <td>{{$item->quantity}}</td>
                    <th>
                        <form action="{{route('iphone.destroy',$item->id)}}" method="post">
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
            <tfoot></tfoot>
        </table>
    </section>

</div>@endsection

@section('myjs')
@endsection