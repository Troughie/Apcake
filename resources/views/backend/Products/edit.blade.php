@extends('backend.Layout.index')

@section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection

@section('content')

    <div class="card" style="margin:20px;">

        <div class="card-body">

            <form class="form-group" action="{{ route('admin.updateProduct', $product->product_id) }}" method="POST">
                {!! csrf_field() !!}
                @method('POST')
                <div class="form-group">
                    <label>Tên Sản phẩm: </label>
                    <input class="form-control" type="text" name="name" id="name" value="" />
                </div>
                <div class="form-group">
                    <label for="price">Tên Danh mục: </label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $item)
                            <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Giá tiền: </label>
                    <input class="form-control" type="text" name="price" id="price" value="" />
                </div>
                <div class="form-group">
                    <label>Số lượng: </label>
                    <input class="form-control" type="text" name="quantity" id="quantity" value="" />
                </div>

                <div class="form-group"> <label>Mô Tả: </label>
                    <textarea class="form-control" name="description" id="description" cols="20" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input class="form-control" type="file" name="image" id="image" value="" />
                </div>

                {{-- <input type="radio" name="role" id="role" @if ($user->role === 'ADM') checked @endif
                    class="radio-inline" value="ADM">ADMIN
                <input type="radio" name="role" id="role" @if ($user->role === 'USR') checked @endif
                    class="radio-inline" value="USR">USER</br> --}}
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>

        </div>
    </div>
@endsection

@section('foot')
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection