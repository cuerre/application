<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
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
        

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) { 
        
        }

        /* Medium devices (tablets, 768px and up)*/
        @media (min-width: 768px) { 
        
            
            #sidePanel {
                display: block !important;
            }
            
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 
        
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) { 
        
        }
    </style>
    
    @stack('styles')
    
</head>
<body class="bg-dark">
    <div id="app">
    
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-transparent">
            <div class="container">
            
                {{-- Logo --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="text-light font-weight-bold text-uppercase" style="font-size: 1.5rem;">
                        { {{ config('app.name') }} }
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
                            <li class="nav-item">
                                <a class="btn btn-outline-light text-light mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-outline-light text-light mr-2" href="{{ route('register') }}">{{ __('Register') }}</a>
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
        <main class="py-4 min-vh-100">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        <footer class="container p-5">
            <div class="row text-muted">
                <div class="col-md-6 pb-3">
                    <span class="text-muted font-weight-bold text-uppercase" style="font-size: 1.5rem;">
                        { {{ config('app.name') }} }
                    </span>
                </div>
                <div class="col-sm">
                    <a href="/blog" class="text-reset d-block">Blog</a>
                    <a href="/about" class="text-reset d-block">About</a>
                    <a href="/contact" class="text-reset d-block">Contact us</a>
                    <a href="/pricing" class="text-reset d-block">Pricing</a>
                </div>
                <div class="col-sm">
                    <a href="/status" class="text-reset d-block">Status</a>
                    <a href="/help" class="text-reset d-block">Help</a>
                </div>
                <div class="col-sm">
                    <a href="/terms" class="text-reset d-block">Terms</a>
                    <a href="/privacy" class="text-reset d-block">Privacy</a>
                </div>
            </div>
        </footer>
        
        
    </div>
</body>
</html>
