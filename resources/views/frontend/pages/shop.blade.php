@extends('layouts.master')
@section('main-content')
    <section class="product_area p_100">
        <div class="container">
            <div class="row product_inner_row">
                <div class="col-lg-9">
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
                                    <option value="4">Default</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row product_item_inner">
                        @foreach ($product as $item)
                            <div class="col-lg-4 col-md-4 col-6">
                                <div class="cake_feature_item">
                                    <div class="cake_img">
                                        <img src="img/cake-feature/c-feature-1.jpg" alt="">

                                    </div>
                                    <div class="cake_text">
                                        <h4>{{ $item->price }}</h4>
                                        <h3>{{ $item->name }}</h3>
                                        <a class="pest_btn"
                                            href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">Add
                                            to
                                            cart</a>
                                        <a class="pest_btn"
                                            href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->name)]) }}">see
                                            more</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div class="product_pagination">
                        <div class="left_btn">
                            <a href="#"><i class="lnr lnr-arrow-left"></i> New posts</a>
                        </div>
                        <div class="middle_list">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                                    <li class="page-item"><a class="page-link" href="#">12</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="right_btn"><a href="#">Older posts <i class="lnr lnr-arrow-right"></i></a></div>
                    </div>
                </div>
                <div class="col-lg-3">
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
                                            ({{ $item->products->count('name') }})
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
@endsection
