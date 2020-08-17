@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Tokens')"
        :hint="__('desk')">
        <x-link-button
            icon="add"
            :content="__('New')"
            :link="url('desk/tokens/creation')">
        </x-link-button>
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />


    <x-attention show>
        <p>
            {{ __('Tokens can be used to manage your QR codes using our API.') }} 
            {{ __('This is the easiest way to integrate our service into your application without pain.') }} 
        </p>
        <p>
            {{ __('Each token can make a max number of requests per hour.') }}
            {{ __('We recommend you to read our documentation to know more about how to use the API in minutes.') }}
        </p>
        <p>
            <a href="{{ url('documentation') }}" class="btn btn-light text-primary">
                {{ __('Read documentation') }} 
            </a>
        </p>
    </x-attention>
    

    @forelse ( $tokens as $token )
        <x-box class="mb-4">
            <div class="row">
                <div class="col text-muted">
                    <div class="d-inline">
                        <strong>{{ __('Token') }}</strong>
                        <x-token-active :active="$token->active"/>
                        <x-token-used-badge :token="$token->token" :rateLimit="$token->rate_limit"/>
                    </div>
                    <div>
                        {{ $token->name }}
                    </div>
                </div>
                <div class="col-xs-auto my-auto">
                    <x-token-options :id="$token->id" />
                </div>
            </div>
        </x-box>
    @empty
        <x-box>
            {{ __('Touch') }} 
            <kbd class="mx-2">+ {{ __('New') }}</kbd> 
            {{ __('on the top to create a new token') }}
        </x-box>
    @endforelse
    
@endsection
