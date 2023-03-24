<!-- Right Side Of Navbar -->
<!-- Authentication Links -->
@guest
    @if (Route::has('login'))
        <li class=" nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
    @endif

    @if (Route::has('register'))
        <li class="nav-item" style="margin-left: -20px">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
    @endif
@else
    <div class="btn-group">
        <a id="dropdownMenuLink" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item text-black-50" href="{{ route('user.profile', Auth::id()) }}">
                {{ __('Profile') }}
            </a>
            <a class="dropdown-item text-black-50" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
@endguest
