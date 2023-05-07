@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/category_iphone_detail.css')}}">
@endsection



@section('contents')
<section class="title">
    <h1>Category</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Category</a>
    <span>/</span>
    <span>{{$categorydetail->name}}</span>
</section>

<section class="category_product">
    <div class="image_product">

    </div>


    <div class="information_product">
        <p class="name">{{$categorydetail->name}}</p>

        <p class="name_color">Color</p>
        <div class="colors">
            @foreach($categorydetail->iphones->unique('color_id') as $item)
            <input type="radio" class="color" id="{{$item->colors->name}}" name="color" value="{{ $item->colors->id }}" />
            <label for="{{$item->colors->name}}" title="text" style="background-color:{{$item->colors->code}}"></label>
            @endforeach
        </div>

        <p class="name_capacity">Storage</p>
        <div class="capacities">
            @foreach($categorydetail->iphones->unique('capacity_id') as $item)
            <input type="radio" class="capacity" id="{{$item->capacities->name}}" name="capacity" value="{{$item->capacities->id}}" />
            <label for="{{$item->capacities->name}}" title="text">
                <span>{{$item->capacities->name}}</span>
                <span class="price">${{$item->price}}</span>
            </label>
            @endforeach
        </div>


        <button class="addtocart" disabled>Add To Cart</button>

    </div>

</section>

<section class="discription">
    <h1>Introduction</h1>
    <p>{{$categorydetail->description}}</p>
</section>


<secsion class="all_category">
    <div class="title">
        <h1>Which iPhone is right for you?</h1>
    </div>
    <div class="category_iphone tabcontent" id="iphone">
        @foreach($categorydetails as $item)
        <div class="item">
            <a href="{{ route('category_detail', [$item->id , $item->category_id])  }}"><img src="{{ asset($item->image) }}"></a>
            <div class="color">
                @foreach($item->images->unique('color_id') as $image)
                <p style="background-color:{{$image->colors->code}}"></p>
                @endforeach
            </div>
            <p class="name">{{$item->name}}</p>
            <p class="price">From ${{$item->iphones[0]->price}}*</p>
            <div class="buy">
                <a href="{{ route('category_detail', [$item->id , $item->category_id])  }}">Buy</a>
                <a href="">Learn more <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <hr>
        </div>
        @endforeach
    </div>
</secsion>


@endsection


@section('myjs')
<script>
    $(document).ready(function() {
        var images = @json($categorydetail -> images);

        var colors = document.querySelectorAll('.color');

        function generateImageHtml() {
            var container = '';
            $.each(images, function(index, value) {
                if (value.color_id == colors[0].value) {
                    var imagePath = "{{ asset(':path') }}".replace(':path', value.path);
                    container += '<img src="' + imagePath + '" alt="">';
                }
            });
            return container;
        }
        $('.image_product').html(generateImageHtml());


        color = '';
        $('.color').on('click', function() {
            var value_color = this.value;
            color = this.value;
            var i = 1;
            var y = 1;
            var name_color = this.id;
            $('.name_color').text('Color - ' + name_color.toString());
            $.each(images, function(index, value) {
                if (value.color_id == value_color) {
                    var imagePath = "{{ asset(':path') }}".replace(':path', value.path);
                    $('.image_product img').eq(i).attr('src', imagePath);
                    if (i == 3) {
                        $('.image_product img').eq(y).prev().attr('src', imagePath);
                    }
                    $('.image_product img').eq(i).next().next().next().attr('src', imagePath)
                    i++;
                    name_color = value.name;
                }
            });
            check_addtocart();
        });

        var capacity = '';
        $('.capacity').on('click', function() {
            capacity = this.value;
            check_addtocart();
        });


        function check_addtocart() {
            if (color != '' && capacity != '') {
                $('.addtocart').removeAttr('disabled');
                $('.addtocart').css('background-color', '#5d5dff');
            }
        }



        const urladd = "{{route('add_to_cart')}}";
        $('.addtocart').click(function(e) {
            e.preventDefault();
            let quantity = 1;
            let category_id = "{{$categorydetail->categories->id}}";
            let categorydetail_id = "{{$categorydetail->id}}";


            $.ajax({
                type: 'post',
                url: urladd,
                data: {
                    quantity: quantity,
                    category_id: category_id,
                    categorydetail_id: categorydetail_id,
                    color: color,
                    capacity: capacity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.text-2').text(data.notification);
                    $('.count_cart').text(data.count_cart)
                    notification_complete();

                }
            });

        });



        $('.category_iphone').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            // autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
            dots: false,
            responsive: [{
                    breakpoint: 1100,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
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

        $('.image_product').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            dots: true,
        });

    });
</script>
@endsection