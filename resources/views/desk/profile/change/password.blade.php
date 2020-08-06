@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :hint="__('desk')"
        :title="__('Personal data')">
    </x-card-header>

    {{-- Errros --}}
    <x-alert-errors />
    
    <x-box class="mb-5">
        <x-box-header>
            {{ __('Change your password') }}
        </x-box-header>

        <form action="{{ url('desk/profile/password') }}" method="POST">
            @csrf
            @method('PUT')
            <x-input
                name="password"
                type="password" 
                :pre="__('Write a password')">
            </x-input>
            
            <x-input
                name="password_confirmation"
                type="password" 
                :pre="__('Confirm it')">
            </x-input>
            
            <x-submit-button
                :content="__('Change it')">
            </x-submit-button>
        </form>
    </x-box>
@endsection
