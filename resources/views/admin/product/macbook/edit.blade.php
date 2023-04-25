@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Edit MacBook</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>MacBook Information</h1>
            <p>Edit information name , category , color , ram , capacity , price , quantity of your macbook.</p>
            <form action="{{route('macbook.update',$macbook->id)}}" method="post">
                @csrf
                @method("PUT")
                <div>
                    <label for="categorydetail_id">Category</label><br>
                    <select name="categorydetail_id" id="">
                        @foreach($categorydetail as $item)
                        @if($item->categories->id == 2)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <input style="display: none;" type="text" name="category_id" value="1">

                <div>
                    <label for="color_id">Color</label><br>
                    <select name="color_id" id="">
                        <option value="{{$macbook->colors->id}}">{{$macbook->colors->name}}</option>

                        @foreach($color as $item)
                        @if($item->id != $macbook->colors->id)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ram_ud">Ram</label><br>
                    <select name="ram_id" id="">
                    <option value="{{$macbook->rams->id}}">{{$macbook->rams->name}}</option>

                        @foreach($ram as $item)
                        @if($item->id != $macbook->rams->id)

                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="capacity_id">Capacity</label><br>
                    <select name="capacity_id" id="">
                    <option value="{{$macbook->capacitys->id}}">{{$macbook->capacitys->name}}</option>

                        @foreach($capacity as $item)
                        @if($item->id != $macbook->capacitys->id)

                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price">Price</label><br>
                    <input type="text" name="price" id="price" value="{{$macbook->price}}" required>
                </div>
                <div>
                    <label for="quantity">quantity</label><br>
                    <input type="text" name="quantity" id="quantity" value="{{$macbook->quantity}}" required>
                </div>

                <div>
                    <label for="description">Description</label><br>
                    <textarea name="description" id="" cols="50" rows="10">{{$macbook->description}}</textarea>
                </div>

                <button type="submit" style="margin-top:10px">Update</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@end