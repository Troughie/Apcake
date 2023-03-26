@extends('backend.Layout.index')

{{-- @section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection --}}

@section('content')

    <div class="card" style="margin:20px;">

        <div class="card-body">

            <form class="form-group" action="{{ route('admin.updateProduct', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('POST')
                <div class="form-group">
                    <label>Tên Sản phẩm: </label>
                    <input class="form-control" type="text" name="name" id="name" value="{{$product->name}}" placeholder="{{$product->name}}" />
                </div>
                <div class="form-group">
                    <label for="price">Tên Danh mục: </label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $item)
                        @if($item->category_id==$product->category_id)
                        <option selected value="{{ old( $item->category_id) }}">{{ $item->category_name }}</option>
                        @else
                        <option value="{{ old( $item->category_id) }}">{{ $item->category_name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Giá tiền: </label>
                    <input class="form-control" type="text" name="price" id="price" value="{{$product->price}}" placeholder="{{$product->price}}" />
                </div>
                <div class="form-group">
                    <label>Số lượng: </label>
                    <input class="form-control" type="text" name="quantity" id="quantity" value="{{$product->quantity}}" placeholder="{{$product->quantity}}"/>
                </div>

                <div class="form-group"> <label>Mô Tả: </label>
                    <textarea class="form-control" name="description" id="description" cols="20" rows="5" value="{{$product->description}}" placeholder="{{$product->description}}"></textarea>
                </div>

                <div class="form-group">
                    <label>Hình ảnh</label>
                    <input class="form-control" type="file" name="image" id="image" />
                    <div class="image_show">
                        <img src="{{ URL::to('uploads/products/' . $product->image) }}"
                        height="100" width="100">
                    </div>
                    
                </div>
                <input type="submit" value="Update" class="btn btn-success"><br>
            </form>

        </div>
    </div>
@endsection

{{-- @section('foot')
    <script>
        CKEDITOR.replace('description');
    </script>

@endsection --}}