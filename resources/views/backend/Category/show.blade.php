@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
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
