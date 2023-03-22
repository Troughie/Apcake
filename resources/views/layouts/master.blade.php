<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
</head>

<body>
    @include('layouts.header')
    @yield('main-content')
    @include('layouts.footer')
</body>

</html>
