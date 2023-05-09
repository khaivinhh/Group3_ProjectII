@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/home.css')}}">
@endsection

@section('contents')

<section class="header">
    <div class="flex1">
        <div class="content">
            <h1>iPhone 14 Pro</h1>
            <h3>Pro.Beyond</h3>
            <div>
                <a href="{{ route('category_detail', [16,1])  }}">Buy</a>
                <a>Learn more <i class="fa-solid fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_iphone.jpg')}}" alt="">
        </div>
    </div>
    <div class="flex2">
        <div class="content">
            <h1>MacBook Pro</h1>
            <h3>Mover.Maker.Boundary breaker.</h3>
            <div>
                <a href="">Buy</a>
                <a>Learn more <i class="fa-solid fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_macbook.jpg')}}" alt="">
        </div>
    </div>
    <div class="flex3">
        <div class="content">
            <h1>appwatch</h1>
            <h4>SERIES 8</h4>
            <h3>A healthy leap ahead.</h3>
            <div>
                <a href="">Buy</a>
                <a>Learn more <i class="fa-solid fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_appwatch.jpg')}}" alt="">
        </div>
    </div>
</section>

<section class="product_new">
    <div>
        <p>New</p>
        <p>iPhone 14</p>
        <h1>Wonderfull.</h1>
        <p>From $799 or $33.29/mo. for 24 mo. before trade‑in2</p>
    </div>
    <div class="content">
        <a href="{{ route('category_detail', [18,1])  }}">Buy</a>
        <a tabindex="0">Learn more <i class="fa-solid fa-chevron-right"></i></a>
    </div>
    <img src="{{asset('images/myimg/frontend/new_product.jpg')}}" alt="">
</section>

<section class="best_sellers">
    <div class="title">
        <h1>Top Rating</h1>
        <p>Discover our top-rated products as rated by our customers.</p>
        <!-- <h1>Best Sellers</h1>
        <p>See what's trending with our customers.</p> -->
    </div>
    <div class="product">
        @foreach($top_rated_products as $item)
        <div class="item">
            <div class="image">
                <a href="{{ route('iphone_detail', $item->iphones->id) }}"><img src="{{asset($item->iphones->image)}}"></a>
            </div>
            <div class="information_product">
                <p class="name">{{$item->iphones->categorydetails->name}}</p>
                <p class="price">${{$item->iphones->price}}</p>
                <div class="rate">
                    <input type="radio" id="star-{{$item->iphones->id}}" name="star-{{$item->iphones->id}}" value="5" checked />
                    <label for="star-{{$item->iphones->id}}"></label>
                    <input type="radio" id="star-{{$item->iphones->id}}" name="star-{{$item->iphones->id}}" value="4" />
                    <label for="star-{{$item->iphones->id}}"></label>
                    <input type="radio" id="star-{{$item->iphones->id}}" name="star-{{$item->iphones->id}}" value="3" />
                    <label for="star-{{$item->iphones->id}}"></label>
                    <input type="radio" id="star-{{$item->iphones->id}}" name="star-{{$item->iphones->id}}" value="2" />
                    <label for="star-{{$item->iphones->id}}"></label>
                    <input type="radio" id="star-{{$item->iphones->id}}" name="star-{{$item->iphones->id}}" value="1" />
                    <label for="star-{{$item->iphones->id}}"></label>
                </div>
                <!-- <p class="rate">{{$item->avg_rate}}</p> -->
            </div>

        </div>

        @endforeach
    </div>
</section>

<section class="all_category">
    <div class="title">
        <h1>All Category</h1>
        <p>Discover something new in our comprehensive list of categories</p>
    </div>


    <!-- <div class="tab">
        <p id="defaultOpen" class="tablinks" onclick="openCity(event,'iphone')">iPhone</p>
        <p class="tablinks" onclick="openCity(event,'macbook')">Macbook</p>
        <p class="tablinks" onclick="openCity(event,'appwatch')">Appwatch</p>
    </div> -->

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
                <a>Learn more <i class="fa-solid fa-chevron-right"></i></a>
            </div>
            <hr>
        </div>
        @endforeach
    </div>

    <div class="category_macbook tabcontent" id="macbook"></div>
    <div class="category_appwatch tabcontent" id="appwatch"></div>
</section>




@endsection

@section('myjs')
<script>
    // function openCity(evt, description_review) {
    //     var i, tabcontent, tablinks;
    //     tabcontent = document.getElementsByClassName("tabcontent");
    //     for (i = 0; i < tabcontent.length; i++) {
    //         tabcontent[i].style.display = "none";
    //     }
    //     tablinks = document.getElementsByClassName("tablinks");
    //     for (i = 0; i < tablinks.length; i++) {
    //         tablinks[i].className = tablinks[i].className.replace(" active", "");
    //     }
    //     document.getElementById(description_review).style.display = "block";
    //     evt.currentTarget.className += " active";
    // }
    // document.getElementById("defaultOpen").click();




    $(document).ready(function() {

        
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

        $('.header').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            // autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
        });
    })
</script>
@endsection