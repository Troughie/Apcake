@extends('backend.Layout.index')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">User Page</div>
        <div class="card-body">
            <div class="card-body">
                <h5 class="card-title">Name : {{ $user->name }}</h5>
                <br>
                <p class="card-text">Email : {{ $user->email }}</p>
                <p class="card-text">Address : {{ $user->deliveryAddress->address ?? '' }}</p>
                <p class="card-text">Mobile : {{ $user->deliveryAddress->phone ?? '' }}</p>
                <p class="card-text">TotalAmount : {{ $user->orders->sum('totalAmount') ?? '' }}</p>
                <p class="card-text">Status :
                    @if ($user->orders->firstwhere('user_id', $user->user_id) == '')
                        <span>Chua do don hang</span>
                    @else
                        {{ $user->orders->firstwhere('user_id', $user->user_id)->count() ?? '' }}
                    @endif
                </p>
            </div>
        @endsection
