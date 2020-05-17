@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Tokens')"
        :hint="__('dashboard')">
        <x-link-button
            icon="add"
            :content="__('New')"
            :link="url('dashboard/tokens/creation')">
        </x-link-button>
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- Messages bag --}}
    <x-alert-messages />


    <x-attention>
        <p>
            {{ __('Tokens are keys that can do actions in your name (they are basically you).') }} 
            {{ __("For security reasons we will show it just one time after creation.") }}
            {{ __("So save it in a safe place and if you think some token can be compromised, delete it.") }}
        </p>
        <p>
            {{ __('Tokens can be used to generate or read QR codes for your application using our API.') }} 
            {{ __('This service is the easiest way to integrate QR without pain.') }} 
        </p>
        <p>
            <code>{{ __('As a premium service') }},</code> 
            {{ __('we allow you to generate tokens. They are billed daily.') }}
            {{ __('This means you only pay for them if they have been used in the last day.') }}
            <ul>
                <li>
                    {{ __('Each token can make a max number of requests per hour (currently 1k).') }} 
                </li>
                <li>
                    {{ __('They will be deleted if not enough credits to pay for it.') }} 
                    {{ __('The system tries to pay for older ones first, deleting newer when no credits.') }}
                </li>
            </ul>
            
            <p class="mt-3">
                <x-link-button
                    :content="__('Check the prices')"
                    :link="url('pricing')"
                    size="sm" 
                    color="light">
                </x-link-button>
            </p>
        </p>
    </x-attention>
    

    @forelse ( $tokens as $token )
        <x-box>
            <div class="row">
                <div class="col-sm text-muted">
                    <div class="d-inline">
                        <strong>{{ __('Token') }}</strong>
                        <x-token-used-badge :last="$token->last_used_at" />
                    </div>
                    <div>
                        {{ $token->name }}
                    </div>
                </div>
                <div class="col-auto">
                    <form action="{{ url('dashboard/tokens') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input name="id" type="hidden" value="{{ $token->id }}">
                        <x-submit-button
                            :content="__('Delete')"
                            :confirmation="__('Sure deleting this?')" 
                            color="primary">
                        </x-submit-button>
                    </form>
                </div>
            </div>
        </x-box>
    @empty
        <x-card-empty-message>
            {{ __('Touch') }} 
            <kbd class="mx-2">
                + {{ __('New') }}
            </kbd> 
            {{ __('on the top to create a new token') }}
        </x-card-empty-message>
    @endforelse
    
@endsection
