@extends('frontend/layout_shop/layout')

@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/shop.css')}}">
@endsection




@section('product')
<div class="product">
    @foreach($iphones as $item)
    <div class="item">
        <a href="{{ route('iphone_detail', $item->id) }}"><img src="{{asset($item->image)}}" alt=""></a>
        <p class="name_product">{{$item->categorydetails->name}}</p>
        <p class="information_product">{{$item->rams->name}} / {{$item->capacities->name}} / {{$item->colors->name}}</p>
        <h4 class="price_product">${{$item->price}}</h4>
    </div>
    @endforeach
</div>
@endsection



@section('link')
<div class="pagination">
    {{ $iphones->onEachSide(0)->links() }}
</div>
@endsection


@section('myjs')
<script>
    
    $('#sort_by').on('change', function() {
        $('.category_sort').val('1');
        $('.form_sort_by').submit();
    });

    $('.category_search').val('1');
    
</script>
@endsection