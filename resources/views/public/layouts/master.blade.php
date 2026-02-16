<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle')</title>
</head>
<body>

    @yield('content')

</body>
</html>
