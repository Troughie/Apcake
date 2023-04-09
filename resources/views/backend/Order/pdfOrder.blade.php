<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container my-4 card">
        <table class="table table-bordered ">
            <thead class="table-light">
                <tr>
                    <th class="d-flex justify-content-start align-items-center"><img style="width: 20%"
                            src="{{ asset('img/apcake_logo.png') }}" alt="bachana tours">
                    </th>
                    <th class="text-right" style="padding-bottom:70px">
                        <span>{{ $orDetail[0]['order']['created_at'] }}</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr style="line-height: 2">
                    <td colspan="2"><span class="d-flex flex-row justify-content-between">Order
                            status<b>{{ $orDetail[0]['order']['order_sta']['name'] }}</b></span>

                        <span class="d-flex flex-row justify-content-between">Order amount
                            <b>{{ number_format($orDetail[0]['order']['totalAmount']) . 'VND' }}</b></span>
                    </td>
                </tr>
                <tr>
                    <td style="line-height: 2"><span
                            class="d-flex flex-row justify-content-between">Name:<b>{{ $order['user']['name'] ?? '' }}</b></span>
                        <span
                            class="d-flex flex-row justify-content-between">Email:<b>{{ $orDetail[0]['order']['email'] }}</b></span>
                        <span
                            class="d-flex flex-row justify-content-between">Phone:<b>{{ $orDetail[0]['order']['phone'] }}</b></span>
                    </td>
                    <td><span
                            class="d-flex flex-row justify-content-between">Address:<b>{{ $orDetail[0]['order']['address'] }}</b></span>
                    </td>
                </tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr>
                    <td colspan="2" class="text-center" style="transform: translateX(-50px);font-size: 70px">Items
                    </td>
                </tr>
                @if (count($orDetail) > 0)
                    @foreach ($orDetail as $item)
                        <tr>
                            <td>
                                <span>{{ $order_pro[$item['size']][$item['product_id']]['product_size']['name'] }}</span>
                            </td>
                            <td class="d-flex justify-content-between">
                                <strong>
                                    <?= number_format($order_pro[$item['size']][$item['product_id']]['price']) ?>VND
                                    x {{ $item['quantity'] }}</strong>
                                <b><?= number_format($order_pro[$item['size']][$item['product_id']]['price'] * $item['quantity']) ?>VND
                                </b>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
