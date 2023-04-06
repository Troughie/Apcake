@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-header">Product Page :{{ $product->name }}
            <div class="card-body">
                <p class="card-text">Giá thành: {{ $product->product_size->price }}</p>
                <p class="card-text">Sản phẩm đã bán : </p>
                <p class="card-text">Doanh số đã bán : </p>
                <p class="card-text">Sản phẩm còn trong ngày : {{ $product->quantity }}</p>
                <p class="card-text">Mô tả sản phẩm : {{ $product->description ?? 'Không có mô tả'}}</p>
            </div>
        </div>
    </div>
@endsection
