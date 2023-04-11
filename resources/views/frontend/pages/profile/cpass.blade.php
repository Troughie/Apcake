@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="main-info bg-white rounded p-4">
        <h2>Change password</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('fail'))
            <div class="alert alert-danger">
                {{ session('fail') }}
            </div>
        @endif

        <form action="{{ route('user.update.pass', ['id' => Auth::id()]) }}" method="post">
            {!! csrf_field() !!}
            @method('POST')
            <label>Mật khẩu cũ</label></br>
            <input type="password" name="oldpassword" id="password" class="form-control" required></br>
            @error('oldpassword')
                <p class="error alert alert-danger">{{ $message }}</p>
            @enderror
            <label>Mật khẩu mới</label></br>
            <input type="password" name="newpassword" id="password" class="form-control" required></br>
            @error('newpassword')
                <p class="error alert alert-danger">{{ $message }}</p>
            @enderror
            <label>Xác nhận mật khẩu</label></br>
            <input type="password" name="confirmpassword" id="password" class="form-control" required></br>
            @error('confirmpassword')
                <p class="error alert alert-danger">{{ $message }}</p>
            @enderror
            <input type="submit" value="Update" class="btn btn-success"></br>
        </form>
    </div>
@endsection
