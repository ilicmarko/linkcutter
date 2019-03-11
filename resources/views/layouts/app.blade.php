<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="c-main-nav"><img class="c-main-nav__logo" src="{{asset('images/logo_color.svg')}}">
            <ul class="c-main-nav__list">
                <li class="c-main-nav__item"><a class="c-main-nav__link--active c-main-nav__link" href="{{ url('/') }}">Home</a></li>
                <li class="c-main-nav__item"><a class="c-main-nav__link" href="{{ url('/#pricing') }}">Pricing</a></li>
            </ul>
            <ul class="c-main-nav__list c-main-nav__list--right">
                @guest
                    <li class="c-main-nav__item"><a class="c-main-nav__link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li class="c-main-nav__item"><a class="c-main-nav__link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    <li class="c-main-nav__item c-main-nav__dropdown"><a class="c-main-nav__link" href="#">{{ Auth::user()->name }}</a>
                        <ul class="c-main-nav__dropdown-menu">
                            @if (Auth::user()->subscribed())
                                <li><span class="c-main-nav__dropdown-link"><small>{{ Auth::user()->subscriptionName() }}</small></span></li>
                            @endif
                            <li><a class="c-main-nav__dropdown-link" href="{{ route('profile.view') }}">Account</a></li>
                            <li>
                                <a class="c-main-nav__dropdown-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="c-main-nav__item"><a class="c-main-nav__link" href="{{ route('dashboard.home') }}">Dashboard</a></li>
                    @if (Auth::user()->admin === 1)
                        <li class="c-main-nav__item"><a class="c-main-nav__link" href="{{ route('admin') }}">{{ __('Admin') }}</a></li>
                    @endif
                @endguest
            </ul>
        </nav>

        @include('layouts.alert-upgrade')
        @include('layouts.success')
        @include('layouts.errors')

        <main class="wrapper">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')

</body>
</html>
