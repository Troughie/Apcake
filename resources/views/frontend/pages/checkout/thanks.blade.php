@extends('layouts.master')
@section('main-content')
    <div class="jumbotron text-center">
        <h1 class="display-3">Thank You!</h1>
        <p class="lead"><strong>Please check your email</strong> for see a invoice.</p>
        <hr>
        <p>
            Having trouble? <a href="{{ route('contact') }}">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{ route('shop') }}" role="button">Continue to shopping</a>
        </p>
    </div>
@endsection
