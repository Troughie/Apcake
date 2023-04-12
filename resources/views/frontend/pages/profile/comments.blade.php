@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="bg-white rounded p-4">
        <div class="border my-5"></div>
        @if ($comment->count('_token') == 0)
            <strong>Bạn chưa có bình luận nào</strong>
        @else
            <table class="table ">
                <thead>
                    <tr>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Nội dung</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comment as $item)
                        <tr>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->product_comment->name }}</td>
                            <td>{{ $item->comment }}</td>
                            <td><a
                                    href="{{ route('products', ['id' => $item->product_comment->product_id, 'slug' => Str::slug($item->product_comment->name)]) }}">chi
                                    tiet</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
