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
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Email field --}}
                        <div class="form-group row">
                            <div class="col-md">
                                <label for="email" class="text-md-right small font-weight-bolder">
                                    {{ __('Email address') }}
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-sm py-4" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit button --}}
                        <div class="form-group row py-4 mb-0">
                            <div class="col-md">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span>
                                        {{ __('Send reset link') }}
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
