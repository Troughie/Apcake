@extends('backend.Layout.index')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    @if (session('couponsuccess'))
                        <div class="alert alert-success">
                            {{ session('couponsuccess') }}
                        </div>
                    @endif
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">

                        
                        <button class="btn btn-outline-secondary"><a href="{{ route('admin.addpro') }}">Thêm mới</a></button>

                        <h2>Promotions</h2>
                        <button class="btn btn-outline-secondary"><a href="{{ route('admin.addpro') }}">Thêm mã giảm
                                giá</a></button>

                    </div>
                    <div class="card-body">
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>Sản phẩm </th>
                                        <th>Code</th>
                                        <th>Số lượng</th>
                                        <th>Loại</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupon as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product_id ?? 'Áp dụng cho mọi sản phẩm' }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->discountQuantity }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->startDate }}</td>
                                            <td>{{ $item->endDate }}</td>
                                            <td>
                                                <form action="{{ route('admin.delpro', $item->promotion_id) }}"
                                                    method="get">
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
