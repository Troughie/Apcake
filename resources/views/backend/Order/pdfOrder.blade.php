@extends('backend.Layout.index')
@section('content')
    <table
        style="width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:left;"><img style="width: 20%" src="{{ asset('img/apcake_logo.png') }}"
                        alt="bachana tours"></th>
                <th style="text-align:right;font-weight:400;">{{ $orDetail[0]->order->created_at }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <div class="d-flex flex-row justify-content-between">
                        <p style="font-size:14px;margin:0 0 6px 0;align-items: center"><span
                                style="font-weight:bold;display:inline-block;min-width:150px">Order
                                status</span>{{ $orDetail[0]->order->order_sta->name }}<b
                                style="color:green;font-weight:normal;margin:0"></b>

                        </p>


                    </div>
                    <p style="font-size:14px;margin:0 0 0 0;"><span
                            style="font-weight:bold;display:inline-block;min-width:146px">Order
                            amount</span>
                        ${{ $orDetail[0]->order->totalAmount }}
                    </p>
                </td>
            </tr>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px">Name</span>{{ $orDetail[0]->order->name ?? '' }}
                    </p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Email</span>{{ $orDetail[0]->order->email }}
                    </p>
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Phone</span>{{ $orDetail[0]->order->phone }}
                    </p>
                </td>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span
                            style="display:block;font-weight:bold;font-size:13px;">Address</span>
                        {{ $orDetail[0]->order->address }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Items</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:15px;">
                    @foreach ($orDetail as $item)
                        <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"
                            class="d-flex flex-col justify-content-between">
                            <span style="display:block;font-size:13px;font-weight:normal;">
                                {{ $item->order_pro->name }}
                            </span>
                            ${{ $item->order_pro->price }}
                            <b style="font-size:12px;font-weight:300;">x{{ $item->quantity }}
                            </b>
                        </p>
                    @endforeach
                    <form action="{{ route('admin.generatePDF', $orDetail[0]->order->order_id) }}" method="get">
                        <button type="submit" class="btn">In PDF</button>
                    </form>
                </td>
            </tr>
        </tbody>
        <tfooter>
            <tr>
                <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
                    <strong style="display:block;margin:0 0 10px 0;">Việt Nam</strong> Thành phố Hồ Chí Minh , <br>
                    Pin/Zip - 723564,590 Đ. Cách Mạng Tháng 8, Phường 11, Quận 3,<br><br>
                    <b>Phone:</b> 0909999999<br>
                    <b>Email:</b> apcake0304@gmail.com
                </td>
            </tr>
        </tfooter>
    </table>
@endsection
