<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Система аутентификации</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="stylesheet" href="/content/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/content/style.css">

</head>
<body>

        <div class="container">

        @if(Session::has('global'))
            <div class="alert alert-warning">
                {{ Session::get('global') }}
            </div>
        @endif

        @include('layout.navigation')

        @yield('content')

        </div>

    </div>
</body>
</html>