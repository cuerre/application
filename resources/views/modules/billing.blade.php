@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Billing')"
        :hint="__('dashboard')">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    {{-- Remaining credits --}}
    <x-remaining-credits/>

    {{-- Buy credits --}}
    <x-buy-credits/>

    {{-- History --}}
    <x-billing-history />
    

@endsection
