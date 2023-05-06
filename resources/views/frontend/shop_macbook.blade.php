@extends('frontend/layout_shop/layout')

@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/shop.css')}}">
@endsection





@section('myjs')
<script>
    
    $('#sort_by').on('change', function() {
        $('.form_sort_by').append('<input type="hidden" name="category" value="1">');
        $('.form_sort_by').submit();
    });

    $('.category_search').val('2');
    
</script>
@endsection