    @extends('backend.Layout.index')
    @section('content')
        <table class="order-details">
            <thead>
                <tr>
                    {{-- <th width="50%" colspan="2">
                        <h2 class="text-start">{{ $appSetting->wedsite_name ?? 'Wedsite Name' }}</h2>
                    </th> --}}
                    <th width="50%" colspan="2" class="text-end company-data">
                        <span>Invoice Id: #{{ $order->id }}</span> <br>
                        <span>Date: {{ date('d/m/Y') }}</span> <br>
                        <span>Zip code : 700000</span> <br>
                        <span>Address: Ho Chi Minh City</span> <br>
                    </th>
                </tr>
                <tr class="bg-blue">
                    <th width="50%" colspan="2">Order Details</th>
                    <th width="50%" colspan="2">User Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Order Id:</td>
                    <td>{{ $order->id }}</td>

                    <td>Full Name:</td>
                    <td>{{ $order->fullname }}</td>
                </tr>
                <tr>
                    <td>Tracking Id/No.:</td>
                    <td>{{ $order->tracking_no }}</td>

                    <td>Email Id:</td>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <td>Ordered Date:</td>
                    <td>{{ $order->created_at->format('d-m-Y h:i A') }}</td>

                    <td>Phone:</td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td>Payment Mode:</td>
                    <td>{{ $order->payment_mode }}</td>

                    <td>Address:</td>
                    <td>{{ $order->address }}</td>
                </tr>
                <tr>
                    <td>Order Status:</td>
                    <td>{{ $order->status_message }}</td>

                    <td>Pin code:</td>
                    <td>{{ $order->pincode }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th class="no-border text-start heading" colspan="5">
                        Order Items
                    </th>
                </tr>
                <tr class="bg-blue">
                    <th>ID</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($order->orderItems as $orderItem)
                    <tr>
                        <td width="10%">{{ $orderItem->id }}</td>
                        <td>
                            {{ $orderItem->product->name }}
                            @if ($orderItem->productColor)
                                @if ($orderItem->productColor->color)
                                    <span>-Color:
                                        {{ $orderItem->productColor->color->name }}</span>
                                @endif
                            @endif
                        </td>
                        <td width="10%">${{ $orderItem->price }}</td>
                        <td width="10%">{{ $orderItem->quantity }}</td>
                        <td width="15%" class="fw-bold">
                            {{ $orderItem->quantity * $orderItem->price }}
                        </td>
                        @php
                            $totalPrice += $orderItem->quantity * $orderItem->price;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="total-heading">Total Amount: - <small>Inc. all vat/tax</small> </td>
                    <td colspan="1" class="total-heading">${{ $totalPrice }}</td>
                </tr>
            </tbody>
        </table>

@endsection