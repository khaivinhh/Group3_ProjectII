@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/home.css')}}">

@endsection

@section('contents')

<div class="header filtering">
    <div class="flex1">
        <div class="content">
            <h1>iPhone 14 Pro</h1>
            <h3>Pro.Beyond</h3>
            <div>
                <a href="">Learn more ></a>
                <a href="">Buy ></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_iphone.jpg')}}" alt="" width="750">
        </div>
    </div>
    <div class="flex2">
        <div class="content">
            <h1>MacBook Pro</h1>
            <h3>Mover.Maker.Boundary breaker.</h3>
            <div>
                <a href="">Learn more ></a>
                <a href="">Buy ></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_macbook.jpg')}}" alt="" width="750">
        </div>
    </div>
    <div class="flex3">
        <div class="content">
            <h1>appwatch</h1>
            <h4>SERIES 8</h4>
            <h3>A healthy leap ahead.</h3>
            <div>
                <a href="">Learn more ></a>
                <a href="">Buy ></a>
            </div>
        </div>
        <div class="image">
            <img src="{{asset('images/myimg/frontend/header_appwatch.jpg')}}" alt="">
        </div>
    </div>
</div>
<h1>PRODUCT CATEGORIES</h1>
<div class="category">
    @foreach($categorydetail as $item)
    <div class="item" onclick="submitForm('{{$item->id}}')">
        <form id="form-{{$item->id}}" action="{{ route('category_detail', [$item->id , $item->category_id])  }}" method="GET">
            <img src="{{ asset($item->image) }}" alt="" width="50" height="50">
            <h1>{{$item->name}}</h1>
        </form>
    </div>
    @endforeach
</div>
</section>
@endsection

@section('myjs')
<script>
    function submitForm(itemID) {
            $('#form-' + itemID).submit();
        }
    $(document).ready(function() {
        
        $('.filtering').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            // autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
        });
    })
</script>
@endsection