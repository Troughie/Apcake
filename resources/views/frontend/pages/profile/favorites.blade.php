@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="bg-white rounded p-4">
        @if (session('delsuccess'))
            <div class="alert alert-success">{{ session('delsuccess') }}</div>
        @endif
        <div>
            <h4>Sản phẩm yêu thích</h4>
            <div>Danh sách các sản phẩm mà bạn đã đánh dấu "yêu thích"</div>
        </div>
        <div>
            @if ($favorites !== null)
                @foreach ($favorites as $item)
                    <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                        <a
                            href="{{ route('products', ['id' => $item->product->product_id, 'slug' => Str::slug($item->product->name)]) }}"><img
                                src="{{ URL::to('uploads/products/' . $item->product->image ?? 'resize52.png') }}"
                                alt="" class="picture"
                                style="width: 150px;
                                height: 150px;;object-fit: cover;image-rendering: pixelated;border-radius:30px;"></a>
                        <div class="">
                            <div style="line-height: 0.2" class="mb-3">
                                <h3>{{ $item->product->name }}</h3>
                                <small>{{ $item->product->name }}</small><br>
                            </div>
                            <button class="btn" type="button"><i class="fa fa-heart " aria-hidden="true"
                                    style="box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px; color:red"></i></button>
                            <a
                                href="{{ route('products', ['id' => $item->product->product_id, 'slug' => Str::slug($item->product->name)]) }}"><button
                                    class="btn"><i class="fa-solid fa-cart-shopping"></i>
                                    Xem chi tiết
                                </button></a>
                        </div>
                        @if (count(\App\Models\Size::where('product_id', $item->product->product_id)->get()) == 1)
                            <h6>{{ number_format(\App\Models\Size::where('product_id', $item->product->product_id)->first('price')->price) . ' VND' }}
                            </h6>
                        @else
                            <h6>{{ number_format(\App\Models\Size::where('product_id', $item->product->product_id)->first('price')->price) . ' VND' }}-{{ number_format(\App\Models\Size::where('product_id', $item->product->product_id)->orderBy('price', 'desc')->first()->price) . ' VND' }}
                            </h6>
                        @endif
                        <a href="{{ route('user.delFavo', $item->favorite_id) }}"><button class="btn btn-danger"><i
                                    class="fa-solid fa-trash"></i></button></a>
                    </div>
                @endforeach
            @else
                <div class="Oe"><img loading="lazy"
                        src="https://cdn.divineshop.vn/static/4e0db8ffb1e9cac7c7bc91d497753a2c.svg" class="Ca"
                        alt="Không có sản phẩm yêu thích">
                </div>
            @endif

        </div>
    </div>
@endsection
