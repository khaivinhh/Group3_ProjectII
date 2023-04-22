<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/mycode/admin/login.css')}}">

    <title>Document</title>
</head>

<body>
    <h2 class="title">Welcome To The Admin Login Page</h2>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form >
                <h1>Create Account</h1>
                <p style="color:red" id="notification-checkcreate">
                </p>
                <input type="text" placeholder="Name" class="namecreate" required />
                <input type="email" placeholder="Email" class="emailcreate" required />
                <input type="password" placeholder="Password" class="passwordcreate" required />
                <button id="sign-up">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form>
                <h1>Sign in</h1>
                <p style="color:red" id="notification-checklogin">
                </p>
                <input type="email" placeholder="Email" class="emaillogin" required />
                <input type="password" placeholder="Password" class="passwordlogin" required />
                <a href="#">Forgot your password?</a>
                <button id="sign-in">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>
            Created with <i class="fa fa-heart"></i> by
            <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
            - Read how I created this and how you can join the challenge
            <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
        </p>
    </footer>


    <script src="{{asset('/js/mycode/1aa4f49900.js')}}"></script>
    <script src="{{asset('/js/mycode/jquery-3.6.4.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            const urlchecklogin = "{{route('checklogin')}}";
            const urlcreateaccount = "{{route('createaccount')}}";
            $('#sign-in').click(function(e) {
                e.preventDefault();
                let email = $('.emaillogin').val();
                let password = $('.passwordlogin').val();

                $.ajax({
                    type: 'post',
                    url: urlchecklogin,
                    data: {
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data == 'successfully') {
                            window.location.href = "{{ route('dashboard') }}";
                        } else {
                            $('#notification-checklogin').text('username or password error !');
                        }

                    }
                });
            });
            $('#sign-up').click(function(e) {
                e.preventDefault();
                let name = $('.namecreate').val();
                let email = $('.emailcreate').val();
                let password = $('.passwordcreate').val();
                $.ajax({
                    type: 'post',
                    url: urlcreateaccount,
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data == 'successfully') {
                            $('#notification-checkcreate').text('successfully !');
                        } else {
                            $('#notification-checkcreate').text('Email already exists !');
                        }

                    }
                });
            });

            const signUpButton = $('#signUp');
            const signInButton = $('#signIn');
            const container = $('#container');

            signUpButton.on('click', function() {
                container.addClass("right-panel-active");
            });

            signInButton.on('click', function() {
                container.removeClass("right-panel-active");
            });
        });
    </script>


</body>

</html>