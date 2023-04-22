@extends('frontend/layout/layout')
@section('mycss')
@endsection

@section('contents')
<h1>profile page</h1>
<form action="{{route('signout_user')}}">
    <button>sign-out</button>
</form>
@endsection

@section('myjs')
@endsection