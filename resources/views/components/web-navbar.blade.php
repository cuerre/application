<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top d-flex flex-column" >
    <div class="container py-2">
    
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('imgs/logo-title.png') }}" style="max-height: 2rem; " class="align-middle mr-3"/>
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