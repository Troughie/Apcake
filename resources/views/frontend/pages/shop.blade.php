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

        .picture {
            height: 200px;
            width: 100%;
        }

        .product___item {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 300px));
            row-gap: 20px;
            column-gap: 20px;
        }
    </style>
    <section class="product_area p_100">
        <div class="container">
            <div class="row product_inner_row">
                <div class="col-lg-10">
                    <div class="row m0 product_task_bar">
                        <div class="product_task_inner">
                            {{-- <div class="float-left">
                                <a class="active" href="#"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-th-list" aria-hidden="true"></i></a>
                                <span>Showing 1 - 10 of 55 results</span>
                            </div> --}}

                            <div class="float-right">
                                <form action="GET">
                                    @csrf
                                    <select class="form-control" name="sort" id="sort">
                                        <option value="{{ Request::url() }}?sort_by=none" checked>--Lọc--</option>
                                        <option value="{{ Request::url() }}?sort_by=giam_dan">--Giá giảm dần--</option>
                                        <option value="{{ Request::url() }}?sort_by=tang_dan">--Giá tăng dần--</option>
                                        <option value="{{ Request::url() }}?sort_by=kytu_az">--A đến Z--</option>
                                        <option value="{{ Request::url() }}?sort_by=kytu_za">--Z đến A --</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="product___item" id="delamgi">
                        @if ($product_sort !== null)
                            @foreach ($product_sort as $item)
                                <div class="container">
                                    <div class="card" style="border-radius: 30px">
                                        <img src="{{ URL::to('uploads/products/' . $item->productSize->image ?? 'resize52.png') }}"
                                            alt="" class="picture"
                                            style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ $item->productSize->name }}</h5>
                                            </div>
                                            <input type="hidden" name="pro_id" id="pro_id"
                                                value="{{ $item->product_id }}">
                                            <div class="d-flex flex-column justify-content-between mb-3">

                                                <div class="text-dark mb-0">
                                                    <b>{{ number_format(\App\Models\Size::where('product_id', $item->productSize->product_id)->first('price')->price) . ' VND' }}
                                                    </b>
                                                </div>

                                                <div class=" mb-0 mt-2 text-success">Hiện còn:

                                                    <div class=" mb-0 mt-2 text-success">Số lượng:

                                                        <span
                                                            class="fw-bold">{{ \App\Models\Size::where('product_id', $item->productSize->product_id)->get()->sum('instock') }}</span>
                                                    </div>

                                                </div>

                                                <div class="d-flex flex-row justify-content-center">
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('products', ['id' => $item->productSize->product_id, 'slug' => Str::slug($item->productSize->name)]) }}">Mua
                                                        hàng
                                                    </a>
                                                    <button class="btn ml-2 btn-xs whilelist">
                                                        <i class="fa fa-heart" class="heart" aria-hidden="true"
                                                            style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        @elseif ($product_sortbyName !== null)
                            @foreach ($product_sortbyName as $item)
                                <div class="container">
                                    <div class="card" style="border-radius: 30px">
                                        <img src="{{ URL::to('uploads/products/' . $item->image ?? 'resize52.png') }}"
                                            alt="" class="picture"
                                            style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ $item->name }}</h5>
                                            </div>
                                            <input type="hidden" name="pro_id" id="pro_id"
                                                value="{{ $item->product_id }}">
                                            <div class="d-flex flex-column justify-content-between mb-3">

                                                <div class="text-dark mb-0">
                                                    <b>{{ number_format(\App\Models\Size::where('product_id', $item->product_id)->first('price')->price) . ' VND' }}
                                                    </b>
                                                </div>
                                                <div class=" mb-0 mt-2 text-success">Hiện còn:
                                                    <span
                                                        class="fw-bold">{{ \App\Models\Size::where('product_id', $item->product_id)->get()->sum('instock') }}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-center">
                                                <a class="btn btn-xs btn-primary"
                                                    href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">Mua
                                                    hàng
                                                </a>
                                                <button class="btn ml-2 btn-xs whilelist">
                                                    <i class="fa fa-heart" class="heart" aria-hidden="true"
                                                        style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($product as $item)
                                <div class="container">
                                    <div class="card" style="border-radius: 30px">
                                        <img src="{{ URL::to('uploads/products/' . $item->image) }}" alt=""
                                            class="picture"
                                            style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="mb-0">{{ $item->name }}</h5>
                                            </div>
                                            <input type="hidden" name="pro_id" id="pro_id"
                                                value="{{ $item->product_id }}">
                                            <div class="d-flex flex-column justify-content-between mb-3">

                                                <div class="text-dark mb-0">
                                                    <b>{{ number_format(\App\Models\Size::where('product_id', $item->product_id)->first('price')->price) . ' VND' }}
                                                    </b>
                                                </div>
                                                <div class=" mb-0 mt-2 text-success">Hiện còn:
                                                    <span
                                                        class="fw-bold">{{ \App\Models\Size::where('product_id', $item->product_id)->get()->sum('instock') }}</span>
                                                </div>

                                            </div>

                                            <div class="d-flex flex-row justify-content-center">
                                                <a class="btn btn-xs btn-primary"
                                                    href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">Xem
                                                    chi tiết
                                                </a>
                                                @if ($favorites[$item->product_id] == null)
                                                    <button class="btn ml-2 btn-xs whilelist">
                                                        <i class="fa fa-heart " id="heart-{{ $item->product_id }}"
                                                            pro_id="{{ $item->product_id }}" aria-hidden="true"
                                                            style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;"></i>
                                                    </button>
                                                @else
                                                    <button class="btn ml-2 btn-xs whilelist">
                                                        <i class="fa fa-heart " id="heart-{{ $item->product_id }}"
                                                            pro_id="{{ $item->product_id }}" aria-hidden="true"
                                                            style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px; color:red"></i>
                                                    </button>
                                                @endif

>>>>>>> 5cf94127fcd3482671cb288367ad7592ba1dd518
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $product->links() }}
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="product_left_sidebar">
                        {{-- <aside class="left_sidebar search_widget">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Search Keywords">
                                <div class="input-group-append">
                                    <button class="btn" type="button"><i class="icon icon-Search"></i></button>
                                </div>
                            </div>
                        </aside> --}}
                        <aside class="left_sidebar p_catgories_widget">
                            <div class="p_w_title">
                                <h3>Danh mục sản phẩm</h3>
                            </div>
                            <ul class="list_style" id="category">
                                @foreach ($category as $item)
                                    <li><a href="#"class="cate" cate_id="{{ $item->category_id }}"
                                            cate="{{ $item->category_name }}">{{ $item->category_name }}
                                            ({{ $item->products->count('product_id') }})
                                        </a></li>
                                @endforeach
                            </ul>
                        </aside>

                        <aside class="left_sidebar p_price_widget">

                            <form action="{{ route('filterPrice') }}" method="POST">
                                @csrf
                                <h4>Lọc theo giá</h4>
                                <select class="form-control" name="filter" id="filter">
                                    <option value="">-------</option>
                                    <option value="1">Dưới 50,000đ</option>
                                    <option value="2">50,000đ - 100,000đ</option>
                                    <option value="3">100,000đ - 200,000đ</option>
                                    <option value="4">trên 200,000đ</option>
                                </select>
                                <br><br>
                                {{-- <input type="submit" value="Lọc giá" id="submit_filter" class="btn btn-sm btn-primary"> --}}
                            </form>

                    </div>

            
                    <aside class="left_sidebar p_sale_widget">
                        <div class="p_w_title">
                            <h3>Sản phẩm bán chạy</h3>
                        </div>
                        @foreach ($pro_buy as $item)
                            {{-- {{ dd($item) }} --}}
                            <div class="media">
                                <div class="d-flex">
                                    <a
                                        href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">
                                        <img src="{{ URL::to('uploads/products/' . $item->image) }}" alt=""
                                            style="width:70px;height:70px"></a>
                                </div>
                                <div class="media-body" style="width:100px">
                                    <h4
                                        style="font-size: 15px;white-space:nowrap;overflow: hidden;text-overflow: ellipsis">
                                        {{ $item->name }}
                                    </h4>
                                    <fieldset class="rating" style="margin-bottom: -6px ;white-space:nowrap">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if (isset($reviewShow[$item->name]))
                                                @if ($i <= $reviewShow[$item->name]['0'] && $item->product_id == $reviewShow[$item->name]['1'])
                                                    <input id="demo-{{ $i }}" type="radio" name="review"
                                                        class="review" value="{{ $i }}" checked disabled>
                                                    <label for="demo-{{ $i }}">{{ $i }}star</label>
                                                @else
                                                    <input id="demo-{{ $i }}" type="radio" name="review"
                                                        class="review" value="{{ $i }}" disabled>
                                                    <label for="demo-{{ $i }}">{{ $i }}star</label>
                                                @endif
                                            @else
                                                <input id="demo-{{ $i }}" type="radio" name="review"
                                                    class="review" value="{{ $i }}" disabled>
                                                <label for="demo-{{ $i }}">{{ $i }}star</label>
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
                                    <div style="white-space:nowrap;display: flex; flex-direction:row">
                                        <h5
                                            style="font-size: 15px;white-space:nowrap;overflow: hidden;text-overflow: ellipsis;margin-right:10px">
                                            {{ number_format(\App\Models\Size::where('product_id', $item['product_id'])->first('price')->price) }}
                                        </h5>
                                        <h5>VND</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </aside>
                </div>
            </div>
        </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#sort').on('change', function() {
                    var url = $(this).val();
                    if (url) {
                        window.location = url;
                    }
                    return false
                });
            });
        </script>

    </section>
    <!--================End Product Area =================-->

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
                                <button class="btn btn-outline-secondary" type="button">Subscribe Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $('ul#category li').click(function(e) {
            e.preventDefault()
            const cate = ($(this).find("a.cate").attr('cate'));
            const cate_id = ($(this).find("a.cate").attr('cate_id'));
            $.ajax({
                url: '{{ route('filterCate') }}',
                type: 'POST',
                data: {
                    'cate': cate,
                    'cate_id': cate_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(res) {
                    $('#delamgi').html(res.status)
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>

    <!--end container -->
    <script>
        const pro_id = $('#pro_id').val()
        $('.whilelist').click(function(e) {
            e.preventDefault()
            const pro_id = $(this).find('i').attr('pro_id')
            $.ajax({
                url: '{{ route('addwList') }}',
                type: 'POST',
                data: {
                    'pro_id': pro_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(res) {
                    if (res.user) {
                        s('Đã thêm hàng thành công')
                        $('#heart-' + res.pro_id).css('color', 'red');
                    } else {
                        alert('Vui lòng đăng nhập')
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>


    <script>
        $('#filter').change(function(e) {
            e.preventDefault()
            $.ajax({
                url: '{{ route('filterPrice') }}',
                type: 'POST',
                data: {
                    'price': $(this).val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(res) {
                    $('#delamgi').html(res.filterProduct)
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })
    </script>


@endsection
