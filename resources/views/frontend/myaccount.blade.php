@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<h1>sign-in page</h1>
<form action="{{route('signin_user')}}" method="post">
    @csrf
    <div>
        <label for="firstname">Email : </label>
        <input type="email" name="email">
    </div>
    <div>
        <label for="lastname">Password : </label>
        <input type="password" name="password">
    </div>
    <input type="submit">
</form>


<form action="{{route('create_user')}}" method="post">
    @csrf
    <div>
        <label for="firstname">First Name : </label>
        <input type="text" name="first_name">
    </div>
    <div>
        <label for="lastname">Last Name : </label>
        <input type="text" name="last_name">
    </div>
    <div>
        <label for="email">Email : </label>
        <input type="email" name="email">
    </div>
    <div>
        <label for="phone">Phone : </label>
        <input type="text" name="phone">
    </div>
    <div>
        <label for="address">Address : </label>
        <input type="text" name="address">
    </div>
    <div>
        <label for="password">Password : </label>
        <input type="password" name="password">
    </div>
    <input type="submit">
</form>
@endsection

@section('myjs')
@endsection