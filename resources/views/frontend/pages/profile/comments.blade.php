@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="bg-white rounded p-4">
        <div class="border my-5"></div>
        <table class="table ">
            <thead>
                <tr>
                    <th scope="col">Thời gian</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comment as $item)
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->comment }}</td>
                        <td><a href="#">chi tiet</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
