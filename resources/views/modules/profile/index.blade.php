@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        title="Profile"
        hint="dashboard">
    </x-card-header>
    
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
    
    {{-- Close account --}}
    <div class="mt-5">
        <a href="#">
            {{ __('Delete account') }}
        </a>
    </div>
    
@endsection
