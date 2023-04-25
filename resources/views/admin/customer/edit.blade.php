@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Edit Information Customer</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2 id="check">Profile Information</h1>
            <p>Edit customer account profile information</p>
            <form action="{{route('customer.update',$customer->id)}}" method="post">
                @csrf
                @method("PUT")
                <div>
                    <label for="first_name">First Name</label><br>
                    <input type="text" name="first_name" id="first_name" value="{{$customer->first_name}}" required>
                </div>
                <div>
                    <label for="last_name">Last Name</label><br>
                    <input type="text" name="last_name" id="last_name" value="{{$customer->last_name}}" required>
                </div>
                <div>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" value="{{$customer->email}}" required>
                </div>
                <div>
                    <label for="phone">Phone</label><br>
                    <input type="text" name="phone" id="phone" value="{{$customer->phone}}" required>
                </div>
                <div>
                    <label for="address">Address</label><br>
                    <input type="text" name="address" id="address" value="{{$customer->address}}" required>
                </div>
                <div>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" value="{{$customer->password}}" required>
                </div>
                <button id="sign_up">Update</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@endsection
