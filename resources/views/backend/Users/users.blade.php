@extends('backend.Layout.index')
@section('content')
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
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role }}</td>
                                            {{-- <td>{{ $item->orders->firstwhere('user_id', $item->user_id)->order_date }}</td> --}}

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