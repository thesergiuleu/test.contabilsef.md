<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.header')
<body>
    <div>
        @yield('content')
    </div>
    @include('layouts.footer')
</body>
</html>
