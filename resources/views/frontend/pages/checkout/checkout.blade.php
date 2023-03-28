@extends('layouts.master')
@section('main-content')
    <style>
        body {
            color: #5a5a5a;
        }


        /* CUSTOMIZE THE CAROUSEL
                                                                                                                                                                                                                                                                                                                                                                                                                                                            -------------------------------------------------- */

        /* Carousel base class */
        .carousel {
            margin-bottom: 4rem;
        }

        /* Since positioning the image, we need to help out the caption */
        .carousel-caption {
            bottom: 3rem;
            z-index: 10;
            color: white;
            text-shadow: 2px 2px 5px black;

        }


        /* Declare heights because of positioning of img element */
        .carousel-item {
            height: 42rem;
        }

        .carousel-item>img {
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            height: 42rem;
        }


        /* MARKETING CONTENT
                                                                                                                                                                                                                                                                                                                                                                                                                                                            -------------------------------------------------- */

        /* Center align the text within the three columns below the carousel */
        .marketing .col-lg-4 {
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .marketing h2 {
            font-weight: 400;
        }

        .marketing .col-lg-4 p {
            margin-right: .75rem;
            margin-left: .75rem;
        }


        /* Featurettes
                                                                                                                                                                                                                                                                                                                                                                                                                                                            ------------------------- */

        .featurette-divider {
            margin: 5rem 0;
            /* Space out the Bootstrap <hr> more */
        }

        /* Thin out the marketing headings */
        .featurette-heading {
            font-weight: 300;
            line-height: 1;
            letter-spacing: -.05rem;
        }


        /* RESPONSIVE CSS
                                                                                                                                                                                                                                                                                                                                                                                                                                                            -------------------------------------------------- */

        @media (min-width: 40em) {

            /* Bump up size of carousel content */
            .carousel-caption p {
                margin-bottom: 1.25rem;
                font-size: 1.25rem;
                line-height: 1.4;
            }

            .featurette-heading {
                font-size: 50px;
            }
        }

        @media (min-width: 62em) {
            .featurette-heading {
                margin-top: 7rem;
            }
        }

        .hinhdaidien {
            width: 150px;
            height: 150px;
        }
    </style>
    <main role="main">
        <!-- Block content - Đục lỗ trên giao diện bố cục chung, đặt tên là `content` -->
        @if (session('orderSuccess'))
            <div class="alert alert-success">{{ session('orderSuccess') }}</div>
        @else
            <div class="container mt-4">
                <form class="needs-validation" name="frmthanhtoan" method="post" action="{{ route('user.firmCheckout') }}">
                    @csrf
                    <div class="py-5 text-center">
                        <i class="fa fa-credit-card fa-4x" aria-hidden="true"></i>
                        <h2>Thanh toán</h2>
                        <p class="lead">Vui lòng kiểm tra thông tin Khách hàng, thông tin Giỏ hàng trước khi Đặt hàng.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Giỏ hàng</span>
                                <span class="badge badge-secondary badge-pill">{{ $cart_total_quantity }}</span>
                            </h4>
                            <ul class="list-group mb-3">
                                @foreach ($cart as $item)
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0">{{ $item->cart_pro->name }}</h6>
                                            <small class="text-muted">${{ $item->cart_pro->price }} x
                                                {{ $item->quantity }}</small>
                                        </div>
                                        <span class="text-muted">${{ $item->cart_pro->price * $item->quantity }}</span>
                                    </li>
                                @endforeach
                                <li class="list-group-item ">
                                    <div class="d-flex justify-content-between">
                                        <small>discount</small>
                                        <small id="discount">0</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small>ship</small>
                                        <small id="ship">0</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Tổng thành tiền</span>
                                        <input type="hidden" name="total" value="{{ $cart_total_price }}">
                                        <strong id="totalPrice">${{ $cart_total_price }}</strong>
                                    </div>

                                </li>
                            </ul>


                            <div class="input-group" id="coupon-hide">
                                <div id="coupon-wrapper " class="d-flex flex-row">
                                    <div class="input-group-append">
                                        <input type="text" class="form-control" id="coupon"
                                            placeholder="Mã khuyến mãi"style="width: 95%;" name="coupon">
                                    </div>
                                    <button type="submit" id="add-coup" class="btn btn-secondary">Xác nhận</button>
                                </div>
                            </div>
                            <strong id="coupon_code"></strong>
                        </div>
                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">Thông tin khách hàng</h4>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="kh_ten">Họ tên</label>
                                    <input type="text" class="form-control" name="fullname" id="kh_ten"
                                        value="{{ $user->deliveryAddress->fullname ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_diachi">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" id="kh_diachi"
                                        value="{{ $user->deliveryAddress->ward ?? '' }},{{ $user->deliveryAddress->district ?? '' }},{{ $user->deliveryAddress->province ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_dienthoai">Điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="kh_dienthoai"
                                        value="{{ $user->deliveryAddress->phone ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_email">Email</label>
                                    <input type="text" class="form-control" name="email" id="kh_email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>

                            <h4 class="mb-3">Hình thức thanh toán</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="redirect" id="cod1"
                                    value="cod">
                                <label class="form-check-label" for="cod1">
                                    Cod
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="redirect" id="vnpay2"
                                    value="vnpay">
                                <label class="form-check-label" for="vnpay2">
                                    Vnpay
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="redirect" id="momo3"
                                    value="momo">
                                <label class="form-check-label" for="momo3">
                                    MOMO
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="redirect" id="bank4"
                                    value="bank">
                                <label class="form-check-label" for="bank4">
                                    Ngân hàng
                                </label>
                            </div>
                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Đặt
                                hàng</button>
                        </div>
                    </div>
                </form>

            </div>
        @endif
        <!-- End block content -->
    </main>
    <script>
        $('#add-coup').click(function(e) {
            e.preventDefault()
            const coupon = $('#coupon').val()
            $.ajax({
                url: '{{ route('user.coupon') }}',
                type: 'POST',
                data: {
                    'coupon': coupon,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response.orderCoup)
                    if (response.status == true) {
                        $('#totalPrice').html('<span>' + '$' + response.data + ' </span>')
                        $('#coupon_code').html('<span>' + response.coupon_code + '</span>')
                        $('#discount').html('<span>' + '-$' + response.discount + '</span>')
                        document.getElementById("coupon-hide").style.display = "none";
                    } else {
                        $('#coupon_code').html('<span>' + response.coupon_code + '</span>')
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText)


                }
            });
        })
    </script>

@endsection
