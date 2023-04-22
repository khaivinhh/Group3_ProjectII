@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/addiphone.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Create New Iphone</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>Profile Information</h1>
            <p>Add information name , category , color , ram , capacity , price , quantity of your product.</p>
            <form action="{{route('iphone.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="name">Name</label><br>
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
                <label for="color_id">Color</label><br>
                    <select name="color_id" id="">
                        @foreach($color as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                <label for="size_id">Ram</label><br>
                    <select name="size_id" id="">
                        @foreach($size as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                <label for="capacity_id">Capacity</label><br>
                    <select name="capacity_id" id="">
                        @foreach($capacity as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                    <div>
                        <label for="price">Price</label><br>
                        <input type="text" name="price" id="price" required>
                    </div>
                    <div>
                        <label for="quantity">quantity</label><br>
                        <input type="text" name="quantity" id="quantity" required>
                    </div>
                
                <div>
                    <label for="description">Description</label><br>
                    <textarea name="description" id="" cols="50" rows="10"></textarea>
                </div>
                <div>
                    <label for="image">Image</label><br>
                    <input type="file" name="photo"  id="image" required>
                </div>
                <button type="submit">Add</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@end