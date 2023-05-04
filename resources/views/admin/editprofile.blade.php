@extends('admin/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/editprofile.css')}}">
@endsection
@section('contents')


<div class="editprofile">
    <div class="informationuser">
        <div class="imguser">
            <img class="logo_user" src="{{ asset($auth->image) }}" alt="">
            <form>
                <label class="image-input">
                    <input id="changeimguser" type="file" name="image" onchange="changeImage(this)">
                    <i class="fa fa-pencil"></i>
                </label>
            </form>
        </div>
        <div>
            <h1>Profile</h1>
            <p>Email : {{$auth->email}}</p>
            <p>Name : {{$auth->name}}</p>
            <p>Created at : {{$createdAt}}</p>
            <p id="updateat">Updated at : {{$updatedAt}}</p>
        </div>

    </div>
    <section class="profile">
        <h2>Profile Information</h1>
            <p>Update your account's profile information and email address.</p>
            <form id="form1" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <label for="name">Name</label><br>
                    <input type="text" name="name" id="nameform1" value="{{$auth->name}}">
                </div>
                <div>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="emailform1" value="{{$auth->email}}">
                </div>
                <button type="submit" class="information">Save</button>
            </form>
    </section>


    <section class="update">
        <h2>Update Password</h2>
        <p>Ensure your account is using a long, random password to stay secure.</p>
        <form id="form2">
            @csrf
            @method('PUT')


            <div>
                <label for="curentpassword">Current Password</label><br>
                <input type="password" name="curentpassword" id="curentpassword" required>
            </div>
            <p id="passworderror">password error</p>
            <div>
                <label for="newpassword">New Password</label><br>
                <input type="password" name="newpassword" id="newpassword" required>
            </div>
            <p id="passwordincorrect">password incorrect</p>
            <div>
                <label for="confirmpassword">Confirm Password</label><br>
                <input type="password" name="confirmpassword" id="confirmpassword" required>
            </div>

            <button type="submit" class="updatepassword">Save</button>
        </form>
    </section>
    <section class="delete">
        <h2>Delete Account</h2>
        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
            your account, please download any data or information that you wish to retain.</p>
        <form action="{{route('admin.destroy',$auth->id)}}" method="post">
            @csrf
            @method("DELETE")
            <button type="submit" class="deleteaccount">Delete Account</button>
        </form>
    </section>
</div>
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

    $(document).ready(function() {
        $('#form1').submit(function(e) {
            e.preventDefault();
            let email = $('#emailform1').val();
            let name = $('#nameform1').val();
            let form_data = new FormData();
            form_data.append('email', email);
            form_data.append('name', name);
            form_data.append('newimguser', $('#changeimguser')[0].files[0]);
            form_data.append('_token', '{{ csrf_token() }}');
            form_data.append('_method', 'PUT');
            $.ajax({
                type: 'post',
                url: "{{route('admin.update', $auth->id)}}",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#nameform1').val(data.name);
                    $('#emailform1').val(data.email);
                    // $('.name_user').text(data.name);
                }
            });
        });

        $('#form2').submit(function(e) {
            e.preventDefault();
            // let email = $('#emailform2').val();
            // let name = $('#nameform2').val();

            let curentpassword = $('#curentpassword').val();
            let newpassword = $('#newpassword').val();
            let confirmpassword = $('#confirmpassword').val();

            $.ajax({
                type: 'post',
                url: "{{route('admin.update', $auth->id)}}",
                data: {
                    _method: 'PUT',
                    // email: email,
                    // name: name,
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
                        alert('successful change');
                    }
                }
            });
        });
    });
</script>
@endsection