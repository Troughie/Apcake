@extends('backend.Layout.index')
@section('content')
    {{-- <div class="card" style="margin:20px;">
        <div class="card-header">User Page</div>
        <div class="card-body">
            <div class="card-body">
                <h5 class="card-title">Name : {{ $user->name }}</h5>
                <br>
                <p class="card-text">Email : {{ $user->email }}</p>
                <p class="card-text">Address : {{ $user->deliveryAddress->address ?? '' }}</p>
                <p class="card-text">Mobile : {{ $user->deliveryAddress->phone ?? '' }}</p>
                <p class="card-text">Số tiền đã mua : {{ $user->orders->sum('totalAmount') ?? '' }}</p>
                <p class="card-text"> Số đơn hàng :
                    @if ($user->orders->firstwhere('user_id', $user->user_id) == '')
                        <span>Chua do don hang</span>
                    @else
                        {{ $user->orders->firstwhere('user_id', $user->user_id)->count() ?? '' }}
                    @endif
                </p>
            </div> --}}
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
                        <p class="card-text text-center">{{ $user->deliveryAddress->address ?? '' }}</p>
                        <p class="card-text text-center">{{ $user->deliveryAddress->phone ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile Information</h5>
                        <div class="row">
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
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="card-text"><strong>Ranking:</strong> 4.5 / 5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
