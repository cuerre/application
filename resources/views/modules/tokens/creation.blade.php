@extends('layouts.dashboard')



@section('module')

    {{-- Top title --}}
    <x-card-header
        title="New token"
        hint="dashboard">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- New Token --}}
    @if(Session::has('message'))
        <x-alert type="success">
            <p class="font-weight-bold">Your new token is:</p>
            {{ Session::get('message') }}
        </x-alert>
    @endif

    <x-attention>
        {{ __('Tokens are keys that can do actions in your name (they are basically you).') }} 
        {{ __("For security reasons we will show it just one time after creation.") }}
        {{ __("So save it in a safe place and if you think some token can be compromised, delete it.") }}
    </x-attention>
    
    <form action="{{ url('dashboard/tokens') }}" method="POST">
        @csrf
        {{-- Name --}}
        <x-input
            name="name" 
            type="text" 
            pre="Give it a name">
        </x-input>
        {{-- Submit button --}}
        <div class="d-flex justify-content-end">
            <x-submit-button 
                content="Create!">
            </x-submit-button>
        </div>
    </form>
    
@endsection