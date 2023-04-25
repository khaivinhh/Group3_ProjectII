@extends('admin/layout/layout')
<link rel="stylesheet" href="{{asset('/css/mycode/admin/layouttitle.css')}}">
<link rel="stylesheet" href="{{asset('/css/mycode/admin/add_all_object.css')}}">

@section('mycss')
@endsection

@section('contents')
<div class="layouttitle">
    <section class="header">
        <div class="title">
            <h1>Create New Image</h1>
            <span>IShopApple Admin Panel</span>
        </div>
    </section>
    <section class="body">
        <h2>Image Information</h1>
            <p>Add information category detail , color of your image.</p>
            <form action="{{route('image.store')}}" method="post" enctype="multipart/form-data">
                @csrf
              
                
                <div>
                    <label for="categorydetail_id">Category Detail</label><br>
                    <select name="categorydetail_id" id="">
                        @foreach($categorydetail as $item)
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
                    <label for="images">Image</label><br>
                    <input type="file" name="images[]"  multiple id="images" required>
                </div>
                <button>Add</button>
            </form>
    </section>

</div>
@endsection

@section('myjs')

@end