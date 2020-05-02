@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Tokens"
        hint="dashboard">
        <x-link-button
            icon="add"
            content="New"
            :link="url('dashboard/tokens/creation')">
        </x-link-button>
    </x-card-header>
    
    {{-- Errors --}}
    <x-alert-errors /> 

    {{-- New Token --}}
    @if(Session::has('message'))
        <x-alert type="success">
            {{ Session::get('message') }}
        </x-alert>
    @endif

    <code>{{ __('Attention') }}</code>
    <p class="mb-5 text-muted">
        {{ __('Tokens are keys that can do actions in your name (they are basically you).') }} 
        {{ __("For security reasons we will show it just one time after creation.") }}
        {{ __("So save it in a safe place and if you think some token can be compromised, delete it.") }}
    </p>

    @if ( count($tokens) > 0 )
        <x-action-list>
            @foreach ( $tokens as $token)
                <x-action-list-item
                    :field="__('Token')" 
                    :value='$token->name'>
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
                </x-action-list-item>
            @endforeach
        </x-action-list>
    @else
        <x-card-empty-message>
            Touch <kbd class="mx-2">+ New</kbd> on the top to create 
            a new token 
        </x-card-empty-message>
    @endif
    
@endsection
