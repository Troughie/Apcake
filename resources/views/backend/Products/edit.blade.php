@extends('backend.Layout.index')

{{-- @section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection --}}

@section('content')
    <div class="card" style="margin:20px;">

        <div class="card-body">

            <form class="form-group" action="{{ route('admin.updateProduct', $product->product_id) }}" method="POST"
                enctype="multipart/form-data">
                {!! csrf_field() !!}
                @method('POST')
                <div class="form-group">
                    <label>Tên Sản phẩm: </label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ $product->name }}"
                        placeholder="{{ $product->name }}" />
                </div>
                <div class="form-group">
                    <label for="price">Tên Danh mục: </label> <br>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $item)
                            @if ($item->category_id == $product->category_id)
                                <option selected value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                            @else
                                <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <table class="table">
                        <thead>
                            <td><b>Size</b> </td>
                            <td><b>Giá sản phẩm</b> </td>
                            <td><b>Số lượng</b> </td>
                        </thead>
                        @foreach ($size as $item)
                            <tr>
                                <td>
                                    <div>
                                        <input type="checkbox" name="size[]" id="size{{ $size_name[$item->size]->size }}"
                                            value="{{ $size_name[$item->size]->size }}" checked>
                                        {{ $size_name[$item->size]->size }}
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="price{{ $size_name[$item->size]->size }}" style="display:block"
                                        id="price{{ $size_name[$item->size]->size }}"
                                        value="{{ $size_name[$item->size]->price }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control"
                                        name="instock{{ $size_name[$item->size]->size }}" style="display:block"
                                        id="instock{{ $size_name[$item->size]->size }}"
                                        value="{{ $size_name[$item->size]->instock }}">
                                </td>
                            </tr>
                        @endforeach
                        @if (count($size_left) > 0)
                            @foreach ($size_left as $key)
                                <tr>
                                    <td>
                                        <div>
                                            <input type="checkbox" name="size[]" id="size{{ $key }}"
                                                value="{{ $key }}"> {{ $key }}

                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="price{{ $key }}"
                                            style="display:none" id="price{{ $key }}" value="">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="instock{{ $key }}"
                                            style="display:none" id="instock{{ $key }}" value="">
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </table>
                </div>
                <script type="text/javascript">
                    $('#sizeSmall').click(function() {
                        if ($("#sizeSmall").is(":checked")) {
                            $('#priceSmall').css('display', 'block ');
                            $('#instockSmall').css('display', 'block ');
                        } else {
                            $("#priceSmall").css('display', 'none');
                            $("#instockSmall").css('display', 'none');
                        }
                    });
                    $('#sizeMedium').click(function() {
                        if ($("#sizeMedium").is(":checked")) {
                            $('#priceMedium').css('display', 'block ');
                            $('#instockMedium').css('display', 'block ');
                        } else {
                            $("#priceMedium").css('display', 'none');
                            $("#instockMedium").css('display', 'none');
                        }
                    });
                    $('#sizeLarge').click(function() {
                        if ($("#sizeLarge").is(":checked")) {
                            $('#priceLarge').css('display', 'block ');
                            $('#instockLarge').css('display', 'block ');
                        } else {
                            $("#priceLarge").css('display', 'none');
                            $("#instockLarge").css('display', 'none');
                        }
                    });
                </script>

                <div class="form-group"> <label>Mô Tả: </label>
                    <textarea class="form-control" name="description" id="description" cols="20" rows="5">{{ $product->description ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>Hình ảnh sản phẩm: </label>
                    <input class="form-control" type="file" name="image" id="image" multiple /><br>

                    <div class="image_show">
                        <img src="{{ URL::to('uploads/products/' . $product->image) }}" height="150px" width="150px">
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Trạng thái: </label>
                    <select name="status" id="status">
                        <option value="0">Ẩn</option>
                        <option value="1" selected>Hiện</option>
                    </select>
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
