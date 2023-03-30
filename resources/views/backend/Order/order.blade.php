@extends('backend.Layout.index')
@section('content')
    <div class="container">
        <div class="mt-5">
            <div class="d-flex flex-col justify-content-between">
                <div>
                    <div class="form-check row">
                        <input class="form-check-input status" type="radio" name="status" value="2" id="status">
                        <label class="form-check-label">
                            Da thanh toan
                        </label>
                    </div>
                    <div class="form-check row">
                        <input class="form-check-input status" type="radio" name="status" value="1" id="status">
                        <label class="form-check-label">
                            Chua thanh toan
                        </label>
                    </div>
                    <div class="form-check row">
                        <input class="form-check-input status" type="radio" name="status" value="3" id="status">
                        <label class="form-check-label">
                            Cho xac nhan
                        </label>
                    </div>
                </div>
                <div>
                    <div class="form-check row">
                        <input class="form-check-input payment" type="radio" name="payment" value="1" id="payment">
                        <label class="form-check-label">
                            cod
                        </label>
                    </div>
                    <div class="form-check row">
                        <input class="form-check-input payment" type="radio" name="payment" value="2" id="payment">
                        <label class="form-check-label">
                            vnpay
                        </label>
                    </div>
                </div>
                <div>
                    <div><input type="text" name="amount_from" class="priceFrom"><br><label>Số tiền từ</label></div>
                </div>
                <div>
                    <div><input type="text" name="amount_to" class="priceTo"><br><label>Số tiền đến</label></div>
                </div>
                <div>
                    <div><input name="date_from" type="date" class="dateFrom"><br><label>Từ
                            ngày</label></div>
                </div>
                <div>
                    <div><input name="date_to" type="date" class="dateTo"><br><label>Đến
                            ngày</label></div>
                </div>
            </div>
            <div class="mt-3 d-flex flex-col"><button id="filter"
                    class="btn btn-primary d-flex flex-col align-items-center " type="submit">
                    <i class="fa-solid fa-filter"></i>
                    <div class="pl-1">Lọc</div>
                </button>
                <button id="clearFilterBtn" class="btn btn-default ml-3">Clear filter</button>
            </div>
        </div>

        <div class="border my-4"></div>
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
            <tbody id="tbody">
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
                        <td><a href="{{ route('admin.orderdetail', $item->order_id) }}">Chi tiet</a></td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script>
        $('#filter').click(function(e) {
            e.preventDefault();
            const status = $("input[name='status']:checked").val();
            const payment = $("input[name='payment']:checked").val();
            const priceFrom = $('.priceFrom').val()
            const priceTo = $('.priceTo').val()
            const dateFrom = $('.dateFrom').val()
            const dateTo = $('.dateTo').val()
            $.ajax({
                url: '{{ route('admin.search') }}',
                type: 'POST',
                data: {
                    'status': status,
                    'payment': payment,
                    'priceFrom': priceFrom,
                    'priceTo': priceTo,
                    'dateFrom': dateFrom,
                    'dateTo': dateTo,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(response) {
                    $('#tbody').html(response.records)
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        })

        $('#clearFilterBtn').click(function() {
            // Đặt lại giá trị của các trường trong form filter
            $('input[name="status"]').prop('checked', false);
            $('input[name="payment"]').prop('checked', false);
            $('input[name="amount_from"]').val('');
            $('input[name="amount_to"]').val('');
            $('input[name="date_from"]').val('');
            $('input[name="date_to"]').val('');
        });
    </script>
@endsection
