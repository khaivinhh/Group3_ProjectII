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
                <td>ram</td>
                <td>capacity</td>
                <td>price</td>
                <td>quantity</td>
                <th><a href="{{route('iphone.create')}}" style="color:lime"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($iphone as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->categorydetails->name}}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" alt="" width="50">
                    </td>
                    <td>{{$item->colors->name}}</td>
                    <td>{{$item->rams->name}}</td>
                    <td>{{$item->capacities->name}}</td>
                    <td>{{$item->price}}$</td>
                    <td>{{$item->quantity}}</td>
                    <td class="action">
                        <form action="{{route('iphone.destroy',$item->id)}}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fa-solid fa-delete-left"></i>
                            </button>
                        </form>
                        <button><a href="{{route('iphone.edit',$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a></button>

                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    </section>

</div>@endsection

@section('myjs')
<script>
    $(document).ready(function() {
        $('.btn-search').on('click', function() {
            var valuesearch = $('.valuesearch').val();
            window.location.href = "{{ route('searchiphone', ['valuesearch' => 'replacevaluesearch']) }}".replace('replacevaluesearch', valuesearch);
        });
    });
</script>
@endsection