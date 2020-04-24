@extends('layouts.app')



@push('styles.large')
    #registerAnimation {
        display: block !important;
    }
@endpush



{{-- Show/Hide password with Toggle --}}
@push('scripts')
    let togglePass = document.querySelector('#togglePass');
    let inputPass  = document.querySelector('#password');
    
    togglePass.addEventListener("change", function(){
        if(togglePass.checked){
            inputPass.type = "text"
        }else{
            inputPass.type = "password"
        }
    }, false);
@endpush



@section('content')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
        
            <x-striped-card>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    {{-- Card header --}}
                    <div class="mb-4">
                        <span class="h5">
                            {{ __('Create new account') }}
                        </span>
                    </div>

                    {{-- Name field --}}
                    <div class="row py-2">
                        <div class="col-md">
                            <x-input
                                name="name"
                                type="text" 
                                :label="__('Name(entire)')">
                            </x-input>
                        </div>
                    </div>

                    {{-- Email field --}}
                    <div class="row py-2">
                        <div class="col-md">
                            <x-input
                                name="email"
                                type="email" 
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
                                :label="__('Password')">
                            </x-input>
                        </div>
                    </div>
                    
                    {{-- See password toggle --}}
                    <div class="d-flex justify-content-end custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="togglePass">
                        <label class="custom-control-label" for="togglePass"></label>
                        <i class="material-icons align-middle my-auto text-muted">visibility</i>
                    </div>
                    
                    {{-- Submit button --}}
                    <div class="row pt-3 pb-0 mb-0">
                        <div class="col-md">
                            <x-submit-button 
                                :content="__('Register')"
                                size="lg">
                            </x-submit-button>
                        </div>
                    </div>
                    
                    {{-- Terms and conditions --}}
                    <div class="small">
                        {{ __('By registering, you accept our TOS and our Privacy Policy') }}
                    </div>
                </form>
            
                {{-- Oauth providers --}}
                <!--
                <div class="bg-white py-4">
                    <div class="row p-3">
                        <div class="col-lg d-flex justify-content-center my-1">
                            <button type="button" class="btn btn-lg btn-block btn-danger" disabled>
                                <span class="small">
                                    {{ __('Sign up with Google') }}
                                </span>
                            </button>
                        </div>
                        <div class="col-lg d-flex justify-content-center my-1">
                            <button type="button" class="btn btn-lg btn-block btn-dark" disabled>
                                <span class="small">
                                    {{ __('Sign up with Github') }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                -->
            </x-striped-card>
        </div>
        <div class="col"></div>
        <div class="col-lg-5 p-3">
            <img id="registerAnimation" src="{{ asset('imgs/animations/report.gif') }}" class="d-none w-100 align-self-center"/>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-light border-0">
                    <h5 class="mb-1">{{ __('What you get with us') }}</h5>
                </li>
                <li class="list-group-item bg-light border-0">
                    <i class="material-icons align-middle">check_circle_outline</i>
                    {{ __('Generate QR codes') }}
                </li>
                <li class="list-group-item bg-light border-0">
                    <i class="material-icons align-middle">check_circle_outline</i>
                    {{ __('Set targets for your ads') }}
                </li>
                <li class="list-group-item bg-light border-0">
                    <i class="material-icons align-middle">check_circle_outline</i>
                    {{ __('Reuse QR between campaigns') }}
                </li>
                <li class="list-group-item bg-light border-0">
                    <i class="material-icons align-middle">check_circle_outline</i>
                    {{ __('Vitamin stats about your visits') }}
                </li>
            </ul>
        </div>
        
    </div>
</div>
@endsection
