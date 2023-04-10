@extends('backend.Layout.index')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>User list</h2>
                    </div>
                    <div class="card-body">

                        <br />
                        {{-- @if ($flash_message)
                            {
                            <p>{{ $flash_message }}</p>
                            }
                        @endif --}}
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>#</th>
                                        <th>Tên Khách hàng</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tình trạng</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr style="text-align: center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role }}</td>
                                            {{-- <td>{{ $item->orders->firstwhere('user_id', $item->user_id)->order_date }}</td> --}}
                                            <td>
                                                @if ($item->is_banned)
                                                    <label class="text-danger"><i class="fa-solid fa-lock"
                                                            style="color: #d1351a;"></i> Đã khóa</label>
                                                @else
                                                    <label class="text-success"><i class="fa-solid fa-lock-open"
                                                            style="color: #2db944;"> </i> Đang mở</label>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $item->user_id) }}"
                                                    title="View Student"><button class="btn btn-info btn-sm"><i
                                                            class="fa fa-eye" aria-hidden="true"></i>
                                                        View</button></a>
                                                <a href="{{ route('admin.users.edit', $item->user_id) }}"
                                                    title="Edit Student"><button class="btn btn-primary btn-sm"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Edit</button></a>

                                                <form method="GET"
                                                    action="{{ route('admin.users.destroy', $item->user_id) }}"
                                                    accept-charset="UTF-8" style="display:inline">
                                                    @method('DELETE')
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete Student" onclick="return confirm("Confirm
                                                        delete?")"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        Delete</button>
                                                </form>

                                                @if ($item->is_banned)
                                                    <a href="{{ route('admin.Unban', $item->user_id) }}"
                                                        class="btn btn-success btn-sm">Mở Khóa</a>
                                                @else
                                                    <div class="modal fade" id="sortModal-{{ $item->user_id }}"
                                                        class="sortModal" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content w-70">
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ route('admin.ban', $item->user_id) }}"
                                                                        accept-charset="UTF-8" style="display:inline">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="days">Chọn thời gian khóa tài
                                                                                khoản</label>
                                                                            <input type="number" name="days"
                                                                                class="form-control" id="days" placeholder="Thời giam khóa tạm thời">
                                                                        </div>
                                                                        <button type="submit" name="temporary"
                                                                            class="btn btn-warning">Khóa thời hạn</button>
                                                                        <button type="submit" name="permanent"
                                                                            class="btn btn-danger">Khóa vĩnh viễn</button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($item->is_banned)
                                                    <form action="{{ route('admin.Unban', $item->user_id) }}" method="GET">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">Mở Khóa</button>
                                                    </form>
                                                    @else
                                                        <button type="submit" class="btn btn-warning btn-sm" data-toggle="modal"
                                                        data-target="#sortModal-{{$item->user_id }}" title="Delete"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i>Khóa</button>
                                                   
                                                    @endif
                                                @endif

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
