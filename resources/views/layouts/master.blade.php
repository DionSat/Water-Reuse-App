<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ URL::asset('/img/drop-water.jpg') }}" type="image/x-icon"/>
    <title>{{ config('app.name', 'Water Reuse Directory') }}</title>

    <!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/38fcbdb4da.js" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato|Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sen&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@200&family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Roboto&display=swap" rel="stylesheet">


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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid mx-0 mx-md-2 mx-lg-4 py-1">
                <a class="navbar-brand px-md-0 pb-md-0" href="{{ url('/') }}">
                    Water Reuse Directory
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "info") active @endif" href="{{ route('info') }}">{{ __('Info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0  @if (Route::current()->getName() == "search") active @endif" href="{{ route('search') }}"> Search</a>
                        </li>

                        @auth
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('userSubmission') }}">{{ __('Submit a New Regulation') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mx-md-2 px-md-0 pb-md-0  @if (Route::current()->getName() == "search") overview @endif" href="{{route('overview')}}">{{__('Overview')}}</a>
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
                        <!-- Authentication Links -->
                        @guest

                        <li class="nav-item">
                            <button type="button" class="btn btn-primary padding-sm" href="https://www.recodenow.org/donate-test-page" > <i class="fas fa-hands-helping"></i> Donate</button>
                        </li>

                            <li class="nav-item">
                                <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "login") active @endif" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link mx-md-2 px-md-0 pb-md-0 @if (Route::current()->getName() == "register") active @endif" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else


                        <li class="nav-item">
                            <button type="button" class="btn btn-primary padding-sm" href="https://www.recodenow.org/donate-test-page" > <i class="fas fa-hands-helping"></i> Donate</button>
                        </li>

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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    @stack("js")

</body>
</html>
