@extends('backend.Layout.index')

{{-- @section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection --}}

@section('content')
    <form action="{{ route('admin.addProduct') }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
            <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="">
            </div>
            <div class="form-group">
                <label for="price">Danh mục</label>
                <select name="category_id" id="category_id">
                    @foreach ($categories as $item)
                        <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Size</label>
                <select name="size" id="size">
                    <option value="Small">Small</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="Large">Large</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Giá sản phẩm</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="">
            </div>

            <div class="form-group">
                <label for="description">Mô tả sản phẩm</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="">
            </div>

            <div class="form-group">
                <label for="image">Ảnh sản phẩm</label>
                <div class="form-group">
                    <label for="image"></label>
                    <input type="file" class="form-control" multiple id="image" name="image">
                </div>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <option value="0">Ẩn</option>
                    <option value="1" selected>Hiện</option>
                </select>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="submit-form">Thêm sản phẩm</button>
        </div>
        @csrf
    </form>
@endsection

{{-- @section('foot')
    <script>
        CKEDITOR.replace('description');
    </script> --}}

{{-- <script>
        $(document).ready(function() {
            $('#submit-form').click(function(){
                swal("Add Product success!", "Click to continue!", "success");
                return false;
            });

        });
    </script> --}}
{{-- @endsection --}}
