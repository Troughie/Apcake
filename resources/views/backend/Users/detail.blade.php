@extends('backend.Layout.index')
@section('content')
    <style>
        .rating input[type="radio"]:not(:nth-of-type(0)) {
            /* hide visually */
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        .rating [type="radio"]:not(:nth-of-type(0))+label {
            display: none;
        }

        label[for]:hover {
            cursor: pointer;
        }

        .rating .stars label:before {
            content: "★";
        }

        .stars label {
            color: lightgray;
        }

        .stars label:hover {
            text-shadow: 0 0 1px #000;
        }

        .rating [type="radio"]:nth-of-type(1):checked~.stars label:nth-of-type(-n+1),
        .rating [type="radio"]:nth-of-type(2):checked~.stars label:nth-of-type(-n+2),
        .rating [type="radio"]:nth-of-type(3):checked~.stars label:nth-of-type(-n+3),
        .rating [type="radio"]:nth-of-type(4):checked~.stars label:nth-of-type(-n+4),
        .rating [type="radio"]:nth-of-type(5):checked~.stars label:nth-of-type(-n+5) {
            color: orange;
        }

        .rating [type="radio"]:nth-of-type(1):focus~.stars label:nth-of-type(1),
        .rating [type="radio"]:nth-of-type(2):focus~.stars label:nth-of-type(2),
        .rating [type="radio"]:nth-of-type(3):focus~.stars label:nth-of-type(3),
        .rating [type="radio"]:nth-of-type(4):focus~.stars label:nth-of-type(4),
        .rating [type="radio"]:nth-of-type(5):focus~.stars label:nth-of-type(5) {
            color: darkorange;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
    </style>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{URL::to('img/comment-1.jpg')}}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px">
                        </div>
                        <p class="card-title text-center mt-2">Tên khách hàng: <b >{{ $user->name }}</b></p>
                        <p class="card-title text-center mt-2">Email: {{ $user->email }}</p>
                        <p class="card-title text-center mt-2">
                            {{ isset($user->deliveryAddress->address) ? $user->deliveryAddress->address : 'User chưa nhập thông tin địa chỉ' }}
                        </p>
                        <p class="card-text text-center">
                            {{ isset($user->deliveryAddress->phone) ? $user->deliveryAddress->phone : '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title col-md-3" style="white-space: nowrap;">Thông tin khách hàng</h5>
                        <div class="row col-md-8">
                            <div class="col-md-6">
                                <p class="card-text"><strong>Tổng số tiền đã chi:</strong>
                                    {{number_format( $user->orders->sum('totalAmount') ?? '' ).' Vnd'}}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Tỏng hóa đơn hàng đã thực hiện:</strong>
                                    @if ($user->orders->firstwhere('user_id', $user->user_id) == '')
                                        <span>Chưa có đơn hàng nào</span>
                                    @else
                                        {{ $user->orders->firstwhere('user_id', $user->user_id)->count() ?? '' }}
                                        <a href="{{ route('admin.order') }}">Chi tiết</a>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Ranking: </strong>{{ $user->ranking->rank_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Tình trạng tài khỏa: </strong>
                                    @if ($user->is_banned)
                                    <label class="text-danger"><i class="fa-solid fa-lock"
                                            style="color: #d1351a;"></i> Đã khóa còn {{now()->diffInDays($user->banned_until)}} ngày</label>
                                @else
                                    <label class="text-success"><i class="fa-solid fa-lock-open"
                                            style="color: #2db944;"> </i> Đang mở</label>
                                @endif 
                                
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body ">
                        <h5 class="card-title col-md-3 ">Đánh giá</h5>
                        <div class=" row col-md-8 py-2">
                            @foreach ($review as $item)
                                <div class="card p-3 w-100">
                                    <div class="">
                                        <p class="card-text"><strong>Nội dung: </strong>{{ $item->comment }}</p>
                                        <div class="d-flex flex-row">
                                            <p class="card-text d-flex"><strong>Rating: </strong>
                                            </p>
                                            <fieldset class="rating" style="margin-bottom: -6px">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $item->rating)
                                                        <input id="demo-{{ $i }}" type="radio" name="review"
                                                            class="review" value="{{ $i }}" checked disabled>
                                                        <label
                                                            for="demo-{{ $i }}">{{ $i }}star</label>
                                                    @else
                                                        <input id="demo-{{ $i }}" type="radio" name="review"
                                                            class="review" value="{{ $i }}" disabled>
                                                        <label
                                                            for="demo-{{ $i }}">{{ $i }}star</label>
                                                    @endif
                                                @endfor
                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <label for="demo-{{ $i }}"
                                                            aria-label="{{ $i }} star"
                                                            title="{{ $i }} star"></label>
                                                    @endfor
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="">
                                        <p class="card-text"><strong>Sản phẩm: </strong> <a
                                                href="{{ $item->product_comment->name }}"></a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
