@extends('layouts.centered')

@section('module')
<div class="container d-flex align-items-center p-0">
    <div class="row justify-content-center w-100 m-0">
        <div class="col-lg-6 p-0">
        
            <x-striped-card>
                {{-- Card header --}}
                <div class="mb-4">
                    <span class="h5">
                        {{ __('Confirm password') }}
                    </span>
                </div>
            
                {{-- Card notice --}}
                <div class="mb-4">
                    <span>
                        {{ __('Please confirm your password before continuing.') }}
                    </span>
                </div>
                

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

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
                    
                    {{-- Recovery link --}}
                    <div class="form-group row m-0">
                        <div class="col-md px-0">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
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
