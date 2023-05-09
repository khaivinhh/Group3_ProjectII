<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/mycode/frontend/layout.css')}}">
    <link rel="stylesheet" href="{{asset('/css/mycode/frontend/slick.css')}}">
    <link rel="stylesheet" href="{{asset('/css/mycode/frontend/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('/css/mycode/frontend/bootstrap.min.css')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('images/myimg/OIP-removebg-preview.png')}}">

    @yield('mycss')


    <title>IShopApple</title>
</head>

<body>


    <div class="my_toast complete_toast">
        <div class="toast-content">
            <i class="fas fa-solid fa-check check"></i>

            <div class="message">
                <span class="text text-1">Success</span>
                <span class="text text-2">
                </span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>

        <div class="progress complete_progress"></div>
    </div>

    <div class="my_toast error_toast">
        <div class="toast-content">
            <i class="fa-solid fa-xmark"></i>

            <div class="message">
                <span class="text text-1">Error</span>
                <span class="text text-2-error">
                </span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress error_progress"></div>
    </div>




    <div id="preloader" class="preloader">
        <div class="animation-preloader">
            <div class="spinner">
            </div>
            <div class="txt-loading">

                <span data-text-preloader="A" class="letters-loading">
                    A
                </span>
                <span data-text-preloader="P" class="letters-loading">
                    P
                </span>
                <span data-text-preloader="P" class="letters-loading">
                    P
                </span>
                <span data-text-preloader="L" class="letters-loading">
                    L
                </span>
                <span data-text-preloader="E" class="letters-loading">
                    E
                </span>
            </div>
            <p class="text-center">Loading</p>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>
    <header>
        <nav class="sidebar_header">
            <div class="left_sidebar_header">
                <h1><a href="{{route('home')}}" class="name_brand">IShopApple</a></h1>
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('shop',1)}}">Shop</a>
                <a href="{{route('about')}}">About</a>
                <a href="{{route('contact')}}">Contact</a>
                <a href="{{route('cart')}}">Cart
                    @if(session()->has('cart'))
                    <span class="count_cart">{{ count(session('cart')) }}</span>
                    @else
                    <span class="count_cart">0</span>
                    @endif

                </a>
            </div>
            <div class="right_sidebar_header">
                <div class="header_mobie">
                    <img class="logo" src="{{asset('images/myimg/OIP.jpg')}}" alt="">
                    <div class="search">
                        <form class="search_by_name" action="{{route('search_by_name')}}">
                            <input type="text" placeholder="search" name="name" class="input_search_name">
                            <button class="submit_search" style="padding:0;border:0" type="submit" disabled><i class="btn_search fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <i class="fa-solid fa-bars"></i>
                </div>
                <a href="{{route('myaccount')}}">Account</a>

            </div>
        </nav>

    </header>
    <main>
        @yield('contents')
    </main>
    <footer class="footer">
        <div class="container">
            <div class="row_flex">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        <li><a href="#">about us</a></li>
                        <li><a href="#">our services</a></li>
                        <li><a href="#">privacy policy</a></li>
                        <li><a href="#">affiliate program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">shipping</a></li>
                        <li><a href="#">returns</a></li>
                        <li><a href="#">order status</a></li>
                        <li><a href="#">payment options</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>online shop</h4>
                    <ul>
                        <li><a href="#">iPhone</a></li>
                        <li><a href="#">MacBook</a></li>
                        <li><a href="#">AppWatch</a></li>

                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

<script src="{{asset('/js/mycode/1aa4f49900.js')}}"></script>
<script src="{{asset('/js/mycode/jquery-3.6.4.min.js')}}"></script>
<script src="{{asset('/js/mycode/slick.min.js')}}"></script>
<script src="{{asset('/js/mycode/loader.js')}}"></script>
@yield('myjs')
<script>
    $('.input_search_name').on('keyup', function() {
        if ($(this).val().length > 0) {
            $('.submit_search').removeAttr('disabled');
        } else {
            $('.submit_search').attr('disabled', 'disabled');
        }
    });

    var timer1, timer2;

    function notification_complete() {
        clearTimeout(timer1);
        clearTimeout(timer2);
        $('.complete_progress').removeClass('active_notification');


        $('.complete_toast').addClass('active_notification');


        setTimeout(() => {
            $('.complete_progress').addClass('active_notification');
        }, 10);

        timer1 = setTimeout(() => {
            $('.complete_toast').removeClass('active_notification');
        }, 5000);

        timer2 = setTimeout(() => {
            $('.complete_progress').removeClass('active_notification');
        }, 5300);
    }



    var i = 0;

    function notification_error() {

        clearTimeout(timer1);
        clearTimeout(timer2);
        $('.error_progress').removeClass('active_notification');


        $('.error_toast').addClass('active_notification');

        setTimeout(() => {
            $('.error_progress').addClass('active_notification');
        }, 10);

        timer1 = setTimeout(() => {
            $('.error_toast').removeClass('active_notification');
        }, 5000);

        timer2 = setTimeout(() => {
            $('.error_progress').removeClass('active_notification');
        }, 5300);


    }


    $('.close').on('click', function() {
        $('.my_toast').removeClass('active_notification');
        setTimeout(() => {
            $('.progress').removeClass('active_notification');
        }, 300);
        clearTimeout(timer1);
        clearTimeout(timer2);
    })
</script>

</html>