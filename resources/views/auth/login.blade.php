@extends('layouts.master')

@section('main-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Đăng nhập</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email đăng nhập</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Mật Khẩu</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            Ghi nhớ tài khoản
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Đăng nhập
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Bạn quên mật khẩu?
                                        </a>
                                    @endif
                                </div>
                                <div class="mx-auto mt-3 col-md-8">
                                    <div class="d-flex justify-content-center align-items-center ">
                                        <div class="border w-100"></div>
                                        <div class="mx-3" style="white-space: nowrap">Hoặc đăng nhập bằng</div>
                                        <div class="border w-100"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 align-items-center">
                                        <a href="{{ route('social', 'google') }}"><img class="mr-3" loading="lazy"
                                                src="https://cdn.divineshop.vn/static/0b314f30be0025da88c475e87a222e5a.svg"
                                                class="gb Pa" alt="Google"></a>
                                        <a href="{{ route('social', 'facebook') }}"><img loading="lazy"
                                                src="https://cdn.divineshop.vn/static/4ba68c7a47305b454732e1a9e9beb8a1.svg"
                                                class="gb Pa" alt="Facebook"></a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
