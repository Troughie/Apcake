@extends('backend.Layout.index')


@section('content')
    @if (session('flash_message'))
        <p>{{ session('flash_message') }}</p>
    @endif

    <form action="{{ route('admin.addCategory') }}" method="POST">

        <div class="card-body">
            <div class="form-group">
                <label for="category_name">Tên Danh mục</label>
                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
        </div>
        @csrf
    </form>
@endsection
