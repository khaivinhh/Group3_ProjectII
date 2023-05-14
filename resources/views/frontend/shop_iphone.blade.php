@extends('frontend/layout_shop/layout')


@section('product')
@if(isset($iphones)  && count($iphones)>0)
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
@else
<h1 class="no_result">No Result</h1>
@endif

@endsection



@section('link')
@if(isset($iphones))
<div class="pagination">
    {{ $iphones->onEachSide(0)->links() }}
</div>
@endif
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