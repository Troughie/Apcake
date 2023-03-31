    <!--================Main Header Area =================-->
    <style>
        @import url(https://fonts.googleapis.com/css?family=Lato:300,400,700);
        @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css);

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        .lighter-text {
            color: #abb0be;
        }

        .main-color-text {
            color: #6394f8;
        }

        nav {
            padding: 20px 0 40px 0;
            background: #f8f8f8;
            font-size: 16px;
        }

        nav .navbar-left {
            float: left;
        }

        nav .navbar-right {
            float: right;
        }

        nav ul li {
            display: inline;
            padding-left: 20px;
            list-style-type: none;
        }

        nav ul li a {
            color: #777777;
            text-decoration: none;
            list-style-type: none;

        }

        .cart_wrapper {
            position: absolute;
            right: 17%;
            top: 19%;
            z-index: 1000;
        }

        .shopping-cart {
            margin: 20px 0;
            float: right;
            background: white;
            width: 320px;
            position: sticky;
            border-radius: 3px;
            padding: 20px;
            display: none;
        }

        .shopping-cart .shopping-cart-header {
            border-bottom: 1px solid #e8e8e8;
            padding-bottom: 15px;
        }

        .shopping-cart .shopping-cart-header .shopping-cart-total {
            float: right;
        }

        .shopping-cart .shopping-cart-items {
            padding-top: 20px;
            margin-left: -35px;
        }

        .shopping-cart .shopping-cart-items li {
            margin-bottom: 18px;
        }

        .shopping-cart .shopping-cart-items img {
            float: left;
        }

        .shopping-cart .shopping-cart-items .item-name {
            display: block;
            padding-top: 10px;
            font-size: 16px;
        }

        .shopping-cart .shopping-cart-items .item-price {
            color: #6394f8;
            margin-right: 8px;
        }

        .shopping-cart .shopping-cart-items .item-quantity {
            color: #abb0be;
        }

        .shopping-cart:after {
            bottom: 100%;
            left: 89%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: white;
            border-width: 8px;
            margin-left: -8px;
        }

        .cart-icon {
            color: #515783;
            font-size: 24px;
            margin-right: 7px;
            float: left;
        }

        .button {
            background: #6394f8;
            color: white;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            display: block;
            border-radius: 3px;
            font-size: 16px;
            margin: 25px 0 15px 0;
        }

        .button:hover {
            background: #729ef9;
        }
    </style>
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
                        <li><a class="popup-with-zoom-anim " href="#test-search"><i class="fa fa-search"></i></a></li>
                        <li>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ms-auto d-flex flex-row">
                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li class=" nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif

                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <a type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" v-pre class="nav-link dropdown-toggle"
                                        style="cursor: pointer;">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if (Auth::user()->role === 'ADC')
                                            <a class="dropdown-item " style="color:black" href="{{ route('admin.admin') }}">
                                                {{ __('Admin maneger') }}
                                            </a>
                                        @endif
                                        <a class="dropdown-item " style="color:black"
                                            href="{{ route('user.profile', Auth::id()) }}">
                                            {{ __('Profile') }}
                                        </a>
                                        <a class="dropdown-item text-black" style="color:black" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                    <li class="nav-item dropdown">


                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">


                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </li>
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
                            <li><a href="{{ route('shop') }}">shop</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="#"' class="icon-cart"> <i class="fa fa-shopping-cart"></i>
                                    Cart <span class="badge">({{ $cart_total_quantity }})</span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>


    <!--================End Main Header Area =================-->
    <section class="banner_area ">
        <div class="container">
            <div class="banner_text">
                <h3>APCAKE</h3>
                <ul>
                    <li><a href="{{ route('index') }}"></a></li>
                    <li><a href="shop.html"></a></li>
                </ul>
            </div>
        </div>
        <div class="cart_wrapper">
            <div class="shopping-cart">
                <div class="shopping-cart-header">
                    <i class="fa fa-shopping-cart cart-icon"></i><span
                        class="badge">{{ $cart_total_quantity }}</span>
                    <div class="shopping-cart-total">
                        <span class="lighter-text">Total:</span>
                        <span class="main-color-text">${{ $cart_total_price }}</span>
                    </div>
                </div>
                <!--end shopping-cart-header -->

                <ul class="shopping-cart-items">
                    @if ($cart_total_quantity > 0)
                        @foreach ($cart_items as $item)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cart-item1.jpg"
                                        alt="item1" />
                                    <h6 class="my-0">{{ $item->cart_pro->name }}</h6>
                                    <small class="text-muted">${{ $item->cart_pro->price }} x
                                        {{ $item->quantity }}</small>
                                </div>
                                <span class="text-muted">${{ $item->cart_pro->price * $item->quantity }}</span>
                            </li>
                        @endforeach
                        <a href="{{ route('user.showcart') }}" class="button">Checkout</a>
                    @else
                        <div class="Oe"><img loading="lazy"
                                src="https://cdn.divineshop.vn/static/4e0db8ffb1e9cac7c7bc91d497753a2c.svg"
                                class="Ca" alt="Khong co don hang">
                        </div>
                    @endif
                </ul>
                <br>
                <br>
            </div>
            <!--end shopping-cart -->
        </div>
    </section>

    <script>
        $(".icon-cart").on("click", function() {

            $(".shopping-cart").fadeToggle("fast");
        });
    </script>
