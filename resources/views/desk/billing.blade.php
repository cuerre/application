@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Billing')"
        :hint="__('desk')">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />

    {{-- Remaining credits --}}
    <x-billing-remaining-credits/>

    {{-- Buy credits --}}
    <x-billing-buy-credits/>

    {{-- History --}}
    <x-billing-history />
    

@endsection
