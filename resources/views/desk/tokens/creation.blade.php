@extends('layouts.desk')



@section('module')

    {{-- Top title --}}
    <x-card-header
        :title="__('New token')"
        :hint="__('desk')">
    </x-card-header>



    {{-- Errors --}}
    <x-alert-errors /> 



    {{-- New Token --}}
    @if(Session::has('message'))
        <x-alert type="success">
            <p class="font-weight-bold">{{ __('Your new token is') }}:</p>
            {{ Session::get('message') }}
        </x-alert>
    @endif



    <x-attention show>
        {{ __('Tokens are keys that can do actions in your name (they are basically you).') }} 
        {{ __("For security reasons we will show it just one time after creation.") }}
        {{ __("So save it in a safe place and if you think some token can be compromised, delete it.") }}
    </x-attention>
    


    <x-box>

        <form action="{{ url('desk/tokens') }}" method="POST">

            @csrf

            {{-- Name --}}
            <div class="mb-5">
                <x-box-header>{{ __('Name') }}</x-box-header>
                <x-input
                    name="name" 
                    type="text" 
                    :pre="__('Give it a name')">
                </x-input>
            </div>

            {{-- Submit button --}}
            <div class="d-flex justify-content-end">
                <x-submit-button 
                    :content="__('Create token')"
                    block>
                </x-submit-button>
            </div>
        </form>

    </x-box>
    
@endsection