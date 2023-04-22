<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/mycode/frontend/layout.css')}}">

    @yield('mycss')
    <title>Document</title>
</head>

<body>
    <header>
        <nav class="sidebar_header">
            <div class="left_sidebar_header">
                <h1>IShopApple</h1>
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('shop')}}">Shop</a>
                <a href="{{route('about')}}">About</a>
                <a href="{{route('contact')}}">Contact</a>
                <a href="{{route('cart')}}">Cart</a>
            </div>
            <div class="right_sidebar_header">
                <div class="header_mobie">
                    <img class="logo" src="{{asset('/images/myimg/logo-apple.png')}}" alt="">
                    <div class="search">
                        <input type="text" placeholder="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
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
    <footer>
        <h1>footer</h1>
    </footer>
</body>
<script src="{{asset('/js/mycode/1aa4f49900.js')}}"></script>
    <script src="{{asset('/js/mycode/jquery-3.6.4.min.js')}}"></script>
@yield('myjs')

</html>