@extends('layouts.master')
@section('main-content')
    <style>
        body {
            color: #5a5a5a;
        }

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

                <div class="py-5 text-center">
                    <i class="fa fa-credit-card fa-4x" aria-hidden="true"></i>
                    <h2>Thanh toán</h2>
                    <p class="lead">Vui lòng kiểm tra thông tin Khách hàng, thông tin Giỏ hàng trước khi Đặt hàng.</p>
                </div>

                <div class="d-flex flex-row">
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
                                        <small
                                            class="text-muted">{{ number_format($pro_sizes[$item->size][$item->product_id]->price) . 'VND' }}
                                            x
                                            {{ $item->quantity }}</small>
                                    </div>
                                    <span
                                        class="text-muted">{{ number_format($pro_sizes[$item->size][$item->product_id]->price * $item->quantity) . 'VND' }}</span>
                                </li>
                            @endforeach
                            <li class="list-group-item mt-4 card rounded-3">
                                <div class=" justify-content-between align-items-center" id="discount-coup"
                                    style="display: none">
                                    <div class="d-flex align-items-center">
                                        <small id="code_coupon"
                                            style="width:50%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;paddint-right:10px">
                                        </small>
                                        <b style="cursor: pointer" id="remove-coup">Bỏ mã </b>
                                    </div>
                                    <small id="discount"></small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small>Phí vận chuyển</small>
                                    <small id="ship">0</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Tổng thành tiền</span>
                                    <input type="hidden" name="total" value="{{ $cart_total_price }}">
                                    <strong id="totalPrice">{{ number_format($cart_total_price) . 'VND' }}</strong>
                                </div>
                            </li>
                        </ul>
                        <strong id="coupon_code2"></strong>
                        <button
                            class="btn btn-outline-primary  btn-sm w-100 d-flex align-items-center justify-content-between"
                            data-toggle="modal" data-target="#sortModal" title="Delete"><span> Nhấn vào đây để thêm mã
                                giảm
                                giá</span> <i class="fa-solid fa-percent"></i></button>
                    </div>
                    <form class="needs-validation col-md-8" name="frmthanhtoan" method="post"
                        action="{{ route('user.firmCheckout') }}">
                        @csrf
                        <input type="hidden" class="form-control" id="coupon2" name="coupon2">
                        <div class=" order-md-1 card p-4 mb-4"
                            style="box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;">
                            @if ($errors->any())
                                @foreach ($errors->all() as $item)
                                    <div class="alert alert-danger">{{ $item }}</div>
                                @endforeach
                            @endif
                            <h4 class="mb-3">Thông tin khách hàng</h4>
                            <div class="infouser" id="infouser">
                                @if (isset($addressuser))
                                    @foreach ($addressuser as $item)
                                        <button class="btn btn-success fix" add_id="{{ $item->delivery_id }}">Địa chỉ
                                            {{ $loop->iteration }}</button>
                                    @endforeach
                                    <small>Địa chỉ của bạn</small>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="kh_ten">Họ tên</label>
                                    <input type="text" class="form-control" name="fullname" id="fullname"
                                        value="{{ old('fullname') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Chọn tỉnh/thành phố</label>
                                    <select name="province" id="province" class="form-control  choose"
                                        onchange="changcity()" required>
                                        <option value="">--tỉnh/thành phố--</option>
                                        @foreach ($address as $key => $item)
                                            <option value="{{ $item->_name }}">{{ $item->_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <label for="">Chọn quận/huyện</label>
                                    <select name="district" id="district" required
                                        class="form-control input-sm m-bot15 province choose" onchange="changdistrict()">
                                        <option value="">--quận/huyện--</option>

                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Chọn xã/thị trấn</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards"
                                        required>
                                        <option value="">--xã/thị trấn--</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="kh_dienthoai">Điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="kh_email">Email</label>
                                    <input type="text" class="form-control" name="email" id="kh_email" required
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
                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Đặt
                                hàng</button>
                        </div>
                        <div class="modal fade" id="sortModal" class="sortModal" role="dialog">
                            <div class="modal-dialog ">
                                <!-- Modal content-->
                                <div class="modal-content w-70">
                                    <div class="modal-header ">
                                        <h4 class="modal-title">Nhập mã giảm giá</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group" id="coupon-hide">
                                            <div id="coupon-wrapper " class="d-flex flex-row">
                                                <div class="input-group-append">
                                                    <input type="text" class="form-control" id="coupon"
                                                        placeholder="Mã khuyến mãi"style="width: 95%;" name="coupon">
                                                </div>
                                                <button type="submit" id="add-coup" class="btn btn-secondary">Xác
                                                    nhận</button>
                                            </div>
                                        </div>
                                        <strong id="coupon_code"></strong>

                                        <ul class="mr-5" style="margin-left:-50px" id="coupon-hide2">
                                            <li>--Mã giảm giá có thể sử dụng --</li>
                                            @foreach ($promotions as $item)
                                                <li
                                                    class="card mt-2 p-3 w-100 d-flex flex-row justify-content-between align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <b>{{ $item['discountAmount'] }}%</b><small>Gía tiền tối thiểu
                                                            {{ number_format($item['minprice']) . 'VND' }}</small>
                                                        <small>Hạn sử dụng {{ $item['endDate'] }}</small>
                                                    </div>
                                                    <input type="radio" name="value-coup" class="value-coup"
                                                        value="{{ $item['code'] }}">
                                                </li>
                                            @endforeach
                                            <li class="mt-5">--Mã giảm giá chưa thể sử dụng --</li>
                                            @foreach ($promotion_cant_use as $item)
                                                <li class="card mt-2 p-3 w-100 d-flex flex-row justify-content-between align-items-center "
                                                    style="background-color: #fff;opacity: 0.4;">
                                                    <div class="d-flex flex-column">
                                                        <b>{{ $item['discountAmount'] }}%</b><small>Gía tiền tối thiểu
                                                            {{ number_format($item['minprice']) . 'VND' }}</small>
                                                        @if ($item['endDate'] <= now())
                                                            <small>Mã đã hết hạn {{ $item['endDate'] }}</small>
                                                        @elseif($item['startDate'] > now())
                                                            <small>Chưa tới thời gian giảm giá
                                                                {{ $item['startDate'] }}</small>
                                                        @else
                                                            <small>Hạn sử dụng {{ $item['endDate'] }}</small>
                                                        @endif
                                                    </div>
                                                    <input type="radio" name="value-coup" class="value-coup"disabled
                                                        value="{{ $item['code'] }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>



            </div>
        @endif
        <!-- End block content -->

    </main>

    <script>
        $('#remove-coup').click(function(e) {
            e.preventDefault()
            $.ajax({
                url: '{{ route('user.removeCoup') }}',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(res) {
                    $('#discount-coup').css('display', 'none')
                    $("#coupon-hide").css('display', 'block')
                    $("#coupon-hide2").css('display', 'block')
                    $('#coupon').val('')
                    $('#coupon_code2').html(res.counpon_code)
                    $('#totalPrice').html((res.cart_total).toLocaleString())
                },
                error: function(xhr) {
                    console.log(xhr.responseText)
                }
            });
        })

        $('.value-coup').click(function(e) {
            var value_coup = $(this).val()
            $('#coupon').val(value_coup)
            $('#coupon2').val(value_coup)
        })
    </script>

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
                        $('#totalPrice').html('<span>' + (response.data).toLocaleString() + ' VND' +
                            ' </span>')
                        $('#coupon_code').html('<span>' + response.coupon_code + '</span>')
                        $('#discount').html('<span>' + '-' + (response.discount).toLocaleString() +
                            ' VND' + '</span>')
                        $('#coupon_code2').html('')
                        $("#coupon-hide").css('display', 'none')
                        $("#coupon-hide2").css('display', 'none')
                        $('#discount-coup').css('display', 'flex')
                        $('#code_coupon').html('coupon ' + response.coupon)
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
