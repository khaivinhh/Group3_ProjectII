@extends('frontend/layout/layout')
@section('mycss')
@endsection



@section('contents')
<style>
    img {
        max-width: 150px;
        height: auto;
    }
</style>




<h1>{{$categorydetail->name}}</h1>
<div class="check">

</div>


<h3>color</h3>
<select name="color" id="color">
    @foreach($categorydetail->images->unique('color_id') as $item)
    <option value="{{ $item->colors->id }}">
        {{ $item->colors->name }}
    </option>
    @endforeach
</select>


<h3>ram</h3>
<select name="ram" id="ram">
    @foreach($categorydetail->iphones->unique('ram_id') as $item)
    <option value="{{ $item->rams->id }}">
        {{ $item->rams->name }}
    </option>
    @endforeach
</select>


<h3>capacity</h3>
<select name="capacity" id="capacity">
    @foreach($categorydetail->iphones->unique('capacity_id') as $item)
    <option value="{{ $item->capacitys->id }}">
        {{ $item->capacitys->name }}
    </option>
    @endforeach
</select>





<button class="addtocart">Add To Cart</button>
@endsection


@section('myjs')
<script>
    $(document).ready(function() {
        var images = @json($categorydetail->images);

        function generateImageHtml(valuecolor) {
            var container = '';
            $.each(images, function(index, value) {
                if (valuecolor == value.color_id) {
                    var imagePath = "{{ asset(':path') }}".replace(':path', value.path);
                    container += '<img src="' + imagePath + '" alt="">';
                }
            });
            return container;
        }
        // Gọi lại hàm generateImageHtml để tạo ra nội dung của div "check" khi trang được tải lần đầu
        $('.check').html(generateImageHtml($('#color').val()));
        // Gọi lại hàm generateImageHtml khi giá trị của select thay đổi
        $('#color').change(function() {
            var valuecolor = $('#color').val();
            $('.check').html(generateImageHtml(valuecolor));
        });


        const urladd = "{{route('add_to_cart')}}";
        $('.addtocart').click(function(e) {
            e.preventDefault();
            let quantity = 1;
            let categoryname = "{{$categorydetail->categories->name}}";
            let cateid = "{{$categorydetail->id}}";
            let color = $('#color').val();
            let ram = $('#ram').val();
            let capacity = $('#capacity').val();
            $.ajax({
                type: 'post',
                url: urladd,
                data: {
                    quantity: quantity,
                    categoryname: categoryname,
                    categorydetail_id:cateid,
                    color:color,
                    ram:ram,
                    capacity:capacity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert(data.info);
                }
            });


        });

    });
</script>
@endsection