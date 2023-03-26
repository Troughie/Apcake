@extends('layouts.master')
@section('main-content')
    <section class="cart_table_area p_100">
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Preview</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($cart_items))
                            @foreach ($cart_items as $item)
                                <tr>
                                    <td>
                                        <img src="img/product/cart-img.jpg" alt="">
                                    </td>
                                    <td>{{ $item->cart_pro->name }}</td>
                                    <td class="price">${{ $item->cart_pro->price }}</td>
                                    <td>
                                        <input type="number" min="1" class="quantity"
                                            name="cart_qty"value="{{ $item->quantity }}" style="width: 50px;"
                                            pro_id="{{ $item->product_id }}" data-old-qty="{{ $item->quantity }}">
                                    </td>
                                    <td class="total_price" id="total_price_{{ $item->product_id }}">
                                        {{ $item->cart_pro->price * $item->quantity }}
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
                            <td>
                                <form class="form-inline" action="{{ route('user.coupon') }}" method="POST">
                                    @csrf
                                    <div id="coupon-wrapper" style="display: none">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Coupon code"
                                                name="coupon">
                                        </div>
                                        <button type="submit" class="btn">Apply Coupon</button>
                                    </div>
                                </form>
                                <button class="btn coupon" id="coupon" style="display: flex
								"
                                    onclick="myFunction()">you have
                                    coupon</button>
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                            </td>
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
                            Cart Total
                        </div>
                        <div class="sub_total">
                            <h5>Sub Total <span class="totalPrice">${{ $cart_total_price }}</span></h5>
                        </div>
                        <div class="total">
                            <h4>Total <span class="totalPrice">
                                    @if (session('success'))
                                        ${{ $new_total_price }}
                                    @else
                                        ${{ $cart_total_price }}
                                    @endif
                                </span></h4>
                        </div>
                        <div class="cart_footer">
                            <a class="pest_btn" href="{{ route('user.checkout') }}">Proceed to Checkout</a>
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
                        <h4>Join our Newsletter list to get all the latest offers, discounts and other benefits</h4>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="newsletter_form">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter your email address">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function myFunction() {
            var x = document.getElementById("coupon-wrapper");
            var y = document.getElementById("coupon");
            if (x.style.display === "none") {
                y.style.display = "none";
                x.style.display = "flex";
            } else {
                x.style.display = "none";
            }
        }
    </script>

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
                        $('.totalPrice').html('$' + response.totalPrice)
                        $('#total_price_' + pro_id).html('<span>' + response.total_item + '</span>');
                    }

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>
@endsection
