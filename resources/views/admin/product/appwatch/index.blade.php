@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/table.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Appwatch List</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class=body>
        <h3>Appwatch Lists</h3>
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
                <th><a href="{{route('appwatch.create')}}" style="color:lime"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($appwatch as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->categorydetails->name}}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" alt="" width="50">
                    </td>
                    <td>{{$item->colors->name}}</td>
                    <td>{{$item->sizes->name}}</td>
                    <td>{{$item->capacities->name}}</td>
                    <td>{{$item->price}}$</td>
                    <td>{{$item->quantity}}</td>
                    <th class="option">
                        <form action="{{route('appwatch.destroy',$item->id)}}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fa-solid fa-delete-left"></i>
                            </button>
                        </form>
                        <button><a href="{{route('appwatch.edit',$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a></button>

                    </th>
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
            window.location.href = "{{ route('searchappwatch', ['valuesearch' => 'replacevaluesearch']) }}".replace('replacevaluesearch', valuesearch);
        });
    });
</script>

@endsection