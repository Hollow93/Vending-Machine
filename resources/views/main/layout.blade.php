<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('favicon')

    <title>@yield('title')</title>

    @yield('style')

    @yield('js')

</head>
<body>

@yield('content')

</body>
</html>