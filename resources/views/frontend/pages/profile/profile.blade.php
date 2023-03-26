@extends('layouts.master')
@section('main-content')
    <style>
        .profile {
            display: flex;
            gap: 50px;
            margin-left: 300px;
        }


        .route-link {
            display: flex;
            width: 100%;
            gap: 11px;
            align-items: center;
            padding: 21px;
            margin-left: auto;
            margin-right: auto;
            color: #111827;
        }

        .item-nav {
            border: 1px solid #E6E8EB;
        }

        .active {
            border-left-width: 10px;
            border-left-color: #257AF3;
        }

        .item-nav:last-child {
            border-radius: 0 0 10px 10px;
        }

        .item-nav:first-child {
            border-radius: 10px 10px 0 0;
        }

        svg {
            width: 17.5px;
            height: 17.5px;
        }

        .user-tittle {
            font-size: 14px;
            font-weight: 500;
        }

        .main-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            row-gap: 20px;
            border-bottom: 1px solid #111827;
            padding: 20px 10px 20px 10px;
        }
    </style>
    <div>
        <div class="profile">
            <div class="nav-left col-lg-2">
                <div class="item-nav active">
                    <a class="route-link" href="{{ route('user.profile', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z">
                            </path>
                        </svg>
                        <div class="user-tittle">Tài khoản</div>
                    </a>
                </div>
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.orders', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z">
                            </path>
                        </svg>
                        <div class="user-tittle">Lịch sử đơn hàng</div>
                    </a>
                </div>
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.change', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M224 256A128 128 0 1 0 96 128a128 128 0 0 0 128 128zm96 64a63.08 63.08 0 0 1 8.1-30.5c-4.8-.5-9.5-1.5-14.5-1.5h-16.7a174.08 174.08 0 0 1-145.8 0h-16.7A134.43 134.43 0 0 0 0 422.4V464a48 48 0 0 0 48 48h280.9a63.54 63.54 0 0 1-8.9-32zm288-32h-32v-80a80 80 0 0 0-160 0v80h-32a32 32 0 0 0-32 32v160a32 32 0 0 0 32 32h224a32 32 0 0 0 32-32V320a32 32 0 0 0-32-32zM496 432a32 32 0 1 1 32-32 32 32 0 0 1-32 32zm32-144h-64v-80a32 32 0 0 1 64 0z">
                            </path>
                        </svg>
                        <div class="user-tittle">Mật khẩu</div>
                    </a>
                </div>
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.favorites', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z">
                            </path>
                        </svg>
                        <div class="user-tittle">Sản phẩm yêu thích</div>
                    </a>
                </div>
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.comments', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M256 32C114.6 32 .0272 125.1 .0272 240c0 49.63 21.35 94.98 56.97 130.7c-12.5 50.37-54.27 95.27-54.77 95.77c-2.25 2.25-2.875 5.734-1.5 8.734C1.979 478.2 4.75 480 8 480c66.25 0 115.1-31.76 140.6-51.39C181.2 440.9 217.6 448 256 448c141.4 0 255.1-93.13 255.1-208S397.4 32 256 32z">
                            </path>
                        </svg>
                        <div class="user-tittle">Bình luận của tôi</div>
                    </a>
                </div>
            </div>
            <div class="main col-md-7" id="main-info">
                <div class="main-wrapper">
                    <div class="main-box">
                        <div class="main-tittle">Tên đăng nhập</div>
                        <div class="">{{ $user->name }}</div>
                    </div>
                    <div class="main-box">
                        <div class="main-tittle">Email</div>
                        <div class="">{{ $user->email }}</div>
                    </div>
                    <div class="main-box">
                        <div class="main-tittle">Họ và tên</div>
                        <div class="">{{ $user->deliveryAddress->name ?? 'Chưa đặt tên' }}</div>
                    </div>
                    <div class="main-box">
                        <div class="main-tittle">Nhóm khách hàng</div>
                        <div class="">
                            <div style="display:inline;"><img
                                    style="width: 21px;
                                height: 18px; " loading="lazy"
                                    src="https://cdn.divineshop.vn/image/catalog/Banner/vip/silver.png" alt="Vip Bạc"
                                    title="Vip Bạc">
                                <span>Vip Bạc</span>
                            </div>
                        </div>
                    </div>
                    <div class="main-box">
                        <div class="main-tittle">Đã tích lũy</div>
                        <div class="">{{ $user->orders->sum('totalAmount') }}</div>
                    </div>
                    <div class="main-box">
                        <div class="main-tittle">Ngày tham gia</div>
                        <div class="">{{ $user->created_at }}</div>
                    </div>
                </div>
                <div class="main-info">
                    <h2>Change infomation</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('user.update', ['id' => Auth::id()]) }}" method="post">
                        {!! csrf_field() !!}
                        @method('POST')


                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <div class="mb-3">

                                    <label>Username</label></br>
                                    <input type="text" name="fullname" id="fullname"
                                        value="{{ $user->deliveryAddress->fullname ?? '' }}" class="form-control"></br>
                                </div>

                                <div class="mb-3">
                                    <label>Phone</label></br>
                                    <input type="text" name="phone" id="phone"
                                        value="{{ $user->deliveryAddress->phone ?? '' }}" class="form-control"></br>
                                </div>
                                <div class="mb-3">
                                    <label for="">Choose the city</label>
                                    <select name="province" id="province" class="form-control  choose"
                                        onchange="changcity()">
                                        <option value="">--Select city--</option>
                                        @foreach ($address as $key => $item)
                                            <option value="{{ $item->_name }}">{{ $item->_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="">Choose Province</label>
                                    <select name="district" id="district"
                                        class="form-control input-sm m-bot15 province choose" onchange="changdistrict()">
                                        <option value="">--Select district--</option>

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Choose Wards</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="">--Choose a commune--</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">chi tiet</label>
                                    <input type="text" name="chitiet" id="chitiet" class="form-control">
                                </div>
                            </div>

                            <br>
                            <input type="submit" value="Update" class="btn btn-success"></br>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>
    <script>
        let result;

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
                    result = <?php echo $address; ?>.find(item => item._name == response.data);
                    console.log(result.ward)
                    const select = document.getElementById('district');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }

                    const options = result.district.map((item) => {
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

        function changdistrict(click) {
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
                    const ward = result.ward.filter(item => item._district_id == response.name.id);
                    console.log([response.name, ward])
                    const select = document.getElementById('wards');
                    for (let i = select.options.length - 1; i > 0; i--) {
                        select.remove(i);
                    }
                    const options = ward.map((item) => {
                        const option = document.createElement("option");
                        option.value = item._prefix + ' ' + item._name;
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
    </script>
@endsection
