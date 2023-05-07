@extends('frontend/layout/layout')
@section('mycss')
<link rel="stylesheet" href="{{asset('/css/mycode/frontend/checkout.css')}}">

@endsection

@section('contents')

<div class="title">
    <h1>Check Out</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Check Out</a>
</div>
<div class="order">

    <form class="form">
        <h3>Billing Details</h1>
            <hr>
            <div class="infouser">

                <div class="f-l-name">
                    <div>
                        <label for="">First name</label><br>
                        <input type="text" value="{{$user->first_name}}">
                    </div>
                    <div>
                        <label for="">Last name</label><br>
                        <input type="text" value="{{$user->last_name}}">
                    </div>
                </div>

                <div>
                    <label for="">Email</label><br>
                    <input type="email" value="{{$user->email}}">
                </div>
                <div>
                    <label for="">Address</label><br>
                    <input type="text" value="{{$user->address}}" name="address" class="address">
                </div>
                <div>
                    <label for="">Phone</label><br>
                    <input type="text" value="{{$user->phone}}">
                </div>
            </div>
    </form>
    <div class="infopro">
        <h3>Your Order</h3>
        <hr>
        <table>
            @php
            $total = 0;
            @endphp
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Total</td>
                </tr>

            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>{{$item->product->categorydetails->name}} x {{$item->quantity}}</td>
                    <td>${{$item->product->price * $item->quantity}}</td>
                </tr>
                @php
                $total += $item->product->price * $item->quantity
                @endphp
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">
                        <h3>
                            @if(isset($value))
                            @php
                            $discount = $total * $value / 100;
                            $total -= $discount;
                            @endphp
                            @endif
                            Total Price : {{$total}}

                        </h3>

                    </td>
                </tr>
            </tfoot>
        </table>
        @if(isset($notification))
        <p class="notification_coupon">{{$notification}}</p>
        @endif
        <form action="{{route('check_coupon',$total)}}" method="POST">
            @csrf
            @if(isset($discount_code))
            <input type="text" id="discount_code" name="name" placeholder="Enter your coupon code" value="{{$discount_code}}">

            @else
            <input type="text" id="discount_code" name="name" placeholder="Enter your coupon code">

            @endif
            <button class="coupon" type="submit">Coupon</button>
        </form>
        <button class="place_order">Place Order</button>
    </div>
</div>



@endsection


@section('myjs')
<script>
   
    $(document).ready(function() {
        $('.place_order').click(function(e) {
            let address = $('.address').val();
            let total = "{{$total}}";
            let discount_code = $('#discount_code').val();
            let url = "{{route('place_order')}}";
            console.log(discount_code);
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    address : address,
                    total : total,
                    discount_code : discount_code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.text-2').text('You have 1 order please check in profile');
                    notification_complete();
                    // window.location.href = "{{ route('home') }}";
                }
            });
        })

    })
</script>
@endsection