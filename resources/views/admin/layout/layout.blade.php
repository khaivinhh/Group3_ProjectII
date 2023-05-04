<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="{{asset('/css/mycode/admin/layout.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('/css/mycode/frontend/bootstrap.min.css')}}"> -->
    @yield('mycss')
    <title>Document</title>
</head>

<body>
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

    <header class="sidebar">
        <nav class="">
            <div class="header_sidebar">
                <img class="logo_user" src="{{ asset($auth->image) }}" alt="">
                <span class="name_user">{{$auth->name}}</span>
            </div>
            <i class="btn_collapser fa-solid fa-circle-arrow-left"></i>
            <i class="menu_icon_close fa-solid fa-xmark"></i>
            <ul class="sidebar-menu">

                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fa-sharp fa-solid fa-house-user"></i>
                        <span>Dashboard</span>
                    </a>
                </li>



                <li class="accordion">
                    <i class="fa-solid fa-users"></i>
                    <span>Customer</span>
                </li>
                <div class="panel">
                    <a href="{{route('customer.index')}}">List Customer</a>
                    <a href="{{route('customer.create')}}">Create New Customer</a>
                </div>

                <li class="accordion">
                    <i class="fa fa-product-hunt"></i>
                    <span>Product</span>
                </li>
                <div class="panel">
                    <a href="{{route('iphone.index')}}">List IPhone</a>
                    <a href="{{route('macbook.index')}}">List MacBook</a>
                    <a href="{{route('appwatch.index')}}">List AppWatch</a>
                </div>


                <li class="accordion">
                    <i class="fa-sharp fa-solid fa-folder-open"></i>
                    <span>Category</span>
                </li>
                <div class="panel">
                    <a href="{{route('categorydetail.index')}}">List Category Detail</a>
                    <a href="{{route('categorydetail.create')}}">Create New Category Detail</a>
                </div>


                <li class="accordion">
                    <i class="fa-solid fa-image"></i>
                    <span>Image</span>
                </li>
                <div class="panel">
                    <a href="{{route('image.index')}}">List Image</a>
                    <a href="{{route('image.create')}}">Create New Image</a>
                </div>


                <li>
                    <a href="{{route('order.index')}}">
                        <i class="fa fa-sort"></i>
                        <span>Order</span>
                    </a>
                </li>

            </ul>
        </nav>
    </header>


    <main class="main">

        <div class="tab_header">
            <a class="logo_brand" href=""><img src="{{ asset('/images/myimg/logo-apple.png')}}" alt="" width="50px" height="60px"></a>
            <i class="menu_icon_open fa-solid fa-bars"></i>
            <div class="input_search">
                <input type="text" placeholder="Search ..." class="valuesearch">
                <i class="btn-search fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="option">
                <i class="fa-sharp fa-solid fa-message"></i>
                <i class="fa-solid fa-bell"></i>
                <i class="setting_account fa-solid fa-user-large"></i>
                <div class="account_setting">
                    <a href="{{route('editprofile')}}">Edit Profile</a>
                    <a href="{{route('logout')}}">Log Out</a>
                </div>
            </div>

        </div>


        @yield('contents')



    </main>


    <footer>

    </footer>




    <script src="{{asset('/js/mycode/1aa4f49900.js')}}"></script>
    <script src="{{asset('/js/mycode/jquery-3.6.4.min.js')}}"></script>
    <script src="{{asset('/js/mycode/loader.js')}}"></script>

    @yield('myjs')
    <script>
        var acc = document.getElementsByClassName("accordion");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                // đóng tất cả những class accordion khác
                var accordions = document.getElementsByClassName("accordion");
                for (var j = 0; j < accordions.length; j++) {
                    if (accordions[j] !== this) {
                        // accordions[j].classList.remove("active");
                        var panel = accordions[j].nextElementSibling;
                        panel.style.maxHeight = null;
                    }
                }
                // mở những thẻ a ra
                // this.classList.toggle("active");
                var panel = this.nextElementSibling;
                var panelStyle = window.getComputedStyle(panel);
                if (panelStyle.getPropertyValue('display') == 'none') {
                    panel.style.display = 'block';
                    if (panel.style.maxHeight) {
                        panel.style.maxHeight = null;
                    } else {
                        panel.style.maxHeight = panel.scrollHeight + "px";
                    }
                }
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
        var sidebar = document.querySelector('.sidebar');
        var header_sidebar = document.querySelector('.header_sidebar');
        var logo_user = document.querySelector('.logo_user');
        var name_user = document.querySelector('.name_user');
        var btn_collapser = document.querySelector('.btn_collapser');
        var panels = document.querySelectorAll('.panel');

        var main = document.querySelector('.main');
        var tab_header = document.querySelector('.tab_header');

        btn_collapser.addEventListener('click', function() {
            logo_user.classList.toggle('logo_user_sidebar');
            name_user.classList.toggle('name_user_sidebar');
            sidebar.classList.toggle('sidebar_sidebar');
            this.classList.toggle('btn_collapser_sidebar');
            header_sidebar.classList.toggle('header_sidebar_sidebar');
            for (var i = 0; i < panels.length; i++) {
                panels[i].classList.toggle('panel_sidebar');
                if (panels[i].style.maxHeight) {
                    panels[i].style.display = 'none';
                }
            }
            main.classList.toggle('main_sidebar');
            tab_header.classList.toggle('tab_header_sidebar');

        });

        var menu_icon_open = document.querySelector('.menu_icon_open');
        menu_icon_open.addEventListener('click', function() {
            sidebar.classList.add('sidebar_menu_icon_open');
        });
        var menu_icon_close = document.querySelector('.menu_icon_close');
        menu_icon_close.addEventListener('click', function() {
            sidebar.classList.remove('sidebar_menu_icon_open');
        });


        function toggleHeaderClass() {
            var sidebarwidth = window.getComputedStyle(sidebar);

            if (window.innerWidth > 720) {
                if (window.innerWidth > 720 && sidebarwidth.getPropertyValue('width') == '65px') {
                    return;
                }
                sidebar.classList.remove('sidebar_menu_icon_open');
                main.classList.remove('main_sidebar');
                tab_header.classList.remove('tab_header_sidebar');
            } else {
                for (var i = 0; i < panels.length; i++) {
                    panels[i].classList.remove('panel_sidebar');
                    if (panels[i].style.maxHeight) {
                        panels[i].style.display = 'none';
                    }
                }
                logo_user.classList.remove('logo_user_sidebar');
                name_user.classList.remove('name_user_sidebar');
                sidebar.classList.remove('sidebar_sidebar');
                btn_collapser.classList.remove('btn_collapser_sidebar');
                header_sidebar.classList.remove('header_sidebar_sidebar');
            }
        }
        window.addEventListener('resize', toggleHeaderClass);
        toggleHeaderClass();
        var setting_account = document.querySelector('.setting_account');
        var account_setting = document.querySelector('.account_setting');
        setting_account.addEventListener('click', function() {
            account_setting.classList.toggle('account_setting_setting_account');
        });
    </script>
</body>

</html>