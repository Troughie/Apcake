<html>

<body
    style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">

    <table
        style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:left;"><img style="width: 20%" src="{{ asset('img/apcake_logo.png') }}"
                        alt=""></th>
                <th style="text-align:right;font-weight:400;">{{ $orderItems->order_date }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="font-size:14px;margin:0 0 6px 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:150px">Order status</span><b
                            style="color:green;font-weight:normal;margin:0">{{ $orderItems->order_sta->name }}</b>
                        @if ($payment_method == 'cod')
                            <button style="background-color: blue;padding:10px 20px;border-radius:10px;border:none">
                                <a style="color:rgb(255, 255, 255)"
                                    href="{{ route('confirmOrder', $orderItems->order_id) }}">Xác nhận đơn
                                    hàng</a>
                            </button>
                        @endif
                    </p>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Order
                            amount</span>
                        <?= number_format($orderItems->totalAmount) ?>VND
                    </p>
                </td>
            </tr>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px">Name</span> {{ $name }}</p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Email</span> {{ $email }}</p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Phone</span> {{ $phone }}</p>
                </td>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Address</span> {{ $address }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:15px;">
                    @if (count($orderItems->orderDe) > 0)
                        @foreach ($orderItems->orderDe as $item)
                            <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                                <span
                                    style="display:block;font-size:13px;font-weight:normal;">{{ $cart_name[$item->size] }}</span>
                                <?= number_format($pro_sizes[$item->size]->price) ?>VND
                                <b style="font-size:12px;font-weight:300;">x{{ $item->quantity }}</b>
                            </p>
                        @endforeach
                    @endif

                </td>
            </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                    <strong style="display:block;margin:0 0 10px 0;">Việt Nam</strong> Thành phố Hồ Chí Minh , <br>
                    Zip - 723564,590 Đ. Cách Mạng Tháng 8, Phường 11, Quận 3,<br><br>
                    <b>Phone:</b> 0909999999<br>
                    <b>Email:</b> apcake0304@gmail.com
                </td>
            </tr>
        </tfooter>
    </table>
</body>

</html>
