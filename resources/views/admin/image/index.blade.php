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
                <td>category</td>
                <td>color</td>
                <td>img</td>
                <th><a href="{{route('image.create')}}" style="color:blue"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($image as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->categorydetails->name}}</td>
                    <td>{{$item->colors->name}}</td>
                    <td>
                        <img src="{{asset($item->path)}}" alt="" style="max-width:10%; height: auto">
                    </td>
                    <th>
                        <form action="{{route('image.destroy',$item->id)}}" method="post">
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