@extends('layouts.centered')

@section('module')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
        
            <x-striped-card>
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
                    <div class="row">
                        <div class="col-md">
                            <x-input
                                name="email"
                                type="email" 
                                :label="__('Email address')">
                            </x-input>
                            {{-- $email ?? old('email') --}}
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

                    {{-- Password field confirmation --}}
                    <div class="row">
                        <div class="col-md">
                            <x-input
                                name="password_confirmation"
                                type="password" 
                                :label="__('Confirm password')">
                            </x-input>
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <div class="form-group row py-4 mb-0">
                        <div class="col-md">
                            <x-submit-button 
                                :content="__('Reset password')"
                                size="lg">
                            </x-submit-button>
                        </div>
                    </div>
                    
                </form>
            </x-striped-card>
        </div>
    </div>
</div>
@endsection
