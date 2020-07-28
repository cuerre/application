<div class="sticky-top">
    <div class="d-flex align-items-center bg-white px-4 shadow-sm" 
        style="height: 5rem !important;">
        <div class="h5 font-weight-light">
            @unless( empty($sentence) ) {{ $sentence }} @endunless
        </div>
        <div class="ml-auto">
            {{-- Authentication Links --}}
            @guest
                @if(Route::currentRouteName() !== 'login' )
                    <a class="btn btn-outline-primary mr-2" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                @endif
                @if (Route::has('register') && Route::currentRouteName() !== 'register')
                    <a class="btn btn-primary mr-2" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                @endif
            @else
                <x-dashboard-user-dropdown/>
            @endguest
        </div>
    </div>
    <!--<div class="p-1 bg-primary rounded-bottom m-0 shadow-sm"></div>-->
</div>
