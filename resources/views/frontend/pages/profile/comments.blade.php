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
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.profile', Auth::id()) }}"><svg viewBox="0 0 512 512">
                            <path
                                d="M256 288c79.5 0 144-64.5 144-144S335.5 0 256 0 112 64.5 112 144s64.5 144 144 144zm128 32h-55.1c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16H128C57.3 320 0 377.3 0 448v16c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48v-16c0-70.7-57.3-128-128-128z">
                            </path>
                        </svg>
                        <div class="user-tittle">Tài khoản</div>
                    </a>
                </div>
                <div class="item-nav">
                    <a class="route-link" href="{{ route('user.orders', Auth::id()) }}" id="history"><svg
                            viewBox="0 0 512 512">
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
                    <a class="route-link active" href="{{ route('user.favorites', Auth::id()) }}"><svg
                            viewBox="0 0 512 512">
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
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Nội dung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comment as $item)
                            <tr>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->comment }}</td>
                                <td><a href="#">chi tiet</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
