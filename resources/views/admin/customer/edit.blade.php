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
                    <label for="name">Name</label><br>
                    <input type="text" name="name" id="name" value="{{$customer->name}}" >
                </div>
                <div>
                    <label for="email">Email</label><br>
                    <input type="email" name="email" id="email" value="{{$customer->email}}" >
                </div>
                <div>
                    <label for="phone">Phone</label><br>
                    <input type="text" name="phone" id="phone" value="{{$customer->phone}}" >
                </div>
                <div>
                    <label for="address">Address</label><br>
                    <input type="text" name="address" id="address" value="{{$customer->address}}" >
                </div>
                <div>
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" value="{{$customer->password}}" >
                </div>
                <button id="sign_up">Update</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@endsection
