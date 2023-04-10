@extends('backend.Layout.index')
@section('content')
    <div class="container my-4 card">
        <table class="table table-bordered ">
            <thead class="table-light">
                <tr>
                    <th class="d-flex justify-content-start align-items-center"><img style="width: 20%"
                            src="{{ asset('img/apcake_logo.png') }}" alt="bachana tours">
                    </th>
                    <th class="text-right" style="padding-bottom:70px">
                        <span>{{ $orDetail[0]->order->created_at }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="line-height: 2">
                    <td colspan="2"><span class="d-flex flex-row justify-content-between">Order
                            status<b>{{ $orDetail[0]->order->order_sta->name }}</b></span>

                        <span class="d-flex flex-row justify-content-between">Order amount
                            <b>{{ number_format($orDetail[0]->order->totalAmount) . 'VND' }}</b></span>
                    </td>
                </tr>
                <tr>
                    <td style="line-height: 2"><span
                            class="d-flex flex-row justify-content-between">Name:<b>{{ $order->user->name ?? '' }}</b></span>
                        <span
                            class="d-flex flex-row justify-content-between">Email:<b>{{ $orDetail[0]->order->email }}</b></span>
                        <span
                            class="d-flex flex-row justify-content-between">Phone:<b>{{ $orDetail[0]->order->phone }}</b></span>
                    </td>
                    <td><span
                            class="d-flex flex-row justify-content-between">Address:<b>{{ $orDetail[0]->order->address }}</b></span>
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="2" class="text-center" style="transform: translateX(-50px);font-size: 70px">Items</td>
                </tr>
                @if (count($orDetail) > 0)
                    @foreach ($orDetail as $item)
                        <tr>
                            <td>
                                <span>{{ $order_pro[$item->size][$item->product_id]->productSize->name }}</span>
                            </td>
                            <td class="d-flex justify-content-between">
                                <strong>
                                    <?= number_format($order_pro[$item->size][$item->product_id]->price) ?>VND
                                    x {{ $item->quantity }}</strong>
                                <b><?= number_format($order_pro[$item->size][$item->product_id]->price * $item->quantity) ?>VND
                                </b>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="card">
        <form action="{{ route('admin.generatePDF', $orDetail[0]->order->order_id) }}" method="get">
            <button class="btn btn-primary">in Pdf</button>
        </form>
    </div>
@endsection
