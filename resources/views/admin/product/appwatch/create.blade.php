@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Create New Appwatch</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>Appwatch Information</h1>
            <p>Add information name , category , color , size , capacity , price , quantity of your appwatch.</p>
            <form action="{{route('appwatch.store')}}" method="post" enctype="multipart/form-data">
                @csrf
            
                <div>
                    <label for="categorydetail_id">Category Detail</label><br>
                    <select name="categorydetail_id" id="">
                        @foreach($categorydetail as $item)
                        @if($item->categories->id == 3)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <input style="display: none;" type="text" name="category_id" value="3">
               
                <div>
                <label for="color_id">Color</label><br>
                    <select name="color_id" id="">
                        @foreach($color as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                <label for="size_id">Size</label><br>
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