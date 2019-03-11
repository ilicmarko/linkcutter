<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <title>Admin</title>
</head>
<body>
    <div class="dashboard-content">
        @include('admin.layouts.sidebar')
        <div class="dashboard-container">
            @include('admin.layouts.errors')
            @include('admin.layouts.alert')

            @yield('content')
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>