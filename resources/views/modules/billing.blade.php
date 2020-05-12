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

    {{-- Remaining credits --}}
    <x-remaining-credits/>

    {{-- Buy credits --}}
    <x-buy-credits/>

    {{-- History --}}
    <x-billing-history />
    

@endsection
