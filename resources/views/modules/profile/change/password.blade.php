@extends('layouts.dashboard')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :title="__('Change your password')"
        :hint="__('dashboard')">
    </x-card-header>
    
    <form action="{{ url('dashboard/profile/password') }}" method="POST">
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
@endsection
