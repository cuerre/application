@extends('layouts.desk')



@section('module')
    {{-- Top title --}}
    <x-card-header
        :hint="__('desk')"
        :title="__('Delete your account')">
    </x-card-header>

    {{-- Errors --}}
    <x-alert-errors /> 
    
    <div class="mb-5">
        {{ __('In order to be clear, we will show you some information you should know') }} 
        {{ __('about what we will do with your data when you have gone.') }}
        {{ __('It is as simple as we delete everything with a delay because of technical reasons.') }}
    </div>


    <form action="{{ url('desk/profile') }}" method="POST">
        @csrf
        @method('DELETE')
        
        <x-box class="mb-5">
            <x-box-header>
                {{ __('What will be deleted') }}
            </x-box-header>
            <ul class="text-secondary">
                <li>{{ __('Your personal data') }}</li>
                <li>{{ __('Your QR statistic') }}</li>
                <li>{{ __('Your payment invoices') }}</li>
                <li>{{ __('All data related to you') }}</li>
            </ul>
        </x-box>

        <x-attention>
            {{ __('You must confirm your password to delete your account.') }}
        </x-attention>

        <x-input
            name="password"
            type="password" 
            :pre="__('Write your password')">
        </x-input>

        <x-submit-button
            :content="__('Delete my account')"
            :confirmation="__('Are you sure?')">
        </x-submit-button>
    </form>
@endsection
