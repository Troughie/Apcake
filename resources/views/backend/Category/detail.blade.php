@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-header">Detail Category Page</div>
        <div class="card-body">
            <td>Name : {{ $category->category_name }}</td>


        </div>
    </div>
@endsection
