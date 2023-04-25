@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Create New Category Detail</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>Category Detail Information</h2>
        <p>Add information name , category of your category detail.</p>
        <form action="{{route('categorydetail.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="first_name">Name</label><br>
                <input type="text" name="name" id="name" required>
            </div>
            <div>
                <label for="category_id">Category</label><br>
                <select name="category_id" id="">
                    @foreach($category as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="photo">Image</label><br>
                <input type="file" name="photo" id="photo" required>
            </div>
            <button type="submit">Add</buttont>
        </form>
    </section>

</div>
@endsection

@section('myjs')

@end