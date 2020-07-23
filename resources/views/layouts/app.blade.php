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

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('imgs/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('imgs/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('imgs/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('imgs/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('imgs/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('imgs/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('imgs/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('imgs/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('imgs/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('imgs/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('imgs/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('imgs/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Static styles CSS --}}
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        <x-web-navbar/>
        

        {{-- Content --}}
        <main class="container-fluid d-flex flex-column m-0 px-0" style="min-height: 70vh !important;">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        <x-web-footer/>
        
    </div>
    

    
    <!-- Scripts -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @include('cookieConsent::index')
    
    {{-- On production: npm run dev | npm run production --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- JS Custom --}}
    <script>
        $(function () {
            $('.collapse').collapse('hide');
            $('[data-toggle="popover"]').popover()
            $('[data-toggle="tooltip"]').tooltip()
        });

        @stack('scripts')
    </script>

</body>
</html>
