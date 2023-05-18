@extends('frontend/layout/layout')
@section('contents')
<section class="title">
    <h1>Products</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Products</a>
</section>

<section class="sort_by">
    <div class="open_option btn_open_option">
        <button class="icon_filter">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <span>Filter</span>
    </div>
    <div>
        <label for="">Sort by :</label>
        <form action="{{route('sort_by')}}" class="form_sort_by">
            <input type="hidden" name="category" class="category_sort">

            <select name="sort_by" id="sort_by">
                <option value="">Select</option>
                <option value="1">Alphabetically, A-Z</option>
                <option value="2">Alphabetically, Z-A</option>
                <option value="3">Price, low to high</option>
                <option value="4">Price, high to low</option>
                <option value="5">Date, new to old</option>
                <option value="6">Date, old to new</option>
            </select>
        </form>
    </div>

</section>
<section class="shop">
    <div class="option">
        <i class="fa-solid fa-xmark btn_close_option"></i>

        <button class="accordion">Categories</button>
        <div class="panel">
            <a href="{{route('shop',1)}}">Apple iPhone ({{$count_iphone}})</a>
        </div>

        <button class="accordion">Custom Menu</button>
        <div class="panel">
            <a href="{{route('home')}}">Home</a>
            <a href="{{route('contact')}}">Contact</a>
            <a href="{{route('cart')}}">Cart</a>
            <a href="{{route('about')}}">About</a>
        </div>

        <button class="accordion">Price</button>
        <div class="panel">
            <form action="{{route('search_price')}}" class="form_search_price">
                <input type="hidden" name="category" class="category_search">
                <div class="from">
                    <label for="from">From</label><br>
                    <input type="text" name="from" id="from">
                </div>
                <div class="to">
                    <label for="to">To</label><br>
                    <input type="text" name="to" id="to">
                </div>
                <button class="search_price filter">Filter</button>
                </formc>
        </div>
        <img class="img_option" src="{{asset('images/myimg/frontend/shop.webp')}}">
    </div>


    @yield('product')
</section>
@yield('link')
@endsection

