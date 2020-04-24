@extends('layouts.app')

@section('content')

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
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email field --}}
                    <div class="row">
                        <div class="col-md">
                            <x-input
                                name="email"
                                type="email" 
                                :label="__('Email address')">
                            </x-input>
                        </div>
                    </div>

                    {{-- Submit button --}}
                    <div class="row py-4 mb-0">
                        <div class="col-md">
                            <x-submit-button 
                                :content="__('Send reset link')"
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
