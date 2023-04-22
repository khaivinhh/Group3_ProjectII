@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<section>
    <h1>ON SELL</h1>
</section>
<section>
    <h1>LATEST PRODUCTS</h1>
</section>
<section>
    <h1>PRODUCT CATEGORIES</h1>
    <div class="category">
        @foreach($categorydetail as $item)
        <div class="item" onclick="submitForm('{{$item->id}}')">
            <form id="form-{{$item->id}}" action="{{ route('category_detail', [$item->id, $item->categories->name]) }}" method="GET">
                <img src="{{ asset($item->image) }}" alt="" width="50" height="50">
                <h1>{{$item->name}}</h1>
            </form>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('myjs')
<script>
    function submitForm(itemID) {
        document.getElementById("form-" + itemID).submit();
    }
</script>
@endsection