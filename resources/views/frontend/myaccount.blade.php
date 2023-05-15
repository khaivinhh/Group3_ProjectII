@extends('frontend/layout/layout')
@section('contents')
<section class="title">
    <h1>Account</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Account</a>
</section>

<section class="form_recover_password">
    <i class="btn_close fa-solid fa-xmark"></i>
    <h3>Enter Your Email</h3>
    <form id="form_recover_password">
        <label for="email_recover">Email</label>
        <input required id="email_recover" type="email" class="email_recover_password" required>
        <button type="submit" class="btn_recover_password">Enter</button>
    </form>
</section>



<section class="myaccount">
    <form id="form_sign_in">
        <h3>LOGIN</h3>
        <hr class="hr_title">

        <div>
            <label for="email_sign_in">Email</label><span class="email_sign_in">_(required)</span><br>
            <input type="email" id="email_sign_in" required>
        </div>

        <div>
            <label for="password_sign_in">Password</label><span class="password_sign_in">_(required)</span><br>
            <input type="password" id="password_sign_in" required>
        </div>

        <button class="sign_in">Sign In</button>

        <a class="recoverpass" tabindex="0">lost your password?</a>
        <div class="chooise_option_login">
            <hr>
            <span>OR</span>
            <hr>
        </div>

        <div class="sign_in_google">
            <img src="{{asset('images/myimg/logo-google.png')}}" alt="" width="50">
            <span>Sign in with google</span>
        </div>

    </form>


    <form id="form_sign_up">
        <h3>REGISTER</h3>
        <hr class="hr_title">
        <div>
            <label for="name_sign_up">Name</label><span class="name_sign_up">_(required)</span><br>
            <input type="text" id="name_sign_up" required>
        </div>
        <div>
            <label for="email_sign_up">Email </label><span class="email_sign_up">_(required)</span><br>
            <input type="email" id="email_sign_up" required>
        </div>
        <div>
            <label for="phone_sign_up">Phone</label><span class="phone_sign_up">_(required)</span><br>
            <input type="text" id="phone_sign_up" required>
        </div>
        <div>
            <label for="address_sign_up">Address</label><span class="address_sign_up">_(required)</span><br>
            <input type="text" id="address_sign_up" required>
        </div>
        <div>
            <label for="password_sign_up">Password</label><span class="password_sign_up">_(required)</span><br>
            <input type="password" id="password_sign_up" required>
        </div>
        <button class="sign_up">Register</button>
    </form>
</section>

@endsection

@section('myjs')

<script>
    $('.recoverpass').on('click', function() {
        $('.form_recover_password').css('opacity', '1')
        $('.form_recover_password').css('top', '45%')
    })
    $('.btn_close').on('click', function() {
        $('.form_recover_password').css('opacity', '0')
        $('.form_recover_password').css('top', '-17%')

    })


    $('.sign_in_google').on('click', function() {
        window.location.href = "{{ route('login_google') }}";
    })


    $('.sign_in').on('click', function(e) {
        e.preventDefault();
        if ($("#form_sign_in")[0].checkValidity()) {
            let email = $('#email_sign_in').val();
            let password = $('#password_sign_in').val();
            $.ajax({
                type: 'post',
                url: "{{route('signin_user')}}",
                data: {
                    email: email,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.notification == 'successfully') {
                        window.location.href = "{{ route('profile') }}";
                    } else {
                        $('.text-2-error').text('Email or Password error !');
                        notification_error();
                    }

                }
            });
        } else {
            validate_sign_in();
        }
    });
    var all_tag_sign_in = $("#form_sign_in")[0].querySelectorAll('input');
    all_tag_sign_in.forEach((item) => {
        item.addEventListener('keyup', function() {
            validate_sign_in();
        })
    });

    function validate_sign_in() {
        var invalidInputs = $("#form_sign_in")[0].querySelectorAll(':invalid');
        all_tag_sign_in.forEach((item) => {
            $("." + item.id + "").css('display', 'none')
        })
        var missingFields = Array.from(invalidInputs).map(function(tag) {
            $("." + tag.id + "").css('display', '-webkit-inline-box')
        });
    }

    $('.sign_up').on('click', function(e) {
        e.preventDefault();
        if ($("#form_sign_up")[0].checkValidity()) {
            let name = $('#name_sign_up').val();
            let email = $('#email_sign_up').val();
            let phone = $('#phone_sign_up').val();
            let address = $('#address_sign_up').val();
            let password = $('#password_sign_up').val();
            $.ajax({
                type: 'post',
                url: "{{route('create_user')}}",
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.notification == 'successfully') {
                        $('.text-2').text('Account successfully created !');
                        notification_complete();
                    } else {
                        $('.text-2-error').text('Email already exists !');
                        notification_error();
                    }

                }
            });
        } else {
            validate_sign_up();
        }
    });

    var all_tag_sign_up = $("#form_sign_up")[0].querySelectorAll('input');
    all_tag_sign_up.forEach((item) => {
        item.addEventListener('keyup', function() {
            validate_sign_up();
        })
    });

    function validate_sign_up() {
        var invalidInputs = $("#form_sign_up")[0].querySelectorAll(':invalid');
        all_tag_sign_up.forEach((item) => {
            $("." + item.id + "").css('display', 'none')
        })
        var missingFields = Array.from(invalidInputs).map(function(tag) {
            $("." + tag.id + "").css('display', '-webkit-inline-box')
        });
    }

    $('#form_recover_password').on('submit', function(e) {
        let email = $('.email_recover_password').val()
        $.ajax({
            type: 'post',
            url: "{{route('recover_password')}}",
            data: {
                email: email,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.notification == 'successfully') {
                    $('.text-2').text('Please check your email !');
                    notification_complete();
                } else {
                    $('.text-2-error').text('Email not registered account !');
                    notification_error();
                }
            }
        });
    });
</script>
@endsection