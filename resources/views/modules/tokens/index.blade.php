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

    {{-- New Token --}}
    @if(Session::has('message'))
        <x-alert type="success">
            {{ Session::get('message') }}
        </x-alert>
    @endif

    <x-attention>
        {{ __('Tokens are keys that can do actions in your name (they are basically you).') }} 
        {{ __("For security reasons we will show it just one time after creation.") }}
        {{ __("So save it in a safe place and if you think some token can be compromised, delete it.") }}
    </x-attention>
    
    @if ( count($tokens) > 0 )
        <x-box>
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
        </x-box>
    @else
        <x-card-empty-message>
            {{ __('Touch') }} 
            <kbd class="mx-2">
                + {{ __('New') }}
            </kbd> 
            {{ __('on the top to create a new token') }}
        </x-card-empty-message>
    @endif
    
    
@endsection
