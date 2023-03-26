@extends('backend.Layout.index')
@section('content')
    <div class="card">
        <div class="card-header">Product Page
            <div class="card-body">
                <p class="card-text">Name : {{ $product->name }}</p>
                {{-- <p class="card-text">Category : {{ $categories->category_name }}</p> --}}
                <p class="card-text">price : {{ $product->price }}</p>
                <p class="card-text">Quantity : {{ $product->quantity }}</p>
                <p class="card-text">description : {{ $product->description }}</p>
            </div>
        </div>
    </div>
@endsection
