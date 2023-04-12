@extends('backend.Layout.index')

{{-- @section('head')
    <script src="/ckeditor/ckeditor.js"></script>
@endsection --}}

@section('content')
<a href="{{ route('admin.showProduct') }}">
    <button class="btn btn-bg btn-default">Quay lại</button>
</a>
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
            <table class="table">

                <thead>
                    <td><b>Size</b> </td>
                    <td><b>Giá sản phẩm</b> </td>
                    <td><b>Số lượng</b> </td>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <input type="checkbox" name="size[]" id="sizeS" value="Small" checked> Small
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="priceS" style="display:block" id="priceS"
                                value="priceS">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="instockS" style="display:block" id="instockS"
                                value="instockS">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="checkbox" name="size[]" id="sizeM" value="Medium"> Medium
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="number" class="form-control" name="priceM" style="display:none"
                                    id="priceM" value="price">
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="instockM" style="display:none" id="instockM"
                                value="instockM">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <input type="checkbox" name="size[]" id="sizeL" value="Large"> Large
                            </div>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="priceL" style="display:none" id="priceL"
                                value="price">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="instockL" style="display:none" id="instockL"
                                value="instockL">
                        </td>
                    </tr>
                </tbody>

            </table>
            <br>
            <div class="form-group">
                <label for="description">Mô tả sản phẩm</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
            </div>

            {{-- <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="quantity" placeholder="">
            </div> --}}

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
    {{-- <script>
        if($("#sizeS").attr("checked").click(function(){
            $('#priceS').css('display','block');
        }));        
    </script> --}}
    <script type="text/javascript">
        $('#sizeS').click(function() {
            if ($("#sizeS").is(":checked")) {
                $('#priceS').css('display', 'block ');
                $('#instockS').css('display', 'block ');
            } else {
                $("#priceS").css('display', 'none');
                $("#instockS").css('display', 'none');
            }
        });
        $('#sizeM').click(function() {
            if ($("#sizeM").is(":checked")) {
                $('#priceM').css('display', 'block ');
                $('#instockM').css('display', 'block ');
            } else {
                $("#priceM").css('display', 'none');
                $("#instockM").css('display', 'none');
            }
        });
        $('#sizeL').click(function() {
            if ($("#sizeL").is(":checked")) {
                $('#priceL').css('display', 'block ');
                $('#instockL').css('display', 'block ');
            } else {
                $("#priceL").css('display', 'none');
                $("#instockL").css('display', 'none');
            }
        });
    </script>
@endsection

{{-- @section('foot')
    <script>
        CKEDITOR.replace('description');
    </script> --}}
