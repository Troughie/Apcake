@extends('backend.Layout.index')
@section('content')
    <div class="card">
        @if (session('fail_cate_des'))
            <div class="alert alert-danger">
                {{ session('fail_cate_des') }}
            </div>
        @endif
        <div class="card-body">
            <div class="col-md-8 offset-md-2">
                <form action="#">
                    <div class="input-group">
                        <div class="float-right">
                            <button type="" class="btn btn-bg btn-default">
                                <a href="{{ route('admin.addCategory') }}" class="fas fa-plus"> </a>
                                Thêm danh mục mới </button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
            <table class="table col-md-8 offset-md-2">
                <thead>
                    <tr style="text-align:center">
                        <th>#</th>
                        <th>Tên Danh mục sản phẩm</th>
                        <th>Điều khiển</th>
                    </tr>
                </thead>
                <tbody style="text-align:center">
                    @foreach ($category as $item)
                        <tr>
                            <td>{{ $item->category_id }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>
                                <a href="{{ route('admin.detailCategory', $item->category_id) }}">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true">
                                        </i> Chi Tiết
                                    </button>
                                </a>
                                <a href="{{ route('admin.editCategory', $item->category_id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true">
                                        </i>Cập nhật
                                    </button>
                                </a>
                                <form method="get" action="{{ route('admin.deleteCategory', $item->category_id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>Xóa</button>
                                </form>
                            </td>
                    @endforeach
                    </tr>
                    {{-- @foreach ($category as $item)
                        <td>
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i class="right fas fa-angle-left"></i>
                                    <p>{{ $item->category_id }}
                                    </p>
                                </a>
                            </td>
                                <ul>
                                    <tr>
                                        {{-- <td>{{ $item->category_id }}</td>
                                        <td>{{ $item->category_name }}</td>
                                        <td>{{$item->category_id}}</td>
                                </ul>
                            </li>
                        </td> --}}

                    {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.html" class="nav-link">
                                    <i class="far nav-icon"></i>
                                    <p>Dashboard v1</p>
                                </a>
                            </li> --}}
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    @endsection
