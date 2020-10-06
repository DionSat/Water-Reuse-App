<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ URL::asset('/img/drop-water.jpg') }}" type="image/x-icon"/>
    <title>{{ config('app.name', 'Water Reuse Directory') }}</title>

    <!-- Scripts - for any compiled site-wide JS -->
    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <script src="{{URL::asset('/libraries/fontawesome.js')}}"></script>

    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <style>
        a.active {
            border-bottom: 2px solid #272525;
        }
        a.nav-link:hover:not(.active):not(.dropdown-toggle){
            border-bottom: 2px solid #a9a3a3;
        }
        a.nav-link:not(.active){
            border-bottom: 2px solid white;
        }
    </style>

    @stack("css")

    {{--Bootstrap--}}
    <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.min.css') }}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid mx-0 mx-lg-2 py-1 px-0">
                <a class="navbar-brand px-md-0 pb-md-0" href="{{ url('/') }}">
                    Water Reuse Permit App
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link mx-md-2 px-md-0 pb-md-0  @if (Route::current()->getName() == "overview") active @endif" href="{{route('overview')}}"> Overview </a>
                            </li>
                        @endauth
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "info") active @endif" href="{{ route('info') }}"> Information </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0  @if (Route::current()->getName() == "search") active @endif" href="{{ route('search') }}"> Search</a>
                        </li>

                        @auth
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "userSubmission") active @endif" href="{{ route('userSubmission') }}">{{ __('Submit a New Regulation') }}</a>
                        </li>
                        @endauth

                        @if (Auth::check() && Auth::user()->is_admin)
                            <li class="nav-item pl-3">
                                <span class="nav-link mx-md-2 px-md-0 pb-md-0">Admin:</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "admin") active @endif" href="{{ route('admin') }}"><i class="fas fa-tachometer-alt"></i> Dashboard </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "adminUserSubmissionView") active @endif" href="{{ route('adminUserSubmissionView') }}"><i class="fas fa-bars"></i> Submissions </a>
                            </li>

                        @endif
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0" href="https://www.recodenow.org/donate/" target="_blank" rel="noopener noreferrer"> <i class="fas fa-hands-helping"></i> Donate</a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "login") active @endif" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "register") active @endif" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link pb-md-0 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('submission') }}">
                                        My Submissions
                                    </a>
                                    <a class ="dropdown-item" href=" {{ route('account') }}">
                                        Account

                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('layouts.alerts')
            @yield('body')
        </main>
    </div>

    <script src="{{ URL::asset('/libraries/jquery-3.4.1.slim.min.js') }}"></script>
    <script src="{{ URL::asset('/libraries/popper.min.js') }}"></script>
    <script src="{{ URL::asset('/libraries/bootstrap.min.js') }}"></script>

    @stack("js")

</body>
</html>
