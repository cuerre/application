@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Profile"
        hint="dashboard">
    </x-card-header>
    
    <x-alert-errors/>
    
    <x-box>
        <x-box-header>
            {{ __('Your personal data') }}
        </x-box-header>
        <x-action-list>
            <x-action-list-item
                :field="__('Name')" 
                :value="$profile['name']">
                <x-link-button
                    icon="edit"
                    content="Edit"
                    :link="url('dashboard/profile/change/name')">
                </x-link-button>
            </x-action-list-item>
            
            <x-action-list-item
                :field="__('Password')" 
                value="******">
                <x-link-button
                    icon="edit"
                    content="Edit"
                    :link="url('dashboard/profile/change/password')">
                </x-link-button>
            </x-action-list-item>
            
            <x-action-list-item
                :field="__('Email address')" 
                :value="$profile['email']">
            </x-action-list-item>
        </x-action-list>
    </x-box>
    
    {{-- Close account --}}
    <x-attention>
        {{ __('This action is permanent and can not be undone.') }}
        {{ __('After clicking the button, we really destroy your data to protect your privacy.') }}
        {{ __('If you find any problem doing this action, please, contact us to help you.') }}
    </x-attention>
    <x-box>
        <x-box-header>
            {{ __('You are part of this') }}
        </x-box-header>
        <p class="text-secondary">
            {{ __('We dont want you to go and would love to keep you with us') }}
            {{ __('because we are preparing great things for the future to make our service better.') }}
            {{ __('We have the mission to draw better QR codes for using them everywhere and you are part of it.') }}
            {{ __('If you would like to delete your account, click on the bottom link.') }}
        </p>
        <div class="mt-5">
            <a href="{{ url('dashboard/profile/deletion') }}">
                {{ __('Delete account') }}
            </a>
        </div>
    </x-box>
    
@endsection
