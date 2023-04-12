@extends('layouts.master')
@section('main-content')
    <style>
        .rating input[type="radio"]:not(:nth-of-type(0)) {
            /* hide visually */
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        .rating [type="radio"]:not(:nth-of-type(0))+label {
            display: none;
        }

        label[for]:hover {
            cursor: pointer;
        }

        .rating .stars label:before {
            content: "★";
        }

        .stars label {
            color: lightgray;
        }

        .stars label:hover {
            text-shadow: 0 0 1px #000;
        }

        .rating [type="radio"]:nth-of-type(1):checked~.stars label:nth-of-type(-n+1),
        .rating [type="radio"]:nth-of-type(2):checked~.stars label:nth-of-type(-n+2),
        .rating [type="radio"]:nth-of-type(3):checked~.stars label:nth-of-type(-n+3),
        .rating [type="radio"]:nth-of-type(4):checked~.stars label:nth-of-type(-n+4),
        .rating [type="radio"]:nth-of-type(5):checked~.stars label:nth-of-type(-n+5) {
            color: orange;
        }

        .rating [type="radio"]:nth-of-type(1):focus~.stars label:nth-of-type(1),
        .rating [type="radio"]:nth-of-type(2):focus~.stars label:nth-of-type(2),
        .rating [type="radio"]:nth-of-type(3):focus~.stars label:nth-of-type(3),
        .rating [type="radio"]:nth-of-type(4):focus~.stars label:nth-of-type(4),
        .rating [type="radio"]:nth-of-type(5):focus~.stars label:nth-of-type(5) {
            color: darkorange;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
    </style>
    <section class="product_details_area p_100">
        <div class="container">
            <div class="row product_d_price">
                <div class="col-lg-4 " style="margin-right:100px">
                    <div>
                        <img src="{{ URL::to('uploads/products/' . $product[0]->productSize->image) }}" alt=""
                            class="picture" style="width: 100% ;height:100%">
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('addcart') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="product_details_text">
                            <fieldset class="rating" style="margin-bottom: -6px">
                                @if ($review->avg('rating') !== null)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $reviewShow->avg('rating'))
                                            <input id="demo-{{ $i }}" type="radio" name="review"
                                                class="review" value="{{ $i }}" checked disabled>
                                            <label for="demo-{{ $i }}">{{ $i }}star</label>
                                        @else
                                            <input id="demo-{{ $i }}" type="radio" name="review"
                                                class="review" value="{{ $i }}" disabled>
                                            <label for="demo-{{ $i }}">{{ $i }}star</label>
                                        @endif
                                    @endfor
                                @endif
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label for="demo-{{ $i }}" aria-label="{{ $i }} star"
                                            title="{{ $i }} star"></label>
                                    @endfor
                                </div>
                            </fieldset>
                            <h4>{{ $product[0]->productSize->name }}</h4>
                            <p>{{ $product[0]->productSize->description ?? 'Chưa có tiêu đề' }}</p>
                            <h5>Price: <span id="price">{{ number_format($product[0]->price) . ' VND' }}</span></h5>
                            <div class="quantity_box">
                                <label for="quantity">Số lượng mua :</label>
                                <input type="hidden" name="pro_id" class="pro_id"
                                    value="{{ $product[0]->productSize->product_id }}">
                                <input class="pro_qty" type="number" id="pro_qty" name="pro_qty" value="1"
                                    min="1" max="{{ $product[0]->instock }}">
                                <div>
                                    <label for="status">Số lượng: </label>
                                    <span id="stock" class="text-success">{{ $product[0]->instock }}</span>
                                </div>

                                <input type="hidden" name="pro_id" value="{{ $product[0]->productSize->product_id }}">
                                <input type="hidden" name="size_id" id="size_id" value="">

                                <span>
                                    <select name="pro_size" id="size" class="form-select"
                                        pro_id="{{ $product[0]->productSize->product_id }}" required>
                                        <option value="">--Chọn size--</option>
                                        @foreach ($product as $item)
                                            <option value="{{ $item->size }}">{{ $item->size }}</option>
                                        @endforeach
                                    </select>
                                    <span class="alert alert-danger" style="display:none">-></span>
                                </span>
                            </div>
                            <button class="pink_more add_to_cart" id="add_to_cart">Thêm vào giỏ hàng</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="product_tab_area">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Miêu tả</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                    aria-controls="nav-contact" aria-selected="false">Đánh giá
                    ({{ $reviewShow->count('comment') }})</a>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    {{ $product[0]->productSize->description ?? 'Khong co tieu de' }}
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @if (count($arr_filtered) !== 0 &&
                            $review &&
                            Auth::check() &&
                            $review->count('_token') < count($arr_filtered) &&
                            end($arr_filtered)->order->status_id !== 4)
                        <form class="mb-3" id="rating" style="display: block">
                            @csrf
                            <div>
                                <fieldset class="rating">
                                    <legend>Đánh giá</legend>

                                    <input id="demo-1" type="radio" name="review" class="review" value="1">
                                    <label for="demo-1">1 star</label>
                                    <input id="demo-2" type="radio" name="review" class="review" value="2">
                                    <label for="demo-2">2 stars</label>
                                    <input id="demo-3" type="radio" name="review" class="review" value="3">
                                    <label for="demo-3">3 stars</label>
                                    <input id="demo-4" type="radio" name="review" class="review" value="4">
                                    <label for="demo-4">4 stars</label>
                                    <input id="demo-5" type="radio" name="review" class="review" value="5">
                                    <label for="demo-5">5 stars</label>

                                    <div class="stars">
                                        <label for="demo-1" aria-label="1 star" title="1 star"></label>
                                        <label for="demo-2" aria-label="2 stars" title="2 stars"></label>
                                        <label for="demo-3" aria-label="3 stars" title="3 stars"></label>
                                        <label for="demo-4" aria-label="4 stars" title="4 stars"></label>
                                        <label for="demo-5" aria-label="5 stars" title="5 stars"></label>
                                    </div>

                                </fieldset>
                                <input type="hidden" class="pro_id" value="{{ $product[0]->productSize->product_id }}">
                            </div>
                            <textarea type="text" placeholder="Ý kiến của bạn" name="comment" id="comment" rows="4"
                                class="form-control mt-4"></textarea>
                            <div class="d-flex flex-col my-5">
                                <button class="btn btn-primary p-2 mb-1" id="proceed" type="submit">Đăng</button>
                            </div>
                        </form>
                    @endif

                    @if (count($review) > 0)
                        @foreach ($review as $item)
                            @if ($item->status == 'Show')
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <p>{{ $item->comment ?? '' }}</p>
                                        <div class="d-flex justify-content-between align-items-center">

                                            {{-- Rating and name user --}}
                                            <div>
                                                <div>
                                                    <fieldset class="rating" style="margin-bottom: -6px">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $item->rating)
                                                                <input id="demo-{{ $i }}" type="radio"
                                                                    name="review" class="review"
                                                                    value="{{ $i }}" checked disabled>
                                                                <label
                                                                    for="demo-{{ $i }}">{{ $i }}star</label>
                                                            @else
                                                                <input id="demo-{{ $i }}" type="radio"
                                                                    name="review" class="review"
                                                                    value="{{ $i }}" disabled>
                                                                <label
                                                                    for="demo-{{ $i }}">{{ $i }}star</label>
                                                            @endif
                                                        @endfor
                                                        <div class="stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <label for="demo-{{ $i }}"
                                                                    aria-label="{{ $i }} star"
                                                                    title="{{ $i }} star"></label>
                                                            @endfor
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <img class="rounded-circle" style="width: 100px;height:100px"
                                                        src="data:image/jpeg;base64,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"
                                                        alt="avatar" />
                                                    <div class="ml-2">
                                                        <small>Bình luận vào: {{ $item->created_at }}</small><br>
                                                        <h3>
                                                            <span>@</span>{{ $item->user_review->name }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($item->feedback))
                                    <div class="card ml-5 mb-4">
                                        <div class="card-body">
                                            <p>{{ $item->feedback->content }}</p>
                                            <div class="d-flex justify-content-between align-items-center">

                                                {{-- Rating and name user --}}
                                                <div class="d-flex flex-row align-items-center">
                                                    <img style="width: 25px;height:25px"src="data:image/jpeg;base64,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"
                                                        alt="avatar" width="25" height="25" />
                                                    <p class="small mb-0 mx-2">
                                                        Admin
                                                    </p>
                                                    <span class="ml-4">{{ $item->created_at }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="card">
                                    <strong>Chưa có bình luận nào</strong>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="card">
                            <strong>Chưa có bình luận nào</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </section>
    <!--================End Product Details Area =================-->

    <!--================Similar Product Area =================-->
    <section class="similar_product_area">
        <div class="container" style=";overflow: hidden;padding:100px 0">
            <div class="main_title">
                <h2>Sản phẩm tương tự</h2>
            </div>
            <div class="d-flex flex-row w-25">
                @foreach ($product_similar->products as $item)
                    @if ($item->product_id !== $category->product_id)
                        <div class="container">
                            <div class="card" style="border-radius: 30px;">
                                <img src="{{ URL::to('uploads/products/' . $item->image ?? 'resize52.png') }}"
                                    alt="" class="picture"
                                    style="height:300px;width:270px;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0">{{ $item->name }}</h5>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between mb-3">

                                        <div class="text-dark mb-0">
                                            <b>{{ number_format(\App\Models\Size::where('product_id', $item->product_id)->first('price')->price) . ' VND' }}
                                            </b>
                                        </div>
                                        <div class=" mb-0 mt-2 text-success">Số lượng:
                                            <span
                                                class="fw-bold">{{ \App\Models\Size::where('product_id', $item->product_id)->get()->sum('instock') }}</span>
                                        </div>

                                    </div>

                                    <div class="d-flex flex-row justify-content-center">
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">Xem
                                            chi tiết
                                        </a>
                                        <button class="btn ml-2 btn-xs whilelist">
                                            <i class="fa fa-heart" class="heart" aria-hidden="true"
                                                style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!--================End Similar Product Area =================-->

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
                            <input type="text" class="form-control" name="email"
                                placeholder="Enter your email address">
                            <input type="text" class="form-control" name="name" placeholder="Enter your name">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Newsletter Area =================-->

    <!--================Footer Area =================-->
    <footer class="footer_area">
        <div class="footer_widgets">
            <div class="container">
                <div class="row footer_wd_inner">
                    <div class="col-lg-3 col-6">
                        <aside class="f_widget f_about_widget">
                            <img src="img/footer-logo.png" alt="">
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui bland itiis praesentium
                                voluptatum deleniti atque corrupti.</p>
                            <ul class="nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-3 col-6">
                        <aside class="f_widget f_link_widget">
                            <div class="f_title">
                                <h3>Quick links</h3>
                            </div>
                            <ul class="list_style">
                                <li><a href="#">Your Account</a></li>
                                <li><a href="#">View Order</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Conditionis</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-3 col-6">
                        <aside class="f_widget f_link_widget">
                            <div class="f_title">
                                <h3>Work Times</h3>
                            </div>
                            <ul class="list_style">
                                <li><a href="#">Mon. : Fri.: 8 am - 8 pm</a></li>
                                <li><a href="#">Sat. : 9am - 4pm</a></li>
                                <li><a href="#">Sun. : Closed</a></li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-3 col-6">
                        <aside class="f_widget f_contact_widget">
                            <div class="f_title">
                                <h3>Contact Info</h3>
                            </div>
                            <h4>(1800) 574 9687</h4>
                            <p>Justshiop Store <br />256, baker Street,, New Youk, 5245</p>
                            <h5>cakebakery@contact.co.in</h5>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_copyright">
            <div class="container">
                <div class="copyright_inner">
                    <div class="float-left">
                        <h5><a target="_blank" href="https://www.templatespoint.net">Templates Point</a></h5>
                    </div>
                    <div class="float-right">
                        <a href="#">Purchase Now</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--================End Footer Area =================-->


    <!--================Search Box Area =================-->
    <div class="search_area zoom-anim-dialog mfp-hide" id="test-search">
        <div class="search_box_inner">
            <h3>Search</h3>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="icon icon-Search"></i></button>
                </span>
            </div>
        </div>
    </div>
    <!--================End Search Box Area =================-->
    {{-- comment --}}
    <script>
        $(document).ready(function() {
            var selectedValue = ''
            var pro_id = $('.pro_id').val()
            $('.review').change(function() {
                selectedValue = $('input[name="review"]:checked').val();
                console.log(selectedValue);
                // You can do something with the selected value here
            });

            $('#proceed').click(function(e) {
                e.preventDefault()
                $.ajax({
                    url: '{{ route('user.review') }}',
                    type: 'POST',
                    data: {
                        'rating': selectedValue,
                        'comment': $('#comment').val(),
                        'pro_id': pro_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#show').html(res.html)
                        Swal.fire({
                            title: 'Thành công',
                            icon: 'success',
                            text: res.success2,
                            confirmButtonText: 'Oke',
                            footer: '<a href="{{ route('contact') }}">Liên hệ với chúng tôi</a>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/shop'
                            }
                        })
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            })

        });
    </script>

    {{-- add to cart --}}
    <script>
        function addtocart(e) {
            e.preventDefault();
            const pro_size = document.getElementById("size").value;
            const pro_qty = $('.pro_qty').val();
            const pro_id = $('.pro_id').val();
            const size_id = $('#size_id').val();
            const urlCart = $(e.target).attr('href')
            console.log(size_id)

            $.ajax({
                type: 'post',
                url: '/addcart',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'pro_qty': pro_qty,
                    'pro_id': pro_id,
                    'pro_size': pro_size,
                    'size_id': size_id,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $.each(response.error, function(key, value) {
                            $('.alert-danger').show()
                            $('.alert-danger').html('<span>' + value + '</span>')
                        })
                    } else if (response.fail_qty) {
                        Swal.fire(
                            response.fail_qty,
                            'Hãy chọn lại số lượng',
                            'warning'
                        )
                    } else if (response.data == true) {
                        Swal.fire(response.status,
                            'please',
                            'warning'
                        )
                        setTimeout(() => {
                            window.location.href = '/login'
                        }, 1500);
                    } else {
                        Swal.fire(response.status,
                            'Cam on',
                            'success'
                        )
                        setTimeout(() => {
                            window.location.href = '/cart'
                        }, 1500);
                    }

                },
                error: function() {
                    console.log('aaa')
                }
            })
        }

        $(function() {
            $('.add_to_cart').on('click', addtocart)
        })
    </script>


    {{-- change size --}}
    <script>
        $('#size').change(function() {
            const pro_id = $(this).attr('pro_id')
            $.ajax({
                url: '{{ route('sizeProducts') }}',
                type: 'POST',
                data: {
                    'size': document.getElementById("size").value,
                    'pro_id': pro_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res.product_size.price)
                    $('#price').html('<span>' + (res.product_size.price).toLocaleString() + ' VND' +
                        '</span>')
                    $('#stock').html('<span>' + res.product_size.instock +
                        '</span>')
                    $('#size_id').val(res.product_size.size_id)
                    $('.pro_qty').attr('max', res.product_size.instock)

                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>
@endsection
