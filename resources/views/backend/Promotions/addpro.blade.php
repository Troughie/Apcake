@extends('backend.Layout.index')


@section('content')
    <form action="{{ route('admin.storepro') }}" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Mã giảm giá</label>
                <input type="text" class="form-control" name="coupon" id="coupon" value="{{ old('coupon') }}">
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select name="status" id="status">
                    @if (old('status') == 'many')
                        <option value="one">Dùng 1 lần cho 1 user</option>
                        <option value="many"selected>Dùng đến khi hết hạn</option>
                    @else
                        <option value="one" selected>Dùng 1 lần cho 1 user</option>
                        <option value="many">Dùng đến khi hết hạn</option>
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label>Sản phẩm(danh mục) nếu có</label>
                <input type="number" class="form-control" name="product" id="product" value="{{ old('product') }}">
            </div>

            <div class="form-group">
                <label>Số tiền giảm</label>
                <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}">
            </div>

            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity') }}">
            </div>
            <div class="form-group">
                <label>Ngày bắt đầu</label>
                <input type="date" class="" name="startdate" id="startdate" value="{{ old('startdate') }}">
            </div>
            <div class="form-group">
                <label>Ngày kết thúc</label>
                <input type="date" class="" name="enddate" id="enddate" value="{{ old('enddate') }}">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="submit-form">Thêm mã giảm giá</button>
        </div>
        @csrf
    </form>
@endsection
