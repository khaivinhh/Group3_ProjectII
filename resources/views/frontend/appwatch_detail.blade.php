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
@foreach($appwatch->categorydetails->images as $image)
@if($image->colors->id == $appwatch->color_id)
<img src="{{asset($image->path)}}" alt="">
@endif
@endforeach

<h1>Name : {{$appwatch->categorydetails->name}}</h1>
<h3>Color : {{$appwatch->colors->name}}</h3>
<h3>Size : {{$appwatch->sizes->name}}</h3>
<h3>Capacity : {{$appwatch->capacitys->name}}</h3>
<h3>Price : {{$appwatch->price}}</h3>
<input class="quantity" type="number" max="{{$appwatch->quantity}}">
<button class="addtocart">Add To Cart</button>
<h3>Description : {{$appwatch->description}}</h3>


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
    const product_id = "{{$appwatch->id}}";
    const category_id = "{{$appwatch->categories->id}}";
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