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
                    <div class="form-group row">
                        <div class="col-md">
                            <label for="email" class="text-md-right small font-weight-bolder">
                                {{ __('E-Mail Address') }}
                            </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-sm py-4" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                            <label for="email" class="text-md-right small font-weight-bolder">
                                {{ __('Password') }}
                            </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-sm py-4" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                    <div class="form-group row my-4">
                        <div class="col-md d-flex justify-content-end">
                            <button type="submit" class="btn btn-block btn-lg btn-primary">
                                {{ __('Login') }}
                            </button>
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
