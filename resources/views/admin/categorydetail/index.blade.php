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
                <td>ID</td>
                <td>Category</td>
                <td>Name</td>
                <td>Image</td>
                <th><a href="{{route('categorydetail.create')}}" style="color:lime"><i class="fa-solid fa-plus"></i></a></th>
            </thead>
            <tbody>
                @foreach($categorydetail as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->categories->name}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <img src="{{ asset($item->image) }}" width="50">
                    </td>
                    <td class="action">
                        <form action="{{route('categorydetail.destroy',$item->id)}}" method="post">
                            @csrf
                            @method("DELETE")
                            <button type="submit">
                                <i class="fa-solid fa-delete-left"></i>
                            </button>

                        </form>
                        <button><a href="{{route('categorydetail.edit',$item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a></button>

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
            window.location.href = "{{ route('searchcategorydetail', ['valuesearch' => 'replacevaluesearch']) }}".replace('replacevaluesearch', valuesearch);
        });
    });
</script>
@endsection