@extends('backend.Layout.index')
@section('content')
    <div class="card" style="position: relative">
        <div class="card-header">Tên Sản phẩm: {{ $product->name }}
            <div class="card-body">
                <p class="card-text">
                    @foreach ($product->product_size as $key)
                        {{ $key->size }} : Giá niêm yết: {{ number_format($key->price) }} <br>
                    @endforeach
                </p>
                <p class="card-text"><b>Số sản phẩm đã bán: </b>{{ $totalquantity ??'Chưa bán được sản phẩm nào'}} </p>
                <p class="card-text"> <b>Doanh số đã bán: </b>{{ number_format($totalprofit) ??'Chưa bán được sản phẩm nào'}} </p>
                <p class="card-text"><b>Sản phẩm còn</b> <br>
                    @foreach ($product->product_size as $key)
                        {{ $key->size }} còn {{ $key->instock }} sản phẩm <br>
                    @endforeach
                </p>
                <p class="card-text"> <b>Mô tả sản phẩm</b> <br>{{ $product->description ?? 'Không có mô tả' }}</p>

            </div>
            <div style="position: absolute;top:30px;right:90px">
                <img src="{{ URL::to('uploads/products/' . $product->image) }} " width="200px" height="200px">
            </div>
            <a href="{{ route('admin.showProduct') }}">
                <button class="btn btn-bg btn-warning">Quay lại</button>
            </a>
        </div>


    </div>
@endsection
