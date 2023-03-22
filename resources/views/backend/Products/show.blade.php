@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form action="simple-results.html">
                                <div class="input-group">
                                    <div class="float-right">
                                        <button type="" class="btn btn-sm btn-default">
                                            <a href="{{ route('admin.addProduct') }}" class="fas fa-plus"> Add New</a> 
                                        </button>
                                    </div>
                                        <input type="search" class="form-control form-control-sm" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </section>
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center">
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Mô tả</th>
                        <th>Hình ảnh</th>
                        <th>Điều chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr style="text-align: center">
                            <td>{{ $item->product_id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ Str::between($item->description, '<p>', '</p>') }}</td>
                            <td><img src="{{ URL::to('uploads/products/' . $item->image) }}" height="100" width="100">
                            </td>
                            <td>
                                <a href="{{ route('admin.detailProduct', $item->product_id) }}" title="View Product"><button
                                        class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                        View</button></a>
                                <a href="{{ route('admin.editProduct', $item->product_id) }}" title="Edit Product"><button
                                        class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o"
                                            aria-hidden="true"></i>Edit</button></a>
                                <form method="GET" action="{{ route('admin.deleteProduct', $item->product_id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Student"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                            aria-hidden="true"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    @endsection
