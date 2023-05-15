@extends('frontend/layout/layout')
@section('contents')
<div class="title">
    <h1>Check Out</h1>
    <a href="">Home</a>
    <span>/</span>
    <a href="">Check Out</a>
</div>
<div class="order">

    <form class="form" id="form_checkout">
        <h3>Billing Details</h3>
        <hr>
        <div class="infouser">

            <div class="f-l-name">
                <div>
                    <label for="name">Name</label><span class="name">_(required)</span><br>
                    <input type="text" value="{{$user->name}}" id="name" required>
                </div>
                <div>
                    <label for="email">Email</label><span class="email">_(required)</span><br>
                    <input type="email" value="{{$user->email}}" id="email" required>
                </div>
            </div>

            <div>
                <label for="phone">Phone</label><span class="phone">_(required)</span><br>
                <input type="text" value="{{$user->phone}}" id="phone" required>
            </div>

            <div>
                <label for="province">Province</label><span class="province">_(required)</span><br>
                <select name="province" id="province" required>
                    <option value=""> Select Province </option>
                </select>
            </div>

            <div>
                <label for="district">District</label><span class="district">_(required)</span><br>
                <select name="district" id="district" required>
                </select>
            </div>

            <div>
                <label for="address">Ward</label><span class="ward">_(required)</span><br>
                <select name="ward" id="ward" required>
                </select>
            </div>

            <div>
                <label for="address">Address</label><span class="address">_(required)</span><br>
                <input type="text" id="address" name="address" required>
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
                    <td>Total Amount : </td>
                    <td>${{$total}}</td>
                </tr>

                <tr>
                    <td>Discount : </td>
                    @if(isset($value))
                    <td>${{$total * $value / 100}}</td>
                    @else
                    <td>$0</td>
                    @endif
                </tr>
                <tr class="shipping">
                    <td>Total Shipping Fee : </td>
                    <td>$0</td>
                </tr>
                <tr class="total_billing">
                    <td>
                        <h3>
                            @if(isset($value))
                            @php
                            $discount = $total * $value / 100;
                            $total -= $discount;
                            @endphp
                            @endif
                            Total Price :

                        </h3>
                    </td>
                    <td>
                        <h3>${{$total}}</h3>
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
    function shipping() {
        if ($('#ward').val() == '' || $('#ward').val() == null) {
            $('.shipping').css('visibility', 'hidden')
        } else {
            $('.shipping').css('visibility', 'visible')
        }
    }
    shipping()


    $('.place_order').on('click', function(e) {
        if ($("#form_checkout")[0].checkValidity()) {
            let province = $('#province option:selected').text();
            let district = $('#district option:selected').text();
            let ward = $('#ward option:selected').text();
            let address = $('#address').val();
            let total = "{{$total}}";
            let discount_code = $('#discount_code').val();
            let url = "{{route('place_order')}}";
            console.log(discount_code);
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    province: province,
                    district: district,
                    ward: ward,
                    address: address,
                    total: total,
                    discount_code: discount_code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.text-2').text('You have 1 order please check in profile');
                    notification_complete();
                }
            });
        } else {
            validate();
        }
    })

    var all_tag = $("#form_checkout")[0].querySelectorAll('input, select');

    all_tag.forEach((item) => {
        if (item.tagName == 'INPUT') {
            item.addEventListener('keyup', function() {
                validate()
            });
        } else if (item.tagName == 'SELECT') {
            item.addEventListener('change', function() {
                validate()
            });
        }
    });


    function validate() {
        var invalidInputs = $("#form_checkout")[0].querySelectorAll(':invalid');
        all_tag.forEach((item) => {
            $("." + item.id + "").css('display', 'none')
        })
        var missingFields = Array.from(invalidInputs).map(function(tag) {
            $("." + tag.id + "").css('display', '-webkit-inline-box')
        });
    }
</script>
@endsection