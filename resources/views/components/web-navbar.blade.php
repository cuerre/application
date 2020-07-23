<nav class="bg-white shadow" role="navigation">
    <div class="container mx-auto p-4 flex flex-wrap items-center md:flex-no-wrap">

        {{-- Logo --}}
        <div class="mr-4 md:mr-8">
            <a href="#" rel="home">
                <img src="{{ asset('imgs/logo-title.png') }}" class="h-8" />
            </a>
        </div>


        <div class="ml-auto md:hidden">
            <button class="flex items-center px-3 py-2 border rounded" type="button">
                <svg class="h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                </svg>
            </button>
        </div>


        <div class="w-full md:w-auto md:flex-grow md:flex md:items-center">
            <ul class="flex flex-col mt-4 -mx-4 pt-4 border-t md:flex-row md:items-center md:mx-0 md:mt-0 md:pt-0 md:mr-4 lg:mr-8 md:border-0">
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4 hover:text-blue-500" href="{{ url('about') }}" title="Link">
                        {{ __('About') }}
                    </a>
                </li>
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4 hover:text-blue-500" href="{{ url('pricing') }}" title="Link">
                        {{ __('Pricing') }}
                    </a>
                </li>
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4 hover:text-blue-500" href="{{ url('documentation') }}" title="Link">
                        {{ __('Documentation') }}
                    </a>
                </li>
            </ul>

            
            <ul class="flex flex-col mt-4 -mx-4 pt-4 border-t md:flex-row md:items-center md:mx-0 md:ml-auto md:mt-0 md:pt-0 md:border-0">
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4" href="#" title="Link">Link</a>
                </li>
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4 text-purple-600" href="#" title="Active Link">Active Link</a>
                </li>
                <li>
                    <a class="block px-4 py-1 md:p-2 lg:px-4" href="#" title="Link">Link</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top d-flex flex-column">
    <div class="container py-2">

        {{-- Logo --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('imgs/logo-title.png') }}" style="max-height: 2rem; " class="align-middle mr-3" />
        </a>

        {{-- Menu toggler --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="{{ url('about') }}">
                        {{ __('About') }} 
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ url('pricing') }}">
                        {{ __('Pricing') }} 
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ url('documentation') }}">
                        {{ __('Documentation') }} 
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

                {{-- Authentication Links --}} @guest @if(Route::currentRouteName() !== 'login' )
                <li class="nav-item">
                    <a class="btn btn-outline-primary mr-2" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                </li>
                @endif @if (Route::has('register') && Route::currentRouteName() !== 'register')
                <li class="nav-item">
                    <a class="btn btn-primary mr-2" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                </li>
                @endif @else
                <x-user-dropdown/> @endguest
            </ul>
        </div>
    </div>
</nav>