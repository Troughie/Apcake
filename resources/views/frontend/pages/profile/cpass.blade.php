@extends('frontend.pages.profile.layout')
@section('profile')
    <div class="main-info bg-white rounded p-4">
        <h2>Change password</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @else
            <div class="alert alert-error error">
                {{ session('fail') }}
            </div>
        @endif

        <form action="{{ route('user.update.pass', ['id' => Auth::id()]) }}" method="post">
            {!! csrf_field() !!}
            @method('POST')
            <label>Old password</label></br>
            <input type="password" name="oldpassword" id="password" class="form-control"></br>
            @error('oldpassword')
                <p class="error">{{ $message }}</p>
            @enderror
            <label>New password</label></br>
            <input type="password" name="newpassword" id="password" class="form-control"></br>
            @error('newpassword')
                <p class="error">{{ $message }}</p>
            @enderror
            <label>Confirm password</label></br>
            <input type="password" name="confirmpassword" id="password" class="form-control"></br>
            @error('confirmpassword')
                <p class="error">{{ $message }}</p>
            @enderror
            <input type="submit" value="Update" class="btn btn-success"></br>
        </form>
    </div>
@endsection
