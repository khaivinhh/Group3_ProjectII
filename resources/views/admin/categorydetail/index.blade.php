@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/table.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Category List</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class=body>
        <h3>Category Lists</h3>
        <hr>
        <table border="1">
            <thead>
                <td>id</td>
                <td>category</td>
                <td>name</td>
                <td>image</td>
                <th><a href="{{route('categorydetail.create')}}" style="color:blue"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($categorydetail as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->categories->name}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" style="max-width: 10%; height: auto;">
                    </td>
                    <th>
                        <form action="{{route('categorydetail.destroy',$item->id)}}" method="post">
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