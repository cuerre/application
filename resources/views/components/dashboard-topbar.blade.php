<div class="sticky-top p-0">


        <div class="row m-0 p-0 align-items-center bg-white shadow-sm"
             style="height: 5rem !important;">
            <div class="col">
                @unless( empty($slot) ) {{ $slot }} @endunless
            </div>
            <div class="col-auto">
                <div class="d-flex justify-content-center align-items-center">

                    {{-- Cost per day --}}
                    <x-dashboard-user-balance-box/>
                
                    {{-- Authentication Links --}}
                    @guest
                        
                        <div>
                            <a class="btn btn-outline-primary mr-2" href="{{ route('login') }}">
                                {{ __('Login') }}
                            </a>
                            <a class="btn btn-primary mr-2" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        </div>
                    @else
                        <x-dashboard-user-dropdown/>
                    @endguest

                </div>
            </div>
        </div>

</div>
