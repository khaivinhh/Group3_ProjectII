@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/myaccount.css')}}">

@endsection

@section('contents')
<div class="title">
    <h1>Account</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Account</a>
</div>

<div class="form_recover_password">
    <i class="btn_close fa-solid fa-xmark"></i>
    <h3>Enter Your Email</h3>
    <form id="form_recover_password">
        <label for="email_recover">Email</label>
        <input required id="email_recover" type="email" class="email_recover_password" required>
        <button type="submit" class="btn_recover_password">Enter</button>
        <!-- <p class="notification_recover"></p> -->
    </form>
</div>



<div class="myaccount">
    <form id="form_sign_in">
        <h3>LOGIN</h3>
        <hr>

        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email_sign_in" class="email_sign_in" required>
        </div>

        <div>
            <label for="lastname">Password</label><br>
            <input type="password" name="password_sign_in" class="password_sign_in" required>
        </div>

        <!-- <p class="notification_login" style="margin-top:20px;color:red;display:none">Email or Password error !</p> -->
        <button class="sign_in">Login</button>
        <a class="recoverpass" tabindex="0">lost your password?</a>
    </form>


    <form id="form_sign_up">
        <h3>REGISTER</h3>
        <hr>
        <div>
            <label for="firstname">First Name</label><br>
            <input type="text" name="first_name" class="first_name_sign_up" required>
        </div>
        <div>
            <label for="lastname">Last Name</label><br>
            <input type="text" name="last_name" class="last_name_sign_up" required>
        </div>
        <div>
            <label for="email">Email </label><br>
            <input type="email" name="email" class="email_sign_up" required>
        </div>
        <div>
            <label for="phone">Phone</label><br>
            <input type="text" name="phone" class="phone_sign_up" required>
        </div>
        <div>
            <label for="address">Address</label><br>
            <input type="text" name="address" class="address_sign_up" required>
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password" class="password_sign_up" required>
        </div>
        <!-- <p class="notification_sign_up" style="margin-top:20px;color:red"></p> -->
        <button type="submit" class="sign_up">Register</button>
    </form>
</div>

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





    $('#form_sign_in').on('submit', function(e) {

        e.preventDefault();
        let email = $('.email_sign_in').val();
        let password = $('.password_sign_in').val();
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
                    // $('.notification_login').css('display', 'block');
                }

            }
        });
    });

    $('#form_sign_up').on('submit', function(e) {
        e.preventDefault();
        let first_name = $('.first_name_sign_up').val();
        let last_name = $('.last_name_sign_up').val();
        let email = $('.email_sign_up').val();
        let phone = $('.phone_sign_up').val();
        let address = $('.address_sign_up').val();
        let password = $('.password_sign_up').val();
        $.ajax({
            type: 'post',
            url: "{{route('create_user')}}",
            data: {
                first_name: first_name,
                last_name: last_name,
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
                    // $('.notification_sign_up').text('Account successfully created !');
                } else {
                    $('.text-2-error').text('Email already exists !');
                    notification_error();
                    // $('.notification_sign_up').text('Email already exists !');
                }

            }
        });
    });

    $('#form_recover_password').on('submit', function(e) {
        e.preventDefault();
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
                    // $('.notification_recover').text('Please check your email !')
                } else {
                    $('.text-2-error').text('Email not registered account !');
                    notification_error();
                    // $('.notification_recover').text('Email not registered account !')
                }
            }
        });
    });
</script>
@endsection