@extends('backend.Layout.index')
@section('content')
    <style>
        th,
        td {
            white-space: nowrap;
        }
    </style>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: {{ session('success') }},
            })
        </script>
    @endif
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
                            <table class="table" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <th style="width: 50px"">#</th>
                                        <th>Thời gian</th>
                                        <th style="width:200px">Nội dung</th>
                                        <th>Sản phẩm</th>
                                        <th>Người đánh
                                            giá</th>
                                        <th>Hiển thị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comment as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td
                                                style="white-space: nowrap;
                                                overflow: hidden;
                                                text-overflow: ellipsis;
                                                ">
                                                {{ $item->comment }}</td>
                                            <td>{{ $item->product_comment->name }}</td>
                                            <td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
                                                {{ $item->user_review->email }}</td>
                                            <td class="d-flex flex-row">
                                                <form action="{{ route('admin.showComment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="token" value="{{ $item->_token }}">
                                                    @if ($item->status == 'Show')
                                                        <button type="submit" name="show" value="show"
                                                            class="btn btn-secondary">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    @else
                                                        <button type="submit" name="show" value="hide"
                                                            class="btn btn-danger ">
                                                            <i class="fa-sharp fa-solid fa-eye-slash"></i>
                                                        </button>
                                                    @endif
                                                </form>
                                                <a href="{{ route('admin.feedback', $item->_token) }}">
                                                    <button class="btn btn-info ml-1">
                                                        <i class="fa-solid fa-reply"></i>
                                                    </button>
                                                </a>
                                                @if (\App\Models\Feedback::where('review_id', $item->review_id)->first() !== null)
                                                    <button class="btn btn-success ml-1" disabled><i
                                                            class="fa-solid fa-check"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-danger ml-1" disabled><i
                                                            class="fa-solid fa-xmark"></i>
                                                    </button>
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
