@extends('backend.Layout.index')


@section('content')
    <form action="{{ route('admin.storepro') }}" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Mã giảm giá</label>
                <input type="text" class="form-control" minlength="8" name="coupon" id="coupon"
                    value="{{ old('coupon') }}" placeholder="mã giảm giá" required
                    oninvalid="this.setCustomValidity('Mã giảm giá phải có 8 ký tự')">
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
                <label>Danh mục sản phẩm nếu có</label>
                <select name="product" class="form-control" id="product" value="{{ old('product') }}">
                    <option value="">--Choose cate---</option>
                    @foreach ($category as $item)
                        <option value="{{ $item->category_id }}">{{ $item->category_id }} {{ $item->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Số tiền giảm (%)</label>
                <input class="form-control"
                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    type="number" maxlength="3" name="price" id="price" value="{{ old('price') }}" required
                    oninvalid="this.setCustomValidity('Phải điền số tiền giảm')">
            </div>
            <div class="form-group">
                <label>Số tiền tối thiểu</label>
                <input type="number" class="form-control" name="minprice" id="minprice" value="{{ old('minprice') }}">
            </div>

            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" class="form-control" name="quantity" id="quantity" value="{{ old('quantity') }}"
                    required oninvalid="this.setCustomValidity('Phải điền số lượng mã giảm giá')">
            </div>
            <div class="form-group">
                <label>Ngày bắt đầu</label>
                <input type="date" class="" name="startdate" id="startdate" value="{{ old('startdate') }}" required
                    oninvalid="this.setCustomValidity('Phải điền ngày bắt đầu')">
            </div>
            <div class="form-group">
                <label>Ngày kết thúc</label>
                <input type="date" class="" name="enddate" id="enddate" value="{{ old('enddate') }}" required
                    oninvalid="this.setCustomValidity('Phải điền ngày kết thúc')">
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" id="submit-form">Thêm mã giảm giá</button>
        </div>
        @csrf
    </form>
@endsection
