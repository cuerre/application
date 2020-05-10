@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Billing"
        hint="dashboard">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Message bag --}}
    @if( Session::has('message') )
        <x-alert 
            type="warning">
            {{ Session::get('message') }}
        </x-alert>
    @endif

    <code>{{ __('ATTENTION') }}</code>
    <p class="mb-5 text-break text-muted">
        {{ __('Credits are the coins you need to use our premium services.') }} 
        {{ __('You can buy the amount you need and they will be added to your account.') }} 
        {{ __('Each day, some of them will be substracted in order to pay.') }} 
    </p>

    {{-- Remaining credits --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Remaining credits') }}
            </h5>
            <p class="h2 my-3 text-break text-muted">
                {{ Auth::user()->credits }} €
            </p>
        </div>
    </div>

    {{-- Buy credits --}}
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Buy credits') }}
            </h5>
            <p class="text-break text-muted mb-4">
                {{ __('We trust PayPal as provider because it is safer than others for our customers.') }} 
                {{ __('Use your Paypal account or a credit card into PayPal to pay.') }} 
            </p>
            <form method="POST" action="{{ route('payment') }}">
                @csrf

                {{-- Name --}}
                <x-input
                    name="credits" 
                    type="text" 
                    :pre="__('Enter EUR amount')">
                </x-input>

                {{-- Submit button --}}
                <div class="d-flex justify-content-end">
                    <x-submit-button 
                        content="Continue to PayPal">
                    </x-submit-button>
                </div>

            </form>

            
            <div class="row align-items-center justify-content-end">
                <div class="col-lg-auto d-flex justify-content-center">
                    <img 
                        src="{{ asset('imgs/payment/paypal.png') }}" 
                        class="mx-auto" 
                        style="max-width: 5rem !important; filter: opacity(50%);">
                    </img>
                </div>
            </div>
            

        </div>
    </div>


    {{-- Credit payments --}}
    {{--
    <div class="row my-3 shadow-sm">
        <div class="col-lg bg-light p-4">
            <h5 class="text-muted">
                {{ __('Invoices') }}
            </h5>
            <p class="h2 my-3 text-break text-muted">
                $ 120
            </p>
        </div>
    </div>
    --}}


    
    

@endsection
