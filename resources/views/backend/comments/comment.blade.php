@extends('backend.index')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Comment</h2>
                    </div>
                    <div class="card-body">
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div id="user-list">
                                        @foreach ($comment as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->comment }}</td>
                                                <td>{{ $item->rating }}</td>
                                                <td>{{ $item->product_comment->name }}</td>
                                                <td>{{ $item->user_review->email }}</td>
                                                <td>{{ $item->created_at ?? ' ' }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </div>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
