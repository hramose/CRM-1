<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Система аутентификации</title>
</head>
<body>
    @if(Session::has('global'))
        <p>{{ Session::get('global') }}</p>
    @endif

    @include('layout.navigation')
    @yield('content')
</body>
</html>