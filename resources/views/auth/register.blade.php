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
            
            <div class="card w-100 rounded border-0">
                
                <div class="card-body bg-white text-dark shadow-sm rounded border-0 p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        {{-- Card header --}}
                        <div class="mb-4">
                            <span class="h5">
                                {{ __('Create new account') }}
                            </span>
                        </div>

                        {{-- Name field --}}
                        <div class="form-group row py-2">
                            <div class="col-md">
                                <label for="name" class="text-md-right small font-weight-bolder">
                                    {{ __('Name (entire)') }}
                                </label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-control-sm py-4" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email field --}}
                        <div class="form-group row py-2">
                            <div class="col-md">
                                <label for="email" class="text-md-right small font-weight-bolder">
                                    {{ __('E-Mail Address') }}
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-sm py-4" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password field --}}
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="password" class="text-md-right small font-weight-bolder">
                                    {{ __('Password') }}
                                </label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-sm py-4" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- See password toggle --}}
                        <div class="d-flex justify-content-end custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="togglePass">
                            <label class="custom-control-label" for="togglePass"></label>
                        </div>
                        
                        {{-- Terms and conditions --}}
                        <div class="mt-4 small">
                            {{ __('By clicking the button, you accept our TOS and our Privacy Policy') }}
                        </div>

                        <div class="form-group row py-4 mb-0">
                            <div class="col-md">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span class="small">
                                        {{ __('Register') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
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
            </div>
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
