@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-stripped" id="showProduct">
                <div class="container col-md-8 offset-md-2">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="">
                                <div class="d-flex flex-row">
                                    <button type="button" class="btn btn-gb btn-default">
                                        <a href="{{ route('admin.addProduct') }}" class="fas fa-plus"> Add New</a>
                                    </button>
                                    <button type="button" class="btn btn-gb btn-default">
                                        <a href="{{ route('admin.showProduct') }}" class="fas fa-eye"> Show All</a>
                                    </button>
                                </div>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <form action="{{ route('admin.searchProduct') }}" method="POST">
                                @csrf
                                <div class="d-flex flex-row">
                                    <input name="search" type="search" class="form-control form-control-sm"
                                        placeholder="Search ...">
                                    <div class="">
                                        <button type="submit" class="btn btn-sm btn-default ">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <br>
                    <thead style="text-align: center">
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại danh mục</th>
                            <th>Kích thước</th>
                            <th>Giá (VND)</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Hình ảnh</th>
                            <th>Điều chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($result))
                            @foreach ($result as $key)
                                <tr style="text-align: center">
                                    <td class="product_id">{{ $key->product_id }}</td>
                                    <td class="name">{{ $key->name }}</td>
                                    @foreach ($categories as $item)
                                        @if ($item->category_id == $key->category_id)
                                            <td>{{ $item->category_name }}</td>
                                        @endif
                                    @endforeach
                                    <td>{{ $key->size }}</td>
                                    <td class="price">{{ $key->price }}</td>
                                    <td class="quantity">{{ $key->quantity }}</td>
                                    {{-- <td class="description">{{ Str::between($key->description, '<p>', '</p>') }}
                                    </td> --}}
                                    @if ($key->status == 0)
                                        <td class="status">
                                            <a href="{{ route('admin.activeProduct', $key->product_id) }}"
                                                class="fa fa-thumbs-down" style="color: #cc3608;"></a>
                                        </td>
                                    @else
                                        <td class="status">
                                            <a href="{{ route('admin.unactiveProduct', $key->product_id) }}"
                                                class="fa fa-thumbs-up" style="color: #1bde0d;"></a>
                                        </td>
                                    @endif
                                    <td class="image"><img src="{{ URL::to('uploads/products/' . $key->image) }}"
                                            height="70" width="70"></td>
                                    <td>
                                        <a href="{{ route('admin.detailProduct', $key->product_id) }}"
                                            title="View Product"><button class="btn btn-info btn-sm"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                                Detail</button></a>
                                        <a href="{{ route('admin.editProduct', $key->product_id) }}"
                                            title="Edit Product"><button class="btn btn-primary btn-sm"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</button></a>
                                        <form method="GET" action="{{ route('admin.deleteProduct', $key->product_id) }}"
                                            accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- @foreach ($size as $size) --}}
                                @foreach ($product as $item)
                                    {{-- @if ($size->product_id == $item->product_id) --}}
                                        <tr style="text-align: center">
                                            <td>{{ $item->product_id }}</td>
                                            <td>{{ $item->name }}</td>

                                            @foreach ($categories as $key)
                                                @if ($key->category_id == $item->category_id)
                                                    <td class="category_name">{{ $key->category_name }}</td>
                                                @endif
                                            @endforeach

                                            <td>
                                                @foreach ($item->product_size as $size)
                                                    {{$size->size}} <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->product_size as $size)
                                                    {{$size->price}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($item->product_size as $size)
                                                    {{$size->instock}}<br>
                                                @endforeach
                                            </td>

                                            @if ($item->status == 0)
                                                <td class="status">
                                                    <a href="{{ route('admin.activeProduct', $item->product_id) }}"
                                                        class="fa fa-thumbs-down" style="color: #cc3608;"></a>
                                                </td>
                                            @else
                                                <td class="status">
                                                    <a href="{{ route('admin.unactiveProduct', $item->product_id) }}"
                                                        class="fa fa-thumbs-up" style="color: #1bde0d;"></a>
                                                </td>
                                            @endif

                                            {{-- <td>{{ Str::between($item->description, '<p>', '</p>') }}
                                    </td> --}}
                                            <td style="text-align: center">
                                                <img src="{{ URL::to('uploads/products/' . $item->image) }}" height="70"
                                                    width="70">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.detailProduct', $item->product_id) }}"
                                                    title="View Product"><button class="btn btn-info btn-sm"><i
                                                            class="fa fa-eye" aria-hidden="true"></i>
                                                        Detail</button></a>
                                                <a href="{{ route('admin.editProduct', $item->product_id) }}"
                                                    title="Edit Product"><button class="btn btn-primary btn-sm"><i
                                                            class="fa fa-pencil-square-o"
                                                            aria-hidden="true"></i>Edit</button></a>
                                                <form method="GET"
                                                    action="{{ route('admin.deleteProduct', $item->product_id) }}"
                                                    accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                            class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    {{-- @endif --}}
                                @endforeach
                            {{-- @endforeach --}}
                        @endif

                    </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $product->links() }}
            </div>

        </div>
    </div>
@endsection

<script>
    $(document).ready(function() {
        $('#showProduct').DataTable();
    });
</script>
