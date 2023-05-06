@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/product_detail.css')}}">
@endsection



@section('contents')
<section class="title">
    <h1>Products</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Products</a>
    <span>/</span>
    <span>{{$iphone->categorydetails->name}}</span>
</section>
<section class="product_detail">
    <div class="image_product">
        @foreach($iphone->categorydetails->images as $image)
        @if($image->colors->id == $iphone->color_id)
            <img src="{{asset($image->path)}}" alt="">
        @endif
        @endforeach
    </div>
    <div class="information">
        <p class="name">{{$iphone->categorydetails->name}}</p>
        <div class="review">
            <div class="rate">
                <input class="star" type="radio" id="star5" name="rate_product" value="5" disabled {{ $star_product > 4.5 ? 'checked' : '' }} />
                <label for="star5" title="text">5 stars</label>
                <input class="star" type="radio" id="star4" name="rate_product" value="4" disabled {{ $star_product < 4.5 && $star_product >= 3.5 ? 'checked' : '' }} />
                <label for="star4" title="text">4 stars</label>
                <input class="star" type="radio" id="star3" name="rate_product" value="3" disabled {{ $star_product < 3.5 && $star_product >= 2.5 ? 'checked' : '' }} />
                <label for="star3" title="text">3 stars</label>
                <input class="star" type="radio" id="star2" name="rate_product" value="2" disabled {{ $star_product < 2.5 && $star_product >= 1.5 ? 'checked' : '' }} />
                <label for="star2" title="text">2 stars</label>
                <input class="star" type="radio" id="star1" name="rate_product" value="1" disabled {{ $star_product < 1.5 && $star_product > 0  ? 'checked' : '' }} />
                <label for="star1" title="text">1 star</label>
            </div>
            <p>{{$count_review_product}} review</p>
        </div>
        <p class="quantity">Availability : <span>{{$iphone->quantity}} in stock</span></p>
        <p class="price">Price : <span>${{$iphone->price}}</span></ơ>
        <p class="color">Color : {{$iphone->colors->name}}</p>
        <p class="ram">Ram : {{$iphone->rams->name}}</p>
        <p class="capacity">Capacity : {{$iphone->capacities->name}}</p>
        <div class="quantity">
            <label for="">Quantity : </label>
            <input class="input_quantity" type="number" max="{{$iphone->quantity}}" value="1" min="1">
        </div>
        <button class="addtocart">Add To Cart</button>
       
    </div>
</section>





<section class="description_review">

    <div class="tab">
        <p id="defaultOpen" class="tablinks" onclick="openCity(event,'description')">Description</p>
        <p class="tablinks" onclick="openCity(event,'review')">Review</p>
    </div>

    <div id="description" class="tabcontent">
        <p class="description">{{$iphone->description}}</p>
    </div>

    <div id="review" class="tabcontent">
        <div class="flex">
            <div class="reviewer">
                @if(count($comments) <= 0) <div class="no_comment">
                    <img src="{{asset('images/myimg/frontend/comment.png')}}" alt="">
                    <h1>No comment</h1>
            </div>
            @else
            @foreach($comments as $item)
            <div class="user_review">
                <div class="img_user_review">
                    <div>
                        <img src="{{asset($item->customers->image)}}" alt="" width="100%">

                    </div>
                </div>

                <div class="rate_content_user">
                    <p>{{$item->customers->first_name.' '.$item->customers->last_name}}</p>
                    <div class="rate">
                        <input class="star" type="radio" id="star5" name="rate_user-{{$item->customers->id}}" value="5" disabled {{ $item->rate == 5 ? 'checked' : '' }} />
                        <label for="star5" title="text">5 stars</label>
                        <input class="star" type="radio" id="star4" name="rate_user-{{$item->customers->id}}" value="4" disabled {{ $item->rate == 4 ? 'checked' : '' }} />
                        <label for="star4" title="text">4 stars</label>
                        <input class="star" type="radio" id="star3" name="rate_user-{{$item->customers->id}}" value="3" disabled {{ $item->rate == 3 ? 'checked' : '' }} />
                        <label for="star3" title="text">3 stars</label>
                        <input class="star" type="radio" id="star2" name="rate_user-{{$item->customers->id}}" value="2" disabled {{ $item->rate == 2 ? 'checked' : '' }} />
                        <label for="star2" title="text">2 stars</label>
                        <input class="star" type="radio" id="star1" name="rate_user-{{$item->customers->id}}" value="1" disabled {{ $item->rate == 1 ? 'checked' : '' }} />
                        <label for="star1" title="text">1 star</label>
                    </div>
                    <p class="content">{{$item->content}}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @if($write_review == 'true')
        <div class="write_review">
            <p class="title">Add Your Review</p>
            <p>Name : {{$name_user}}</p>
            <div class="flex">
                <p>Your Rating : </p>
                <div class="rate">
                    @if(isset($star_user))
                    <input class="submit_rate" type="radio" id="star_5" name="aa" value="5" {{ $star_user == 5 ? 'checked' : '' }} />
                    <label for="star_5">5 stars</label>
                    <input class="submit_rate" type="radio" id="star_4" name="aa" value="4" {{ $star_user == 4 ? 'checked' : '' }} />
                    <label for="star_4">4 stars</label>
                    <input class="submit_rate" type="radio" id="star_3" name="aa" value="3" {{ $star_user == 3 ? 'checked' : '' }} />
                    <label for="star_3">3 stars</label>
                    <input class="submit_rate" type="radio" id="star_2" name="aa" value="2" {{ $star_user == 2 ? 'checked' : '' }} />
                    <label for="star_2">2 stars</label>
                    <input class="submit_rate" type="radio" id="star_1" name="aa" value="1" {{ $star_user == 1 ? 'checked' : '' }} />
                    <label for="star_1">1 star</label>
                    @else
                    <input class="submit_rate" type="radio" id="star_5" name="aa" value="5" />
                    <label for="star_5">5 stars</label>
                    <input class="submit_rate" type="radio" id="star_4" name="aa" value="4" />
                    <label for="star_4">4 stars</label>
                    <input class="submit_rate" type="radio" id="star_3" name="aa" value="3" />
                    <label for="star_3">3 stars</label>
                    <input class="submit_rate" type="radio" id="star_2" name="aa" value="2" />
                    <label for="star_2">2 stars</label>
                    <input class="submit_rate" type="radio" id="star_1" name="aa" value="1" />
                    <label for="star_1">1 star</label>
                    @endif
                </div>
            </div>
            <label for="content">Message</label>
            <textarea id="content" id="" cols="30" rows="10">@if(isset($content_user)){{$content_user}}@endif</textarea>
            <button class="addreview">Submit</button>
        </div>

        @endif
    </div>
    </div>
</section>

<section class="product_relate">
    <h1 class="">Product Relate</h1>
    <div class="slick_product_relate">
        @foreach($products_relate as $item)
        <div class="item">
            <a href="{{ route('iphone_detail', $item->id) }}"><img src="{{asset($item->image)}}" alt=""></a>
            <p class="name_product">{{$item->categorydetails->name}}</p>
            <p class="information_product">{{$item->rams->name}} / {{$item->capacities->name}} / {{$item->colors->name}}</p>
            <h4 class="price_product">${{$item->price}}</h4>
            <button><a href="{{ route('iphone_detail', $item->id) }}">Buy</a></button>
        </div>
        @endforeach
    </div>
</section>


@endsection


@section('myjs')
<script>
    const product_id = "{{$iphone->id}}";
    const category_id = "{{$iphone->categories->id}}";
    const urladditem = "{{route('add_to_cart')}}";
    const urladdreview = "{{route('add_review')}}";


    function openCity(evt, description_review) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(description_review).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpen").click();






    $(document).ready(function() {

        $('.image_product').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: true,
        })
        $('.slick_product_relate').slick({
            slidesToShow: 4,
            slidesToScroll: 2,
            // autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            dots: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ]

        })

        $('.addtocart').click(function(e) {
            e.preventDefault();
            let quantity = $('.input_quantity').val();
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
                    alert('Add To Cart Successfully!');
                }
            });
        });



        var rate_submit = 0;
        $('.submit_rate').each(function() {
            if ($(this).is(":checked")) {
                rate_submit = $(this).val();
            }
        });
        $('.submit_rate').on('click', function() {
            if ($(this).prop('checked')) {
                rate_submit = $(this).val();
            }
        });



        $('.addreview').on('click', function(e) {
            var content = $('#content').val();
            $.ajax({
                type: 'post',
                url: urladdreview,
                data: {
                    rate: rate_submit,
                    content: content,
                    product_id: product_id,
                    category_id: category_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert('Add Review Successfully!');
                }
            });
        })

    });
</script>
@endsection