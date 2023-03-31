@extends('backend.Layout.index')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Edit Student</div>
        <div class="card-body">

            <form action="{{ route('admin.users.update', $user->user_id) }}" method="post">
                {!! csrf_field() !!}
                @method('POST')
                <input type="hidden" name="user_id" id="user_id" value="{{ $user->user_id }}" />
                <label>Name</label></br>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control"></br>
                <label>Email</label></br>
                <input type="text" name="email" id="email" value="{{ $user->email }}" readonly
                    class="form-control"></br>
                <label>Role</label></br>
                <input type="radio" name="role" id="role" @if ($user->role === 'USR') checked @endif
                    class="radio-inline" value="USR">USER </br>
                <input type="radio" name="role" id="role" @if ($user->role === 'ADC') checked @endif
                    class="radio-inline" value="ADC">Author </br>
                <input type="submit" value="Update" class="btn btn-success"></br>
            </form>

        </div>
    </div>
@endsection
