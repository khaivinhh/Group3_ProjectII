@extends('frontend/layout/layout')
@section('mycss')
@endsection



@section('contents')
<style>
    img {
        max-width: 250px;
        height: auto;
    }

    .review {
        margin-top: 50px;
        display: flex;
    }
</style>
@foreach($macbook->categorydetails->images as $image)
@if($image->colors->id == $macbook->color_id)
<img src="{{asset($image->path)}}" alt="">
@endif
@endforeach

<h1>Name : {{$macbook->categorydetails->name}}</h1>
<h3>Color : {{$macbook->colors->name}}</h3>
<h3>Ram : {{$macbook->rams->name}}</h3>
<h3>Capacity : {{$macbook->capacities->name}}</h3>
<h3>Price : {{$macbook->price}}</h3>
<input class="quantity" type="number" max="{{$macbook->quantity}}">
<button class="addtocart">Add To Cart</button>
<h3>Description : {{$macbook->description}}</h3>


<h1>review</h1>

<div class="review">
    <div class="view_review">@foreach($comments as $item)
        <p>name : {{$item->customers->first_name.' '.$item->customers->last_name}}</p>
        <p>rate : {{$item->rate}}</p>

        <p>{{$item->content}}</p>
        @endforeach
    </div>

    <h1>{{$check}}</h1>
    <div class="write_review">


        <input type="text" id="rate">
        <textarea id="content" id="" cols="30" rows="10"></textarea>
        <button class="addreview">submit</button>
    </div>
</div>


@endsection


@section('myjs')
<script>
    const product_id = "{{$macbook->id}}";
    const category_id = "{{$macbook->categories->id}}";
    const urladditem = "{{route('add_to_cart')}}";
    const urladdreview = "{{route('add_review')}}";

    $(document).ready(function() {
        $('.addtocart').click(function(e) {
            e.preventDefault();
            let quantity = $('.quantity').val();
            $.ajax({
                type: 'post',
                url: urladditem,
                data: {
                    product_id: product_id,
                    quantity: quantity,
                    category_id: category_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert('add to cart successfully !');
                }
            });
        });


        $('.addreview').on('click', function(e) {
            var rate = $('#rate').val();
            var content = $('#content').val();
            $.ajax({
                type: 'post',
                url: urladdreview,
                data: {
                    rate:rate,
                    content:content,
                    product_id: product_id,
                    category_id: category_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert('add review successfully !');
                }
            });
        })
    });
</script>
@endsection