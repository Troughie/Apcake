@extends('layouts.master')
@section('main-content')
    <section class="cart_table_area p_100">
        <div class="container">
            <div class="route btn btn-secondary mb-5" style="margin-top:-100px"><a href="{{ url()->previous() }}"
                    class="text-light">back</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" style="white-space:nowrap">Kích thước</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($cart_items))
                            @foreach ($cart_items as $item)
                                <tr>
                                    <td>
                                        <img src="{{ URL::to('uploads/products/' . $item->cart_pro->image) }}"
                                            alt="" width="100" height="100px"
                                            style="object-fit: cover;image-rendering: pixelated;">
                                    </td>
                                    <td>{{ $item->cart_pro->name }}</td>
                                    <td>{{ $item->size }}</td>
                                    <td class="price">
                                        {{ number_format($pro_sizes[$item->size][$item->product_id]->price) . 'VND' }}</td>
                                    <td>
                                        <input type="number" min="1" class="quantity" name="cart_qty"
                                            value="{{ $item->quantity }}" style="width: 50px;"
                                            pro_id="{{ $item->product_id }}" data-old-qty="{{ $item->quantity }}">
                                    </td>
                                    <td class="total_price" id="total_price_{{ $item->product_id }}">
                                        {{ number_format($pro_sizes[$item->size][$item->product_id]->price * $item->quantity) . 'VND' }}
                                    </td>
                                    <td>

                                        <form method="GET" action="{{ route('user.delItem', $item->cart_id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            @method('DELETE')
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Student"
                                                onclick="return confirm("Confirm delete?")"><i class="fa fa-trash-o"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row cart_total_inner">
                <div class="col-lg-7"></div>
                <div class="col-lg-5">
                    <div class="cart_total_text">
                        <div class="cart_head">
                            Tổng tiền
                        </div>
                        <div class="total">
                            <h4>Total <span class="totalPrice">
                                    {{ number_format($cart_total_price) . 'VND' }}
                                </span></h4>
                        </div>
                        <div class="cart_footer">
                            <a class="pest_btn" href="{{ route('user.checkout') }}">Kiểm tra thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Table Area =================-->

    <!--================Newsletter Area =================-->
    <section class="newsletter_area">
        <div class="container">
            <div class="row newsletter_inner">
                <div class="col-lg-6">
                    <div class="news_left_text">
                        <h4>Tham gia danh sách tin tức của chúng tôi để nhận được tất cả các ưu đãi, giảm giá và các lợi ích
                            khác mới nhất</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="newsletter_form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter your email address">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Đăng ký ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('.quantity').change(function() {
            const item_qty = $(this).val()
            const pro_id = $(this).attr('pro_id')
            const old_qty = $(this).data('old-qty');
            $.ajax({
                url: '{{ route('user.updateQty') }}',
                type: 'POST',
                data: {
                    'item_qty': item_qty,
                    'pro_id': pro_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        alert(response.message)
                        $(`input[name='cart_qty'][pro_id=${pro_id}]`).val(response.qtyF);
                    } else {
                        $('.totalPrice').html('<span>' + (response.totalPrice).toLocaleString() +
                            'VND' +
                            '</span>')
                        $('#total_price_' + pro_id).html('<span>' + (response.total_item)
                            .toLocaleString() + 'VND' + '</span>');
                    }

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>
@endsection
