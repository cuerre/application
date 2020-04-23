@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
            <div class="card w-100 rounded border-0">

                <div class="card-body bg-white text-dark shadow-sm rounded border-0 p-5">
                
                    {{-- Card header --}}
                    <div class="mb-4">
                        <span class="h5">
                            {{ __('Reset password') }}
                        </span>
                    </div>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email field --}}
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="email" class="text-md-right small font-weight-bolder">
                                    {{ __('Email address') }}
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password field confirmation --}}
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="email" class="text-md-right small font-weight-bolder">
                                    {{ __('Confirm password') }}
                                </label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Submit button --}}
                        <div class="form-group row py-4 mb-0">
                            <div class="col-md">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span>
                                        {{ __('Reset password') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
