@extends('backend.Layout.index')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Chỉnh sửa Danh mục</div>
        <div class="card-body">

            <form action="{{ route('admin.updateCategory', $category->category_id)}}" method="POST">
                {!! csrf_field() !!}
                @method('POST')
                <label>Tên Danh mục</label>
                <input type="text" name="category_name" id="category_name" value=""/>
                
                {{-- <input type="radio" name="role" id="role" @if ($user->role === 'ADM') checked @endif
                    class="radio-inline" value="ADM">ADMIN
                <input type="radio" name="role" id="role" @if ($user->role === 'USR') checked @endif
                    class="radio-inline" value="USR">USER</br> --}}
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>

        </div>
    </div>
@endsection
