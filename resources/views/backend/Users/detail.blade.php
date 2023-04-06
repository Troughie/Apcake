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
                            <img src="https://via.placeholder.com/150" alt="Profile Picture" class="rounded-circle">
                        </div>
                        <h5 class="card-title text-center mt-2">{{ $user->name }}</h5>
                        <p class="card-text text-center">{{ $user->email }}</p>
                        <p class="card-text text-center">
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
                        <h5 class="card-title col-md-3" style="white-space: nowrap;">Profile Information</h5>
                        <div class="row col-md-8">
                            <div class="col-md-6">
                                <p class="card-text"><strong>Total Amount Spent:</strong>
                                    {{ $user->orders->sum('totalAmount') ?? '' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Total Orders:</strong>
                                    @if ($user->orders->firstwhere('user_id', $user->user_id) == '')
                                        <span>Chua do don hang</span>
                                    @else
                                        {{ $user->orders->firstwhere('user_id', $user->user_id)->count() ?? '' }}
                                        <a href="{{ route('admin.order') }}">Chi tiết</a>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Ranking:</strong>{{ $user->ranking->rank_name }}</p>
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
