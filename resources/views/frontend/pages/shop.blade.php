@extends('layouts.master')

@section('main-content')
    <style>
        .picture {
            height: 200px;
            width: 100%;
        }

        .product___item {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
                            <div class="float-left">
                                <a class="active" href="#"><i class="fa fa-th-large" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-th-list" aria-hidden="true"></i></a>
                                <span>Showing 1 - 10 of 55 results</span>
                            </div>
                            <div class="float-right">
                                <h4>Sort by :</h4>
                                <select class="short">
                                    <option data-display="Default">Default</option>
                                    <option value="1">Default</option>
                                    <option value="2">Default</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="product___item">
                        @foreach ($product as $item)
                            <div class="container">
                                <div class="card" style="border-radius: 30px">
                                    <img src="{{ URL::to('uploads/products/' . $item->image) }}" alt=""
                                        class="picture"
                                        style="width: 100%;object-fit: cover;image-rendering: pixelated;border-radius: 30px 30px 0 0 ">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                            <p class="small text-danger"><s>$1099</s></p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0">{{ $item->name }}</h5>
                                        </div>
                                        <input type="hidden" name="pro_id" id="pro_id" value="{{ $item->product_id }}">
                                        <div class="d-flex flex-column justify-content-between mb-3">
                                            <h5 class="text-dark mb-0">{{ number_format($item->price) . 'VND' }}</h5>
                                            <small class="text-muted mb-0 mt-2">Available: <span
                                                    class="fw-bold">{{ $item->quantity }}</span></small>
                                        </div>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">See
                                                detail
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
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $product->links() }}
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="product_left_sidebar">
                        <aside class="left_sidebar search_widget">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Search Keywords">
                                <div class="input-group-append">
                                    <button class="btn" type="button"><i class="icon icon-Search"></i></button>
                                </div>
                            </div>
                        </aside>
                        <aside class="left_sidebar p_catgories_widget">
                            <div class="p_w_title">
                                <h3>Product Categories</h3>
                            </div>
                            <ul class="list_style">
                                @foreach ($category as $item)
                                    <li><a href="#">{{ $item->category_name }}
                                            ({{ $item->products->count('product_id') }})
                                        </a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="left_sidebar p_price_widget">
                            <div class="p_w_title">
                                <h3>Filter By Price</h3>
                            </div>
                            <div class="filter_price">
                                <div id="slider-range"></div>
                                <label for="amount">Price range:</label>
                                <input type="text" id="amount" readonly />
                                <a href="#">Filter</a>
                            </div>
                        </aside>
                        <aside class="left_sidebar p_sale_widget">
                            <div class="p_w_title">
                                <h3>Top Sale Products</h3>
                            </div>
                            <div class="media">
                                <div class="d-flex">
                                    <img src="img/product/sale-product/s-product-1.jpg" alt="">
                                </div>
                                <div class="media-body">
                                    <a href="#">
                                        <h4>Brown Cake</h4>
                                    </a>
                                    <ul class="list_style">
                                        <li><a href="#"><i class="fa fa-star-o"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star-o"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star-o"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star-o"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star-o"></i></a></li>
                                    </ul>
                                    <h5>$29</h5>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Area =================-->

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


    <!--end container -->
    <script>
        const pro_id = $('#pro_id').val()
        $('.whilelist').click(function(e) {
            e.preventDefault()
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
                        alert('Đã thêm hàng thành công')
                        $(this).find('i').css('color', 'red !important');
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
@endsection
