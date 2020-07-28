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



    <x-attention>
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

            {{-- Options --}}
            <div class="mb-5">
                <x-box-header>{{ __('Abilities') }}</x-box-header>

                <ul class="list-group">
                    {{-- Option 1 --}}
                    <li class="list-group-item border-0 py-3">
                        <div class="row">
                            <div class="col-1 text-center">
                                <input class="form-check-input" 
                                       style="transform: scale(2);" 
                                       type="radio" 
                                       name="inlineRadioOptions" 
                                       value="{{ $abilities[0] }}"
                                       checked>
                            </div>
                            <div class="col-auto">
                                <p class="font-weight-bold text-capitalize text-muted">{{ __($abilities[0]) }}</p>
                                <p class="text-muted">
                                    {{ __('This allow you to create/read codes with random content at a fixed price per hour.') }}
                                </p>
                            </div>
                        </div>
                    </li>

                    {{-- Option 2 --}}
                    <li class="list-group-item border-0 py-3">
                        <div class="row">
                            <div class="col-1 text-center">
                                <input class="form-check-input" 
                                       style="transform: scale(2);" 
                                       type="radio" 
                                       name="inlineRadioOptions" 
                                       value="{{ $abilities[1] }}">
                            </div>
                            <div class="col-auto">
                                <p class="font-weight-bold text-capitalize text-muted">{{ __($abilities[1]) }}</p>
                                <p class="text-muted">
                                    {{ __('This ability is free to have and allows you to create vitamin codes at a fixed price per created code.') }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
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