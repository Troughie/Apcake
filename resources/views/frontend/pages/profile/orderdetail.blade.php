@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="bg-white p-5 rounded">
        <div class="d-flex flex-col justify-content-between">
            <div>
                <h4>Chi tiết đơn hàng #{{ $orDetail[0]->order->order_id }}</h4>
                <div>Hiển thị thông tin các sản phẩm bạn đã mua tại Apcake</div>
            </div>
            <div><button type="button" class="btn d-flex flex-col align-items-center "
                    title="Thêm các sản phẩm trong đơn hàng hiện tại vào giỏ hàng"><svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512">
                        <path
                            d="M551.991 64H144.28l-8.726-44.608C133.35 8.128 123.478 0 112 0H12C5.373 0 0 5.373 0 12v24c0 6.627 5.373 12 12 12h80.24l69.594 355.701C150.796 415.201 144 430.802 144 448c0 35.346 28.654 64 64 64s64-28.654 64-64a63.681 63.681 0 0 0-8.583-32h145.167a63.681 63.681 0 0 0-8.583 32c0 35.346 28.654 64 64 64s64-28.654 64-64c0-18.136-7.556-34.496-19.676-46.142l1.035-4.757c3.254-14.96-8.142-29.101-23.452-29.101H203.76l-9.39-48h312.405c11.29 0 21.054-7.869 23.452-18.902l45.216-208C578.695 78.139 567.299 64 551.991 64zM464 424c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm-256 0c13.234 0 24 10.766 24 24s-10.766 24-24 24-24-10.766-24-24 10.766-24 24-24zm279.438-152H184.98l-31.31-160h368.548l-34.78 160zM272 200v-16c0-6.627 5.373-12 12-12h32v-32c0-6.627 5.373-12 12-12h16c6.627 0 12 5.373 12 12v32h32c6.627 0 12 5.373 12 12v16c0 6.627-5.373 12-12 12h-32v32c0 6.627-5.373 12-12 12h-16c-6.627 0-12-5.373-12-12v-32h-32c-6.627 0-12-5.373-12-12z">
                        </path>
                    </svg>
                    <div>Mua lại đơn hàng</div>
                </button></div>
        </div>
        <div class="border my-5"></div>
        <div class="d-flex flex-col  mt-5 justify-content-between">
            <div>
                <h6>Thông tin đơn hàng</h6>
                <div>
                    <div>Mã đơn hàng: #{{ $orDetail[0]->order->order_id }}</div>
                    <div>Ngày tạo: {{ $orDetail[0]->order->created_at }}</div>
                    <div>Trạng thái đơn hàng: <span class="be">{{ $orDetail[0]->order->order_sta->name }}</span>
                    </div>
                    <div>Người nhận: {{ $orDetail[0]->order->email }}</div>
                </div>
            </div>
            <div>
                <h6>Giá trị đơn hàng</h6>
                <div>
                    <div class="d-flex flex-col justify-content-between">
                        <div class="mr-3">Tổng giá trị sản phẩm:</div>
                        <div>{{ $orDetail[0]->order->totalAmount }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border my-5"></div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <td>Sản phẩm </td>
                        <td>Tên sản phẩm</td>
                        <td>Số lượng</td>
                        <td>Số tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orDetail as $item)
                        <tr>
                            <td>{{ $item->order_pro->name }}</td>
                            <td>{{ $item->order_pro->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->total }}</td>
                            <td><a
                                    href="{{ route('products', ['id' => $item->product_id, 'slug' => Str::slug($item->order_pro->name)]) }}">Chi
                                    tiết sản phẩm</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
