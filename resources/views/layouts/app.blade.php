<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >-->
    
    <!-- Bugfixes for Google Material Icons -->
    <style>
        /* Rules for sizing the icon. */
        .material-icons.md-18 { font-size: 18px; }
        .material-icons.md-24 { font-size: 24px; }
        .material-icons.md-36 { font-size: 36px; }
        .material-icons.md-48 { font-size: 48px; }

        /* Rules for using icons as black on a light background. */
        .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
        .material-icons.md-dark.md-inactive { color: rgba(0, 0, 0, 0.26); }

        /* Rules for using icons as white on a dark background. */
        .material-icons.md-light { color: rgba(255, 255, 255, 1); }
        .material-icons.md-light.md-inactive { color: rgba(255, 255, 255, 0.3); }
    </style>
    
    <!-- Custom CSS -->
    <style>
        /*
         * Extra small devices (portrait phones, less than 576px)
         * No media query for `xs` since this is the default in Bootstrap
         */
        @stack('styles.phone.portrait')
        
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) { 
            @stack('styles.phone.landscape')
        }

        /* Medium devices (tablets, 768px and up)*/
        @media (min-width: 768px) {
            @stack('styles.tablet')
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 
            @stack('styles.large')
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) { 
            @stack('styles.extra')
        }
    </style>
    @stack('styles')
    
</head>
<body class="bg-light">
    <div id="app">
    
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top d-flex flex-column" >
            <div class="container">
            
                {{-- Logo --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('imgs/logo-title.png') }}" style="max-height: 2.5rem; " class="align-middle mr-3"/>
                    <span class="text-primary font-weight-bold text-uppercase align-middle" style="font-size: 2.5rem;">
                        {{-- config('app.name') --}}
                    </span>
                </a>
                
                {{-- Menu toggler --}}                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                    
                        {{-- Authentication Links --}}
                        @guest
                            @if(Route::currentRouteName() !== 'login' )
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary mr-2" href="{{ route('login') }}">
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register') && Route::currentRouteName() !== 'register')
                                <li class="nav-item">
                                    <a class="btn btn-primary mr-2" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
        

        {{-- Content --}}
        <main class="container-fluid d-flex py-5" style="min-height: 70vh !important;">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        <footer class="container mt-5 text-muted">
            <div class="row p-3">
                <div class="col">
                    <span class="font-weight-bolder">Company</span>
                    <a href="/blog" class="d-block">Blog</a>
                    <a href="/about" class="d-block">About</a>
                    <a href="/about" class="d-block">Press</a>
                    
                </div>
                <div class="col">
                    <span class="font-weight-bolder">Community</span>
                    <a href="/faq" class="d-block">FAQ</a>
                    <a href="/donations" class="d-block">Donations</a>
                    <a href="/achetronic" class="d-block">Achetronic</a>
                </div>
                <div class="col">
                    <span class="font-weight-bolder">Deeper</span>
                    <a href="/support" class="d-block">Support</a>
                    <a href="/status" class="d-block">Status</a>
                    <a href="/pricing" class="d-block">Pricing</a>
                    <a href="/terms" class="d-block">Terms</a>
                    <a href="/privacy" class="d-block">Privacy</a>
                </div>
            </div>
            <div class="row text-muted p-3">
                <div class="col-md-6 pb-3">
                    <img src="{{ asset('imgs/logo-title.png') }}" style="max-height: 1.5rem;" class="align-middle mr-2"/>
                    <span class="text-muted font-weight-bold text-uppercase align-middle" style="font-size: 1.5rem;">
                        {{-- config('app.name') --}}
                    </span>
                </div>
                <div class="col-md-6 pb-3">
                                        
                </div>
            </div>
        </footer>
        
        
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        @stack('scripts')
    </script>
    
    
</body>
</html>
