<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('layouts.head')
<body>
    <div id="app">

        @include('layouts.nav')

        @yield('content')

    </div>
        @include('layouts.chatuser')
        @include('layouts.footer')
</body>
</html>
