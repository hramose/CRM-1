<!doctype html>
<html lang="en" ng-app="CRM">
<head>
    <meta charset="UTF-8">
    <title>CRM Light</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="stylesheet" href="/content/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/content/css/style.css">

    <script src="/content/angular/angular.js"></script>
    <script src="/content/angular-route/angular-route.min.js"></script>

     @yield('js', '')

</head>
<body id="body">

        <div class="container">

        @if(Session::has('global'))
            <div class="alert alert-warning">
                {{ Session::get('global') }}
            </div>
        @endif

        @include('layout.navigation')

        @yield('content', '')

        </div>

    </div>
</body>
</html>