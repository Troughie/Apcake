@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-md-8 offset-md-2">
                <form action="#">
                    <div class="input-group">
                        <div class="float-right">
                            <button type="" class="btn btn-sm btn-default">
                                <a href="{{ route('admin.addCategory') }}" class="fas fa-plus"> Add New</a>
                            </button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
            <table class="table col-md-8 offset-md-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Danh mục sản phẩm</th>
                        <th>Điều khiển</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $item)
                    <tr>
                            <td>{{ $item->category_id }}</td>
                            <td>{{ $item->category_name }}</td>
                            <td>
                                <a href="{{ route('admin.detailCategory', $item->category_id) }}">
                                    <button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true">
                                        </i> View
                                    </button>
                                </a>
                                <a href="{{ route('admin.editCategory', $item->category_id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true">
                                        </i>Edit
                                    </button>
                                </a>
                                <form method="get" action="{{ route('admin.deleteCategory', $item->category_id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>Delete</button>
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
