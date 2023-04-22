@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<style>
    img {
        max-width: 250px;
        height: auto;
    }

    .product {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }
</style>
<h1>shop page</h1>
<div class="product">

    @foreach($iphone as $item)
    <div class="item" onclick="submitForm('{{$item->id}}','{{$item->category_id}}')">
    <form id="form-{{ $item->id.'_'.$item->category_id }}" action="{{ route('iphone_detail', $item->id) }}" method="GET">
            <img src="{{asset($item->image)}}" alt="">
            <h1>{{$item->categorydetails->name}}</h1>
            <h1>{{$item->price}}</h1>
        </form>
    </div>
    @endforeach

    @foreach($macbook as $item)
    <div class="item" onclick="submitForm('{{$item->id}}','{{$item->category_id}}')">
        <form id="form-{{ $item->id.'_'.$item->category_id }}" action="{{ route('macbook_detail', $item->id) }}" method="GET">
            <img src="{{asset($item->image)}}" alt="">
            <h1>{{$item->categorydetails->name}}</h1>
            <h1>{{$item->price}}</h1>
        </form>
    </div>
    @endforeach
    @foreach($appwatch as $item)
    <div class="item" onclick="submitForm('{{$item->id}}','{{$item->category_id}}')">
        <form id="form-{{ $item->id.'_'.$item->category_id }}" action="{{ route('macbook_detail', $item->id) }}" method="GET">
            <img src="{{asset($item->image)}}" alt="">
            <h1>{{$item->categorydetails->name}}</h1>
            <h1>{{$item->price}}</h1>
        </form>
    </div>
    @endforeach

    

</div>
@endsection

@section('myjs')
<script>
    function submitForm(itemId, itemCate) {
        document.getElementById("form-" + itemId + '_' + itemCate).submit();
    }
</script>

@endsection