@extends('backend.Layout.index')
@section('content')
    <div class="card" style="position: relative"> 
        <div class="card-header">Tên Sản phẩm: {{ $product->name }}
            <div class="card-body">
                <p class="card-text"> @foreach ($product->product_size as $key)
                   Size {{$key->size}} : Giá niêm yết: {{$key->price}} <br>
                    @endforeach
                </p>
                <p class="card-text"><b>Sản phẩm đã bán:</b>  </p>
                <p class="card-text"> <b>Doanh số đã bán: </b> </p>
                <p class="card-text"><b>Sản phẩm tồn</b>  <br> @foreach ($product->product_size as $key)
                    Size {{$key->size}} còn {{$key->instock}} sản phẩm <br>
                    @endforeach</p>
                <p class="card-text"> <b>Mô tả sản phẩm</b>  <br>{{ $product->description ?? 'Không có mô tả'}}</p>

            </div>
            <div  style="position: absolute;top:30px;right:90px">
                    <img src="{{ URL::to('uploads/products/' . $product->image) }} " width="200px" height="200px">
                    
                 
            </div>
        </div>
    </div>
@endsection
