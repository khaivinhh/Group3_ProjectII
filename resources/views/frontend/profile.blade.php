@extends('frontend/layout/layout')
@section('contents')





<section class="profile">
    <section class="informationuser">
        <div class="header_informationuser_left">
            <div class="imguser">
                <img class="logo_user" src="{{asset($user->image)}}" alt="">
            </div>
            @if($user->source == 'register')
            <form>
                <label class="image-input">
                    <input id="changeimguser" type="file" name="image" onchange="changeImage(this)">
                    <i class="fa fa-pencil"></i>
                </label>
            </form>
            @endif
        </div>

        <div class="informationuser_header_right">
            <h1>Information</h1>
            <p>Name : {{$user->name}}</p>
            <p>Email : {{$user->email}}</p>
            <p>Created at : {{$user->created_at}}</p>
            <p id="updateat">Updated at : {{$user->updated_at}}</p>
        </div>
    </section>
    <section class="flex">
        <div class="check_order">
            <h2>Order tracking and order scheduling</h2>
            <p>Track and View Your Order History: Stay Up-to-Date with Your Purchases</p>
            <a class="order_status" href="{{route('order_status')}}">Status Order</a>
            <a class="order_history" href="{{route('order_history')}}">History Order</a>
        </div>
        <div class="profile_user">
            <h2>Change Profile Information</h1>
                <p>Update your account's profile information and email address.</p>
                <form id="form1" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if($user->source == 'register')
                    <div>
                        <label for="name">Name</label><span class="name">&nbsp;&nbsp;*The Name field is required.</span><br>
                        <input type="text" id="name" value="{{$user->name}}" required>
                    </div>
                    <div>
                        <label for="email">Email</label><span class="email">&nbsp;&nbsp;*The Email field is required.</span><br>
                        <input type="email" id="email" value="{{$user->email}}" required>
                    </div>
                    @endif
                    <div>
                        <label for="phone">Phone</label><span class="phone">&nbsp;&nbsp;*The Phone field is required.</span><br>
                        <input type="text" id="phone" value="{{$user->phone}}" required>
                    </div>
                    <div>
                        <label for="address">Address</label><span class="address">&nbsp;&nbsp;*The Address field is required.</span><br>
                        <input type="text" id="address" value="{{$user->address}}" required>
                    </div>
                    <button class="change_information_user">Save</button>
                </form>
        </div>

        @if($user->source == 'register')
        <div class="update">
            <h2>Update Password</h2>
            <p>Ensure your account is using a long, random password to stay secure.</p>
            <form id="form2">
                @csrf
                @method('PUT')
                <div>
                    <label for="curentpassword">Current Password</label><span class="curentpassword">&nbsp;&nbsp;*The Current Password field is required.</span><br>
                    <input type="password" id="curentpassword" required>
                </div>
                <p id="passworderror">password error</p>
                <div>
                    <label for="newpassword">New Password</label><span class="newpassword">&nbsp;&nbsp;*The New Password field is required.</span><br>
                    <input type="password" id="newpassword" required>
                </div>
                <p id="passwordincorrect">password incorrect</p>
                <div>
                    <label for="confirmpassword">Confirm Password</label><span class="confirmpassword">&nbsp;&nbsp;*The Confirm Password field is required.</span><br>
                    <input type="password" id="confirmpassword" required>
                </div>

                <button class="updatepassword">Save</button>
            </form>
        </div>
        @endif

        <div class="sign_out_account">
            <h2>Sign Out Account</h2>
            <p>Don't forget to log out if you're using a public or shared device to keep your account secure.</p>
            <form action="{{route('signout_user')}}">
                <button class="sign_out">Sign Out</button>
            </form>
        </div>
        <!-- <section class="delete">
        <h2>Delete Account</h2>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
            your account, please download any data or information that you wish to retain.</p>
        <form action="{{route('delete_customer',$user->id)}}" method="post">
            @csrf
            @method("DELETE")
            <button type="submit" class="deleteaccount">Delete Account</button>
        </form>
        </section> -->
    </section>
</section>


@endsection
@section('myjs')
<script>
    function changeImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const logoUsers = document.querySelectorAll('.logo_user');
                logoUsers.forEach((logoUser) => {
                    logoUser.src = e.target.result;
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }



    $('.change_information_user').on('click', function(e) {
        e.preventDefault();
        if ($('#form1')[0].checkValidity()) {
            let form_data = new FormData();
            if ("{{$user->source}}" == "register") {
                form_data.append('name', $('#name').val());
                form_data.append('email', $('#email').val());
                form_data.append('newimguser', $('#changeimguser')[0].files[0]);
            }
            form_data.append('phone', $('#phone').val());
            form_data.append('address', $('#address').val());
            form_data.append('id', "{{$user->id}}");
            form_data.append('_token', '{{ csrf_token() }}');
            form_data.append('_method', 'PUT');
            $.ajax({
                type: 'post',
                url: "{{route('update_profile')}}",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(data) {
                    if ("{{$user->source}}" == "register") {
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                    }
                    $('#phone').val(data.phone);
                    $('#address').val(data.address);
                    $('.text-2').text('Your changes has been saved');
                    notification_complete();

                }
            });
        } else {
            validate_form('form1');
        }
    });
    var all_tag_form1 = $("#form1")[0].querySelectorAll('input');
    all_tag_form1.forEach((item) => {
        item.addEventListener('keyup', function() {
            validate_fields(item);
        })
    });


    $('.updatepassword').on('click', function(e) {
        e.preventDefault();
        if ($('#form2')[0].checkValidity()) {
            let curentpassword = $('#curentpassword').val();
            let newpassword = $('#newpassword').val();
            let confirmpassword = $('#confirmpassword').val();

            $.ajax({
                type: 'post',
                url: "{{route('update_profile')}}",
                data: {
                    _method: 'PUT',
                    id: "{{$user->id}}",
                    curentpassword: curentpassword,
                    newpassword: newpassword,
                    confirmpassword: confirmpassword,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.notification == 'password error') {
                        $('#passworderror').show();
                        $('#passwordincorrect').hide();
                    } else if (data.notification == 'password incorrect') {
                        $('#passwordincorrect').show();
                        $('#passworderror').hide();
                    } else {
                        $('#passwordincorrect').hide();
                        $('#passworderror').hide();
                        $('#curentpassword').val('');
                        $('#newpassword').val('');
                        $('#confirmpassword').val('');
                        $('.text-2').text('Your changes has been saved');
                        notification_complete();
                    }
                }
            });
        } else {
            validate_form('form2');
        }
    });
    var all_tag_form2 = $("#form2")[0].querySelectorAll('input');
    all_tag_form2.forEach((item) => {
        item.addEventListener('keyup', function() {
            validate_fields(item);
        })
    });
</script>
@endsection