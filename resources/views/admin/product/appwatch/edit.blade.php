@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Edit Appwatch</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>Appwatch Information</h1>
            <p>Edit information name , category , color , size , capacity , price , quantity of your appwatch.</p>
            <form action="{{route('appwatch.update',$appwatch->id)}}" method="post">
                @csrf
                @method("PUT")
                <div>
                    <label for="categorydetail_id">Category</label><br>
                    <select name="categorydetail_id" id="">
                        @foreach($categorydetail as $item)
                        @if($item->categories->id == 3)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <input style="display: none;" type="text" name="category_id" value="1">

                <div>
                    <label for="color_id">Color</label><br>
                    <select name="color_id" id="">
                        <option value="{{$appwatch->colors->id}}">{{$appwatch->colors->name}}</option>

                        @foreach($color as $item)
                        @if($item->id != $appwatch->colors->id)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="size_id">Size</label><br>
                    <select name="size_id" id="">
                    <option value="{{$appwatch->sizes->id}}">{{$appwatch->sizes->name}}</option>

                        @foreach($size as $item)
                        @if($item->id != $appwatch->sizes->id)

                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="capacity_id">Capacity</label><br>
                    <select name="capacity_id" id="">
                    <option value="{{$appwatch->capacities->id}}">{{$appwatch->capacities->name}}</option>

                        @foreach($capacity as $item)
                        @if($item->id != $appwatch->capacities->id)

                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price">Price</label><br>
                    <input type="text" name="price" id="price" value="{{$appwatch->price}}" required>
                </div>
                <div>
                    <label for="quantity">quantity</label><br>
                    <input type="text" name="quantity" id="quantity" value="{{$appwatch->quantity}}" required>
                </div>

                <div>
                    <label for="description">Description</label><br>
                    <textarea name="description" id="" cols="50" rows="10">{{$appwatch->description}}</textarea>
                </div>

                <button type="submit" style="margin-top:10px">Update</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@end