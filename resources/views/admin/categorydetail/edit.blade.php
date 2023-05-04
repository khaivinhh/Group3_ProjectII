@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Create New Customer</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2 id="check">Profile Information</h1>
            <p>Add your account's profile information and email address.</p>
            <form action="{{route('categorydetail.update',$categorydetail->id)}}" method="post">
                @csrf
                @method("PUT")

                <div>
                    <label for="name">Category Detail</label><br>
                    <input type="text" name="name" value="{{$categorydetail->name}}">
                </div>
                <div>
                    <label for="description">Description</label><br>
                    <textarea name="description" id="" cols="50" rows="10">{{$categorydetail->description}}</textarea>
                </div>
                <button id="submit">Update</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@endsection
