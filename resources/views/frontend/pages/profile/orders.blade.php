@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="main-info bg-white rounded p-4">
        <table class="table">
            <thead>
                <tr>
                    <td>Thời gian</td>
                    <td>Mã đơn hàng</td>
                    <td>Sản phẩm</td>
                    <td>Tổng tiền</td>
                    <td>Trạng thái</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($order as $item)
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->order_id }}</td>

                        <td>
                            @foreach ($item->orderDe as $pro)
                                <p><span>{{ $pro->order_pro->name }}</span> x {{ $pro->quantity }}</p>
                            @endforeach
                        </td>
                        <td>${{ $item->totalAmount }}</td>
                        <td>{{ $item->order_sta->name }}</td>
                        <td><a href="{{ route('user.order', $item->order_id) }}">Chi tiet</a></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
