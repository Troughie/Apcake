    <!--================Main Header Area =================-->
    <header class="main_header_area">
        <div class="top_header_area row m0">
            <div class="container">
                <div class="float-left">
                    <a href="tell:+18004567890"><i class="fa fa-phone" aria-hidden="true"></i> + (1800) 456 7890</a>
                    <a href="mainto:info@cakebakery.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>
                        info@cakebakery.com</a>
                </div>
                <div class="float-right">
                    <ul class="h_social list_style">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-amazon"></i></a></li>
                    </ul>
                    <ul class="h_search list_style">
                        <li class="shop_cart"><a href="#"><i class="lnr lnr-cart"></i></a></li>
                        <li><a class="popup-with-zoom-anim" href="#test-search"><i class="fa fa-search"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main_menu_area">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="my_toggle_menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="dropdown submenu">
                                <a href="{{ route('index') }}">Home</a>
                            </li>
                            <li><a href="cake.html">Our Cakes</a></li>
                            <li><a href="menu.html">Menu</a></li>
                            <li class="dropdown submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">About Us</a>
                                <ul class="dropdown-menu">
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="our-team.html">Our Chefs</a></li>
                                    <li><a href="testimonials.html">Testimonials</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="navbar-nav justify-content-end align-items-center">
                            <li class="dropdown submenu">
                                <a href="{{ route('gallery') }}">Gallery</a>
                                <ul class="dropdown-menu">
                                </ul>
                            </li>
                            <li class="dropdown submenu ">
                                <a href="{{ route('blog') }}">Blog</a>
                                <ul class="dropdown-menu">
                                </ul>
                            </li>
                            <li class="dropdown submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="false">Shop</a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('shop') }}">shop</a></li>
                                    <li><a href="{{ route('products') }}">Product Details</a></li>
                                    <li><a href="">Cart Page</a></li>
                                    <li><a href="checkout.html">Checkout Page</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.html">Contact Us</a></li>

                            <li class="dropdown submenu">
                                @include('layouts.navbar')
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <!--================End Main Header Area =================-->
    <section class="banner_area">
        <div class="container">
            <div class="banner_text">
                <h3>{{ $title_head }}</h3>
                <ul>
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="shop.html">{{ $title_head }}</a></li>
                </ul>
            </div>
        </div>
    </section>
