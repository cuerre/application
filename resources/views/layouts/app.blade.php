<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Meta tags --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>
        {{ config('app.name') }}
    </title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Static styles CSS --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/material.css') }}">

    {{-- Embeded CSS --}}
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
            <div class="container py-2">
            
                {{-- Logo --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('imgs/logo-title.png') }}" style="max-height: 2rem; " class="align-middle mr-3"/>
                </a>
                
                {{-- Menu toggler --}}                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('pricing') }}">
                                Pricing 
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('documentation') }}">
                                Documentation
                            </a>
                        </li>
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
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>

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
        <main class="container-fluid d-flex flex-column m-0 px-0" style="min-height: 70vh !important;">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        <footer class="container-fluid bg-light mt-5 ">
            <div class="container text-muted pt-3">
                <div class="row p-3 justify-content-center">
                    <div class="col-auto mr-auto">
                        <span class="font-weight-bolder">Company</span>
                        {{--
                        <a href="/about" class="d-block small text-muted">About</a>
                        <a href="/press" class="d-block small text-muted">Press</a>
                        --}}
                    </div>
                    <div class="col-auto">
                        <span class="font-weight-bolder">Community</span>
                        <a href="/documentation/donations" class="d-block small text-muted">Donations</a>
                    </div>
                    <div class="col-auto ml-auto">
                        <span class="font-weight-bolder">Deeper</span>
                        <a href="/dashboard/support" class="d-block small text-muted">Support</a>
                        <a href="/documentation/faq" class="d-block small text-muted">FAQ</a>
                        <a href="/status" class="d-block small text-muted">Status</a>
                        <a href="/documentation/contracts/terms" class="d-block small text-muted">Terms</a>
                        <a href="/documentation/contracts/privacy" class="d-block small text-muted">Privacy</a>
                    </div>
                </div>
                <div class="row text-muted px-3 mb-5">
                    <div class="col">
                        <img src="{{ asset('imgs/logo-footer.png') }}" style="max-height: 1rem;" class="align-middle mr-2"/>
                    </div>
                </div>
            </div>
        </footer>
        

    </div>
    

    
    <!-- Scripts -->
    {{-- On production: npm run dev | npm run production --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- JS Custom --}}
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
            $('[data-toggle="tooltip"]').tooltip()
        });

        @stack('scripts')
    </script>
    
</body>
</html>
