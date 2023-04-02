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
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Comment</h2>
                    </div>
                    <div class="card-body">
                        <div class="card mb-4 p-5">
                            <p>{{ $review->comment }}</p>
                            <div class="d-flex justify-content-between align-items-center">

                                {{-- Rating and name user --}}
                                <div class="d-flex flex-row align-items-center">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp" alt="avatar"
                                        width="25" height="25" />
                                    <p class="small mb-0 mx-2">
                                        {{ $review->user_review->name }}
                                    </p>
                                    <fieldset class="rating" style="margin-bottom: -6px">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <input id="demo-{{ $i }}" type="radio" name="review"
                                                    class="review" value="{{ $i }}" checked disabled>
                                                <label for="demo-{{ $i }}">{{ $i }}star</label>
                                            @else
                                                <input id="demo-{{ $i }}" type="radio" name="review"
                                                    class="review" value="{{ $i }}" disabled>
                                                <label for="demo-{{ $i }}">{{ $i }}star</label>
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
                                <span>{{ $review->created_at }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="margin-top:-80px">
                        <form action="{{ route('admin.postFeedback') }}" method="POST">
                            @csrf
                            <div>
                                {{-- <input type="hidden" class="pro_id" value="{{ $product->product_id }}"> --}}
                            </div>
                            <input type="hidden" name="review_id" value="{{ $review->review_id }}">
                            <textarea type="text" placeholder="Phản hồi khách hàng" name="comment" id="comment"
                                rows="4" " class="form-control mt-4">{{ $feedback->content ?? '' }}</textarea>
                            <div class="d-flex flex-col mt-3">
                                @if (isset($feedback->content))
                                    <button class="btn btn-primary p-2 mb-1" type="submit">Sửa</button>
                                @else
                                    <button class="btn btn-primary p-2 mb-1" type="submit">Gửi</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
