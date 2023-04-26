@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/myaccount.css')}}">

@endsection

@section('contents')
<div class="header_link">
    <a href="">Home</a>
    <span class="arrow">></span>
    <span>Account</span>
</div>
<h1 class="title">Account</h1>
<div class="myaccount">

    <form action="{{route('signin_user')}}" method="post">
        <h3>LOGIN</h3>
        <hr>
        @csrf
        <div>
            <label for="firstname">Username or email address</label><br>
            <input type="email" name="email">
        </div>
        <div>
            <label for="lastname">Password</label><br>
            <input type="password" name="password">
        </div>
        <button type="submit">Login</button>
        <a class="recoverpass" href="">lost your password?</a>
    </form>


    <form action="{{route('create_user')}}" method="post">
        <h3>REGISTER</h3>
        <hr>
        @csrf
        <div>
            <label for="firstname">First Name</label><br>
            <input type="text" name="first_name">
        </div>
        <div>
            <label for="lastname">Last Name</label><br>
            <input type="text" name="last_name">
        </div>
        <div>
            <label for="email">Email </label><br>
            <input type="email" name="email">
        </div>
        <div>
            <label for="phone">Phone</label><br>
            <input type="text" name="phone">
        </div>
        <div>
            <label for="address">Address</label><br>
            <input type="text" name="address">
        </div>
        <div>
            <label for="password">Password</label><br>
            <input type="password" name="password">
        </div>
        <button type="submit">Register</button>
    </form>
</div>

@endsection

@section('myjs')
@endsection