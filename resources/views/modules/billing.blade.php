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
    <x-remaining-credits/>

    {{-- Buy credits --}}
    <x-buy-credits/>
    

@endsection
