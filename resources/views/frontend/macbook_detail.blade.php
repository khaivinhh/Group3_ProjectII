@extends('frontend/layout/layout')
@section('mycss')
@endsection



@section('contents')
<style>
    img {
        max-width: 250px;
        height: auto;
    }
</style>
@foreach($iphone->categorydetails->images as $image)
@if($image->colors->id == $iphone->color_id)
<img src="{{asset($image->path)}}" alt="">
@endif
@endforeach

<h1>Name : {{$iphone->name}}</h1>
<h3>Color : {{$iphone->colors->name}}</h3>
<h3>Ram : {{$iphone->rams->name}}</h3>
<h3>Capacity : {{$iphone->capacitys->name}}</h3>
<h3>Price : {{$iphone->price}}</h3>
<input class="quantity" type="number" max="{{$iphone->quantity}}">
<button class="addtocart">Add To Cart</button>

@endsection


@section('myjs')
<script>
    const id = "{{$iphone->id}}";
    const categoryname = "{{$iphone->categories->name}}";
    const urladd = "{{route('add_to_cart')}}";
    $(document).ready(function() {
        $('.addtocart').click(function(e) {
            e.preventDefault();
            let quantity = $('.quantity').val();
            $.ajax({
                type: 'post',
                url: urladd,
                data: {
                    id: id,
                    quantity: quantity,
                    categoryname: categoryname,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert('add to cart successfully !');

                }
            });


        });
    });
</script>
@endsection