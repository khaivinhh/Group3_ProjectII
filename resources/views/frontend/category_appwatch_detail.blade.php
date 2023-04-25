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
    @foreach($categorydetail->appwatchs->unique('color_id') as $item)
    <option value="{{ $item->colors->id }}">
        {{ $item->colors->name }}
    </option>
    @endforeach
</select>


<h3>size</h3>
<select name="size" id="size">
    @foreach($categorydetail->appwatchs->unique('size_id') as $item)
    <option value="{{ $item->sizes->id }}">
        {{ $item->sizes->name }}
    </option>
    @endforeach
</select>


<h3>capacity</h3>
<select name="capacity" id="capacity">
    @foreach($categorydetail->appwatchs->unique('capacity_id') as $item)
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
            let category_id = "{{$categorydetail->categories->id}}";
            let categorydetail_id = "{{$categorydetail->id}}";
            let color = $('#color').val();
            let size = $('#size').val();
            let capacity = $('#capacity').val();
            $.ajax({
                type: 'post',
                url: urladd,
                data: {
                    quantity: quantity,
                    category_id: category_id,
                    categorydetail_id:categorydetailid,
                    color:color,
                    size:size,
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