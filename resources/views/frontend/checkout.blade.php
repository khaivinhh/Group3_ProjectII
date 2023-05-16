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
                    <option value="" disabled selected hidden></option>
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
            $quantity = 0;
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
                    <td>
                        <div class="infopro_detail">
                            <img src="{{asset($item->product->image)}}" alt="" width="50">
                            <div>
                                <p>{{$item->product->categorydetails->name}}</p>
                                <p>{{$item->product->rams->name.'/'.$item->product->capacities->name.'/'.$item->product->colors->name}}</p>
                            </div>
                            <p>x {{$item->quantity}}</p>
                        </div>
                    </td>
                    <td>${{$item->product->price * $item->quantity}}</td>
                </tr>
                @php
                $total += $item->product->price * $item->quantity;
                $quantity += $item->quantity;
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
                    <td class="discount_price">$0</td>
                </tr>
                <tr class="shipping">
                    <td>Total Shipping Fee : </td>
                    <td class="fee">$0</td>
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
                        <h3 class="total_price"></h3>
                    </td>
                </tr>
            </tfoot>
        </table>
        <p class="notification_coupon"></p>
        <form id="form_coupon">
            <input type="text" id="discount_code" placeholder="Enter your coupon code" required>
            <button class="coupon">Coupon</button>
        </form>
        <button class="place_order">Place Order</button>
    </div>
</div>



@endsection


@section('myjs')
<script>
    function transport_fee(callback) {
        var myHeaders = new Headers();
        let insurance_value = "{{$total*23500}}";
        let insurance_quantity = "{{$quantity}}";
        let to_district_id = selectElement_district.value
        let to_ward_code = selectElement_ward.value
        myHeaders.append("token", "156086da-ee0e-11ed-a281-3aa62a37e0a5");
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "service_id": 53322,
            "service_type_id": 2,
            "insurance_value": parseInt(insurance_value),
            "coupon": null,
            "from_district_id": 3193,
            "to_district_id": parseInt(to_district_id),
            "to_ward_code": parseInt(to_ward_code),
            "weight": 250 * insurance_quantity,
            "width": 7 * insurance_quantity,
            "height": 3 * insurance_quantity,
            "length": 14 * insurance_quantity
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee", requestOptions)
            .then(response => response.text())
            .then(result => {
                var result_total = JSON.parse(result)
                callback(result_total.data.total)

            })

            .catch(error => console.log('error', error));
    }

    selectElement_ward.addEventListener("change", function() {
        transport_fee(function(total) {
            fee = Math.round((total / 23500));
            $('.fee').text('$' + fee);
            total_price(total_order, fee, discount)
        });
    })


    var total_order = parseInt("{{$total}}");
    var fee = 0;
    var discount = 0;
    var coupon_value = 0;

    function total_price(total_order, fee, discount) {
        $('.total_price').text("$" + (total_order + fee - discount))
        return total_order + fee - discount;
    }
    total_price(total_order, fee, discount)


    $('.coupon').on('click', function(e) {
        e.preventDefault()
        if ($('#form_coupon')[0].checkValidity()) {
            $.ajax({
                type: 'post',
                url: "{{route('check_coupon')}}",
                data: {
                    name: $('#discount_code').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('.notification_coupon').text(data.notification);
                    if (data.value) {
                        coupon_value = data.value;
                        discount = Math.round(total_order / 100 * data.value);
                        $('.discount_price').text("$" + discount);
                        total_price(total_order, fee, discount);
                    }
                }
            });
        } else {
            return false;
        }

    })





    $('.place_order').on('click', function(e) {
        if ($("#form_checkout")[0].checkValidity()) {
            let province = $('#province option:selected').text();
            let district = $('#district option:selected').text();
            let ward = $('#ward option:selected').text();
            let address = $('#address').val();
            let total = "{{$total}}";
            let discount_value = discount;
            let url = "{{route('place_order')}}";
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    province: province,
                    district: district,
                    ward: ward,
                    address: address,
                    total: total_price(total_order, fee, discount),
                    discount_value: coupon_value,
                    transport_fee: fee,
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
                if (item.value.length > 0) {
                    $("." + item.id + "").css('display', 'none')
                } else {
                    $("." + item.id + "").css('display', '-webkit-inline-box')
                }
            });
        } else if (item.tagName == 'SELECT') {
            item.addEventListener('change', function() {
                if (item.value == '' || item.value == null) {
                    $("." + item.id + "").css('display', '-webkit-inline-box')
                } else {
                    $("." + item.id + "").css('display', 'none')

                }
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