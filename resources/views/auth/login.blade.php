@extends('layouts.app')



@push('styles.large')
    #loginAnimation {
        display: block !important;
    }
@endpush



@section('content')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
        
            <x-striped-card>
                
                {{-- Card header --}}
                <div class="mb-4">
                    <span class="h5">
                        {{ __('Welcome back to Cuerre') }}
                    </span>
                </div>
            
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email field --}}
                    <div class="row">
                        <div class="col-md">
                           <x-input
                                name="email"
                                type="email" 
                                pre="Give it a name"
                                :label="__('Email address')">
                            </x-input>
                        
                        </div>
                    </div>

                    {{-- Password field --}}
                    <div class="row">
                        <div class="col-md">
                            <x-input
                                name="password"
                                type="password" 
                                pre="Give it a name"
                                :label="__('Password')">
                            </x-input>
                        </div>
                    </div>
                    
                    {{-- See remember toggle --}}
                    <div class="d-flex justify-content-end custom-control custom-switch">
                        <input name="remember" type="checkbox" class="custom-control-input" id="toggleRemember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="toggleRemember">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    {{-- Submit button --}}
                    
                    <div class="row my-4">
                        <div class="col-md d-flex justify-content-end">
                            <x-submit-button 
                                :content="__('Sign In')"
                                size="lg" 
                                block>
                            </x-submit-button>
                        </div>
                    </div>
                    
                    {{-- Recovery link --}}
                    <div class="form-group row m-0">
                        <div class="col-md px-0">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Register link --}}
                    <div class="form-group row m-0">
                        <div class="col-md px-0">
                            @if (Route::has('register'))
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Create account') }}
                                </a>
                            @endif
                        </div>
                    </div>

                </form>
            </x-striped-card>
        </div>
    </div>
</div>
@endsection
