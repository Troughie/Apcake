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
            width: 400px;
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
            <div class="container d-flex flex-row align-items-center">
                <div class="float-left d-flex align-items-center" style="white-space: nowrap">
                    <a href="tell:+18004567890"><i class="fa fa-phone" aria-hidden="true"></i> (1900) 251 234</a>
                    <a href="mainto:info@cakebakery.com" class="ml-2"><i class="fa fa-envelope-o"
                            aria-hidden="true"></i>apcake0304@gmail.com
                    </a>
                </div>
                <div class="input-group rounded mx-4">
                    <input type="search" class="form-control rounded" name="search-header" id="search-header"
                        placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                    <div id="result" class="card" style="position: absolute;top:40px;width:100%;z-index:auto">
                    </div>
                </div>
                <div class="float-right d-flex flex-row align-items-center">
                    <ul class="h_social list_style d-flex flex-row">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-amazon"></i></a></li>
                    </ul>
                    <ul class="h_search list_style">
                        <li>
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
                                    <a type="button" class="d-flex flex-row" id="dropdownMenuButton" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" v-pre class="nav-link dropdown-toggle"
                                        style="cursor: pointer; white-space: nowrap">
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
                    <div class="collapse navbar-collapse justify-content-center align-items-center d-flex" style="white-space: nowrap; "id="navbarSupportedContent">
                       
                        <ul class="navbar-nav justify-content-center align-items-center d-flex flex-grow-1 flex-shrink-1"
                            style="white-space: nowrap; ">
                            <li class="dropdown submenu">
                                <a href="{{ route('index') }}">Trang chủ</a>
                            </li>
                            <li><a href="{{ route('shop') }}">Cửa hàng</a></li>
                            <li class="dropdown submenu ">
                                <a href="{{ route('blog') }}">Blog</a>
                            </li>
                            <li><a href="{{ route('contact') }}">Liên lạc chúng tôi</a></li>
                            <li><a href="#" class="icon-cart"> <i class="fa fa-shopping-cart"></i>
                                    Giỏ hàng <span class="badge">({{ $cart_total_quantity }})</span></a></li>
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
                        <span class="main-color-text">{{ number_format($cart_total_price) . 'VND' }}</span>
                    </div>
                </div>
                <!--end shopping-cart-header -->

                <ul class="shopping-cart-items">
                    @if ($cart_total_quantity > 0)
                        @foreach ($cart_items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center lh-condensed">
                                <div class="d-flex flex-row">
                                    <img src="{{ URL::to('uploads/products/' . $item->cart_pro->image) }}"
                                        alt="" class="picture"
                                        style="object-fit: cover;image-rendering: pixelated;width:50px;height:50px">
                                    <div class="ml-3">
                                        <h6 class="my-1">{{ $item->cart_pro->name }}</h6>
                                        <small
                                            class="text-muted">{{ number_format($pro_sizes[$item->size][$item->product_id]->price) . 'VND' }}
                                            x
                                            {{ $item->quantity }}</small>
                                    </div>
                                </div>
                                <span
                                    class="text-muted">{{ number_format($pro_sizes[$item->size][$item->product_id]->price * $item->quantity) . 'VND' }}</span>
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
        var timeout = null
        var query = null
        $(document).on('keyup', '#search-header', function() {
            clearTimeout(timeout)
            query = $('#search-header').val()
            timeout = setTimeout(() => {
                $.ajax({
                    type: 'get',
                    url: '{{ route('search_header') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#result').html(response.status)
                    },
                    error: function() {
                        console.log('aaa')
                    }
                })
            }, 400);
        })
    </script>
    <script>
        $(".icon-cart").on("click", function() {

            $(".shopping-cart").fadeToggle("fast");
        });
    </script>
