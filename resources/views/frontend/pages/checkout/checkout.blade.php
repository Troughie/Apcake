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
            <div class="jumbotron text-center">
                <h1 class="display-3">{{ session('orderSuccess') }}</h1>
                <p class="lead"><strong>Hãy kiểm tra email</strong> Và xác nhận đơn hàng của bạn.</p>
                <hr>
                <p>
                    Có vấn đề gì? Hãy<a href="{{ route('contact') }}">Liên hệ với chúng tôi</a>
                </p>
                <p class="lead">
                    <a class="btn btn-primary btn-sm" href="{{ route('shop') }}" role="button">Tiếp tục mua sắm</a>
                </p>
            </div>
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
                            <div class="infouser" id="infouser">
                                @foreach ($addressuser as $item)
                                    <button class="btn btn-success fix" add_id="{{ $item->delivery_id }}">dia chi
                                        {{ $loop->iteration }}</button>
                                @endforeach
                                <small>Địa chỉ của bạn</small>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="kh_ten">Họ tên</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname"
                                        value="">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Choose the city</label>
                                    <select name="province" id="province" class="form-control  choose"
                                        onchange="changcity()">
                                        <option value="">--Select city--</option>
                                        @foreach ($address as $key => $item)
                                            <option value="{{ $item->_name }}">{{ $item->_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="">Choose Province</label>
                                    <select name="district" id="district"
                                        class="form-control input-sm m-bot15 province choose" onchange="changdistrict()">
                                        <option value="">--Select district--</option>

                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Choose Wards</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="">--Choose a commune--</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_dienthoai">Điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_email">Email</label>
                                    <input type="text" class="form-control" name="email" id="kh_email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>
                            <br>
                            <span id="saveinfo"><input type="checkbox" name="saveinfo" value="yes">Lưu thông tin cho
                                lần thanh toán sau</span>
                            <br>
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


    <script>
        $(document).ready(function() {
            $('.fix').click(function(e) {
                e.preventDefault()
                const add_id = $(this).attr('add_id')
                $.ajax({
                    url: '{{ route('user.changeAdd', Auth::id()) }}',
                    type: 'POST',
                    data: {
                        add_id: add_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('.title').html('change infomation')
                        $('#create').css('display', 'none')
                        $('#saveinfo').css('display', 'none')
                        $('#infomation').css('display', 'block')
                        $('#status').val('update')
                        $('#_tokenadd').val(res._token)
                        $('#province').val(res.province);
                        $('#fullname').val(res.fullname);
                        changcity()
                        setTimeout(() => {
                            $('#district').val(res.district);
                            changdistrict()
                        }, 1000);
                        $('#phone').val(res.phone);
                        setTimeout(() => {
                            $('#wards').val(res.ward);
                            console.log(res.ward)
                        }, 2000);

                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            })
        })
    </script>
    <script>
        function changcity() {
            $.ajax({
                url: '{{ route('user.ajaxRequest', ['id' => Auth::id()]) }}',
                type: 'POST',
                data: {
                    city: document.getElementById("province").value,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    const selectDistrict = $('#district');
                    const select = document.getElementById('district');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const options = response.data.map((item) => {
                        const option = document.createElement("option");
                        option.value = item._name;
                        option.text = item._prefix + ' ' + item._name;
                        return option;
                    });
                    options.sort().forEach((option) => {
                        select.appendChild(option);
                    });

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function changdistrict() {
            const add_id = $('.fix').attr('add_id');
            $.ajax({
                url: '{{ route('user.ajaxRequest', ['id' => Auth::id()]) }}',
                type: 'POST',
                data: {
                    district: document.getElementById("district").value,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    const district = document.getElementById('district').value;
                    const ward = document.getElementById('wards').value;
                    $.ajax({
                        url: '{{ route('user.changeAdd', Auth::id()) }}',
                        type: 'POST',
                        data: {
                            add_id: add_id,
                            district: district,
                            ward: ward
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                    console.log(response.data);
                    const select = document.getElementById('wards');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const selectDistrict = $('#wards');
                    const districtOptions = response.data.map((district) => {
                        return $('<option>').val(district._name).text(
                            `${district._prefix} ${district._name}`);
                    });
                    console.log(response.data)
                    selectDistrict.append(districtOptions);
                    $('#wards').val(ward);
                    $('#district').val(district);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
