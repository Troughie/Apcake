@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <a href="{{ route('admin.showCategory') }}">
            <button class="btn btn-bg btn-default">Quay lại</button>
        </a>
        
        <div class="card-body">
            <table class="table table-stripped">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Kích thước sản phẩm</th>
                        <th>Giá niêm yết</th>
                        <th>Số lượng hiện có</th>
                        <th>Hình ảnh</th>
                        <th>Điều chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($product as $key)
                        @if ($category->category_id == $key->category_id)
                            <tr style="text-align: center">
                                <td class="product_id">{{ $key->product_id }}</td>
                                <td class="name">{{ $key->name }}</td>
                                <td class="price"> @foreach ($key->product_size as $size)
                                    {{ $size->size }}<br>
                                @endforeach</td>
                                <td class="price"> @foreach ($key->product_size as $size)
                                            {{ $size->price }}<br>
                                        @endforeach</td>
                                <td class="quantity">@foreach ($key->product_size as $size)
                                    {{ $size->instock }}<br>
                                @endforeach</td>
                                </td>
                                <td class="image"><img src="{{ URL::to('uploads/products/' . $key->image) }}"
                                        height="100" width="100"></td>
                                <td>
                                    <a href="{{ route('admin.detailProduct', $key->product_id) }}"
                                        title="View Product"><button class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                aria-hidden="true"></i>
                                            Chi tiết</button></a>
                                    <a href="{{ route('admin.editProduct', $key->product_id) }}"
                                        title="Edit Product"><button class="btn btn-primary btn-sm"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i>Cập nhật</button></a>
                                    <form method="GET" action="{{ route('admin.deleteProduct', $key->product_id) }}"
                                        accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                            onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                                aria-hidden="true"></i>Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
